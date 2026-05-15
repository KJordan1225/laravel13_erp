@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">{{ $product->name }}</h1>

        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="card erp-card mb-4">
        <div class="card-body">
            <p><strong>SKU:</strong> {{ $product->sku }}</p>
            <p><strong>Category:</strong> {{ $product->category?->name ?? 'N/A' }}</p>
            <p><strong>Cost:</strong> ${{ number_format($product->cost, 2) }}</p>
            <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            <p><strong>Stock:</strong> {{ $product->stock_quantity }}</p>
            <p><strong>Reorder Level:</strong> {{ $product->reorder_level }}</p>
            <p><strong>Status:</strong> <x-status-badge :status="$product->status" /></p>
            <p><strong>Description:</strong> {{ $product->description ?? 'N/A' }}</p>
        </div>
    </div>
</div>
@endsection
