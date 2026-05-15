@extends('layouts.app')

@section('title', 'Sales Order Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Sales Order {{ $salesOrder->order_number }}</h1>
            <p class="text-muted mb-0">
                Customer: {{ $salesOrder->customer?->name }}
            </p>
        </div>

        <a href="{{ route('sales-orders.index') }}" class="btn btn-outline-secondary">
            Back to Sales Orders
        </a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card erp-card">
                <div class="card-header">
                    Order Items
                </div>

                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Product</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Line Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($salesOrder->items as $item)
                                <tr>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td class="text-end">{{ $item->quantity }}</td>
                                    <td class="text-end">${{ number_format($item->unit_price, 2) }}</td>
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
                <div class="card-header">
                    Order Summary
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Status</span>
                        <x-status-badge :status="$salesOrder->status" />
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Order Date</span>
                        <strong>{{ $salesOrder->order_date?->format('m/d/Y') }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Due Date</span>
                        <strong>{{ $salesOrder->due_date?->format('m/d/Y') ?? 'N/A' }}</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong>${{ number_format($salesOrder->subtotal, 2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax</span>
                        <strong>${{ number_format($salesOrder->tax_amount, 2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Discount</span>
                        <strong>${{ number_format($salesOrder->discount_amount, 2) }}</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fs-5">
                        <span>Total</span>
                        <strong>${{ number_format($salesOrder->total, 2) }}</strong>
                    </div>

                    @if($salesOrder->notes)
                        <hr>
                        <p class="mb-0 text-muted">
                            {{ $salesOrder->notes }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
