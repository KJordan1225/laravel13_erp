@extends('layouts.app')

@section('title', 'Inventory Report')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Inventory Report</h1>

    <div class="card erp-card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th class="text-end">Stock</th>
                        <th class="text-end">Reorder Level</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category?->name ?? 'N/A' }}</td>
                            <td class="text-end">{{ $product->stock_quantity }}</td>
                            <td class="text-end">{{ $product->reorder_level }}</td>
                            <td>
                                @if($product->stock_quantity <= $product->reorder_level)
                                    <span class="badge bg-warning text-dark">Low Stock</span>
                                @else
                                    <span class="badge bg-success">OK</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">{{ $products->links() }}</div>
    </div>
</div>
@endsection
