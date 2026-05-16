@extends('layouts.app')

@section('title', 'Purchase Order Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">Purchase Order {{ $purchaseOrder->purchase_order_number }}</h1>
        <a href="{{ route('purchase-orders.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card erp-card">
                <div class="card-header">Items</div>

                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Product</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Unit Cost</th>
                                <th class="text-end">Line Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($purchaseOrder->items as $item)
                                <tr>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td class="text-end">{{ $item->quantity }}</td>
                                    <td class="text-end">${{ number_format($item->unit_cost, 2) }}</td>
                                    <td class="text-end">${{ number_format($item->line_total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card erp-card">
                <div class="card-header">Summary</div>

                <div class="card-body">
                    <p><strong>Vendor:</strong> {{ $purchaseOrder->vendor?->name }}</p>
                    <p><strong>Status:</strong> <x-status-badge :status="$purchaseOrder->status" /></p>
                    <p><strong>Order Date:</strong> {{ $purchaseOrder->order_date?->format('m/d/Y') }}</p>
                    <p><strong>Expected Date:</strong> {{ $purchaseOrder->expected_date?->format('m/d/Y') ?? 'N/A' }}</p>

                    <hr>

                    <p><strong>Subtotal:</strong> ${{ number_format($purchaseOrder->subtotal, 2) }}</p>
                    <p><strong>Tax:</strong> ${{ number_format($purchaseOrder->tax_amount, 2) }}</p>
                    <p><strong>Discount:</strong> ${{ number_format($purchaseOrder->discount_amount, 2) }}</p>
                    <p class="fs-5"><strong>Total:</strong> ${{ number_format($purchaseOrder->total, 2) }}</p>

                    @if($purchaseOrder->notes)
                        <hr>
                        <p>{{ $purchaseOrder->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
