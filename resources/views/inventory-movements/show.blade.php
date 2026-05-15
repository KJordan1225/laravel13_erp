@extends('layouts.app')

@section('title', 'Inventory Movement Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Inventory Movement</h1>
            <p class="text-muted mb-0">
                {{ $movement->product?->name }} — {{ $movement->product?->sku }}
            </p>
        </div>

        <a href="{{ route('inventory-movements.index') }}" class="btn btn-outline-secondary">
            Back to Inventory
        </a>
    </div>

    <div class="card erp-card">
        <div class="card-header">
            Movement Details
        </div>

        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <strong>Product:</strong>
                    <div>{{ $movement->product?->name }}</div>
                </div>

                <div class="col-md-6">
                    <strong>SKU:</strong>
                    <div>{{ $movement->product?->sku }}</div>
                </div>

                <div class="col-md-6">
                    <strong>Warehouse:</strong>
                    <div>{{ $movement->warehouse?->name ?? 'N/A' }}</div>
                </div>

                <div class="col-md-6">
                    <strong>Type:</strong>
                    <div>{{ str_replace('_', ' ', ucfirst($movement->type)) }}</div>
                </div>

                <div class="col-md-6">
                    <strong>Quantity:</strong>
                    <div>{{ $movement->quantity }}</div>
                </div>

                <div class="col-md-6">
                    <strong>Created By:</strong>
                    <div>{{ $movement->user?->name ?? 'System' }}</div>
                </div>

                <div class="col-md-6">
                    <strong>Date:</strong>
                    <div>{{ $movement->created_at?->format('m/d/Y H:i') }}</div>
                </div>

                <div class="col-md-12">
                    <strong>Notes:</strong>
                    <div>{{ $movement->notes ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
