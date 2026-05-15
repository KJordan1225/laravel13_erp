<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InvoiceApiController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'invoice_date' => ['required', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:invoice_date'],
            'status' => ['required', 'in:draft,sent,paid,overdue,cancelled'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'tax_rate' => ['nullable', 'numeric', 'min:0'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'amount_paid' => ['nullable', 'numeric', 'min:0'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['nullable', 'exists:products,id'],
            'items.*.description' => ['required', 'string', 'max:255'],
            'items.*.sku' => ['nullable', 'string', 'max:100'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        return DB::transaction(function () use ($validated) {
            $subtotal = collect($validated['items'])->sum(function ($item) {
                return $item['quantity'] * $item['unit_price'];
            });

            $taxRate = $validated['tax_rate'] ?? 0;
            $taxAmount = $subtotal * ($taxRate / 100);
            $discountAmount = $validated['discount_amount'] ?? 0;
            $total = $subtotal + $taxAmount - $discountAmount;
            $amountPaid = $validated['amount_paid'] ?? 0;
            $balanceDue = $total - $amountPaid;

            if ($total < 0) {
                throw ValidationException::withMessages([
                    'discount_amount' => 'Discount cannot be greater than subtotal plus tax.',
                ]);
            }

            if ($balanceDue < 0) {
                throw ValidationException::withMessages([
                    'amount_paid' => 'Amount paid cannot be greater than invoice total.',
                ]);
            }

            $status = $validated['status'];

            if ($amountPaid > 0 && $balanceDue == 0) {
                $status = 'paid';
            }

            $invoice = Invoice::create([
                'customer_id' => $validated['customer_id'],
                'user_id' => auth()->id,
                'invoice_number' => $this->generateInvoiceNumber(),
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'] ?? null,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'total' => $total,
                'amount_paid' => $amountPaid,
                'balance_due' => $balanceDue,
                'status' => $status,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $invoice->items()->create([
                    'product_id' => $item['product_id'] ?? null,
                    'description' => $item['description'],
                    'sku' => $item['sku'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'line_total' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            if ($amountPaid > 0) {
                $invoice->payments()->create([
                    'customer_id' => $invoice->customer_id,
                    'user_id' => auth()->id,
                    'payment_number' => $this->generatePaymentNumber(),
                    'payment_date' => now()->toDateString(),
                    'amount' => $amountPaid,
                    'method' => 'cash',
                    'status' => 'completed',
                    'notes' => 'Initial payment entered during invoice creation.',
                ]);
            }

            return response()->json([
                'message' => 'Invoice created successfully.',
                'invoice_id' => $invoice->id,
                'redirect_url' => route('invoices.show', $invoice),
            ], 201);
        });
    }

    private function generateInvoiceNumber(): string
    {
        $prefix = 'INV-' . now()->format('Ymd') . '-';

        $lastInvoice = Invoice::where('invoice_number', 'like', $prefix . '%')
            ->latest('id')
            ->first();

        $nextNumber = 1;

        if ($lastInvoice) {
            $lastSequence = (int) str_replace($prefix, '', $lastInvoice->invoice_number);
            $nextNumber = $lastSequence + 1;
        }

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    private function generatePaymentNumber(): string
    {
        $prefix = 'PAY-' . now()->format('Ymd') . '-';

        $lastPayment = \App\Models\Payment::where('payment_number', 'like', $prefix . '%')
            ->latest('id')
            ->first();

        $nextNumber = 1;

        if ($lastPayment) {
            $lastSequence = (int) str_replace($prefix, '', $lastPayment->payment_number);
            $nextNumber = $lastSequence + 1;
        }

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
