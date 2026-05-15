<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use Illuminate\Http\Request;

class InventoryMovementController extends Controller
{
    public function index(Request $request)
    {
        $movements = InventoryMovement::query()
            ->with(['product', 'warehouse', 'user'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->whereHas('product', function ($productQuery) use ($search) {
                    $productQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('type'), function ($query) use ($request) {
                $query->where('type', $request->string('type')->toString());
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inventory-movements.index', compact('movements'));
    }

    public function create()
    {
        return view('inventory-movements.create');
    }

    public function show(InventoryMovement $inventoryMovement)
    {
        $inventoryMovement->load(['product', 'warehouse', 'user']);

        return view('inventory-movements.show', [
            'movement' => $inventoryMovement,
        ]);
    }

    public function edit(InventoryMovement $inventoryMovement)
    {
        return redirect()
            ->route('inventory-movements.show', $inventoryMovement)
            ->with('error', 'Inventory movements cannot be edited after creation.');
    }

    public function update(Request $request, InventoryMovement $inventoryMovement)
    {
        return redirect()
            ->route('inventory-movements.show', $inventoryMovement)
            ->with('error', 'Inventory movements cannot be updated after creation.');
    }

    public function destroy(InventoryMovement $inventoryMovement)
    {
        return redirect()
            ->route('inventory-movements.index')
            ->with('error', 'Inventory movements should not be deleted because they are audit records.');
    }
}
