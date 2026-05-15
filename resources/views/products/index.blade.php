@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Products</h1>
            <p class="text-muted mb-0">Manage ERP product catalog and stock levels.</p>
        </div>

        <a href="{{ route('products.create') }}" class="btn btn-primary">
            Add Product
        </a>
    </div>

    <div class="card erp-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}" class="row g-3">
                <div class="col-md-5">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Search name or SKU"
                    >
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="active" @selected(request('status') === 'active')>Active</option>
                        <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card erp-card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th class="text-end">Stock</th>
                        <th class="text-end">Price</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category?->name ?? 'N/A' }}</td>
                            <td class="text-end">
                                {{ $product->stock_quantity }}

                                @if($product->isLowStock())
                                    <span class="badge bg-warning text-dark ms-1">Low</span>
                                @endif
                            </td>
                            <td class="text-end">${{ number_format($product->price, 2) }}</td>
                            <td><x-status-badge :status="$product->status" /></td>
                            <td class="text-end">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">View</a>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">Edit</a>

                                <form
                                    method="POST"
                                    action="{{ route('products.destroy', $product) }}"
                                    class="d-inline"
                                    onsubmit="return confirm('Delete this product?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="card-footer">{{ $products->links() }}</div>
        @endif
    </div>
</div>
@endsection
