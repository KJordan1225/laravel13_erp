<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SalesOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SalesOrderApiController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'order_date' => ['required', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:order_date'],
            'status' => ['required', 'in:draft,pending,approved,completed,cancelled'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'tax_rate' => ['nullable', 'numeric', 'min:0'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        return DB::transaction(function () use ($validated) {
            $subtotal = 0;

            foreach ($validated['items'] as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }

            $taxRate = $validated['tax_rate'] ?? 0;
            $taxAmount = $subtotal * ($taxRate / 100);
            $discountAmount = $validated['discount_amount'] ?? 0;
            $total = $subtotal + $taxAmount - $discountAmount;

            if ($total < 0) {
                throw ValidationException::withMessages([
                    'discount_amount' => 'Discount cannot be greater than subtotal plus tax.',
                ]);
            }

            $salesOrder = SalesOrder::create([
                'customer_id' => $validated['customer_id'],
                'user_id' => auth()->id,
                'order_number' => $this->generateOrderNumber(),
                'order_date' => $validated['order_date'],
                'due_date' => $validated['due_date'] ?? null,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'total' => $total,
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                $salesOrder->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'line_total' => $item['quantity'] * $item['unit_price'],
                ]);

                if ($validated['status'] === 'completed') {
                    $product->decrement('stock_quantity', $item['quantity']);
                }
            }

            return response()->json([
                'message' => 'Sales order created successfully.',
                'sales_order_id' => $salesOrder->id,
                'redirect_url' => route('sales-orders.show', $salesOrder),
            ], 201);
        });
    }

    private function generateOrderNumber(): string
    {
        $prefix = 'SO-' . now()->format('Ymd') . '-';

        $lastOrder = SalesOrder::where('order_number', 'like', $prefix . '%')
            ->latest('id')
            ->first();

        $nextNumber = 1;

        if ($lastOrder) {
            $lastSequence = (int) str_replace($prefix, '', $lastOrder->order_number);
            $nextNumber = $lastSequence + 1;
        }

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
