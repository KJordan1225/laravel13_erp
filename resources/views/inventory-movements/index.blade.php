@extends('layouts.app')

@section('title', 'Inventory Movements')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Inventory Movements</h1>
            <p class="text-muted mb-0">Track stock in, stock out, and adjustments.</p>
        </div>

        <a href="{{ route('inventory-movements.create') }}" class="btn btn-primary">
            New Movement
        </a>
    </div>

    <div class="card erp-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('inventory-movements.index') }}" class="row g-3">
                <div class="col-md-5">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Search product name or SKU"
                    >
                </div>

                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="stock_in" @selected(request('type') === 'stock_in')>Stock In</option>
                        <option value="stock_out" @selected(request('type') === 'stock_out')>Stock Out</option>
                        <option value="adjustment" @selected(request('type') === 'adjustment')>Adjustment</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('inventory-movements.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card erp-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Warehouse</th>
                            <th>Type</th>
                            <th class="text-end">Qty</th>
                            <th>User</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($movements as $movement)
                            <tr>
                                <td>{{ $movement->created_at?->format('m/d/Y H:i') }}</td>
                                <td>{{ $movement->product?->name }}</td>
                                <td>{{ $movement->product?->sku }}</td>
                                <td>{{ $movement->warehouse?->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ str_replace('_', ' ', ucfirst($movement->type)) }}
                                    </span>
                                </td>
                                <td class="text-end">{{ $movement->quantity }}</td>
                                <td>{{ $movement->user?->name ?? 'System' }}</td>
                                <td class="text-end">
                                    <a
                                        href="{{ route('inventory-movements.show', $movement) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No inventory movements found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($movements->hasPages())
            <div class="card-footer">
                {{ $movements->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
