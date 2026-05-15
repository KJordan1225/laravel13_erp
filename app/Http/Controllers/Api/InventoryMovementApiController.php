<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InventoryMovementApiController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'warehouse_id' => ['nullable', 'exists:warehouses,id'],
            'type' => ['required', 'in:stock_in,stock_out,adjustment'],
            'quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        return DB::transaction(function () use ($validated) {
            $product = Product::lockForUpdate()->findOrFail($validated['product_id']);

            if ($validated['type'] === 'stock_out' && $product->stock_quantity < $validated['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => 'Not enough stock available for this stock out movement.',
                ]);
            }

            if ($validated['type'] === 'stock_in') {
                $product->increment('stock_quantity', $validated['quantity']);
            }

            if ($validated['type'] === 'stock_out') {
                $product->decrement('stock_quantity', $validated['quantity']);
            }

            if ($validated['type'] === 'adjustment') {
                $product->update([
                    'stock_quantity' => $validated['quantity'],
                ]);
            }

            $movement = InventoryMovement::create([
                'product_id' => $product->id,
                'warehouse_id' => $validated['warehouse_id'] ?? null,
                'user_id' => auth()->id,
                'type' => $validated['type'],
                'quantity' => $validated['quantity'],
                'notes' => $validated['notes'] ?? null,
            ]);

            return response()->json([
                'message' => 'Inventory movement created successfully.',
                'movement_id' => $movement->id,
                'redirect_url' => route('inventory-movements.show', $movement),
            ], 201);
        });
    }
}
