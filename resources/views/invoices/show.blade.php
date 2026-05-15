@extends('layouts.app')

@section('title', 'Invoice Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Invoice {{ $invoice->invoice_number }}</h1>
            <p class="text-muted mb-0">
                Customer: {{ $invoice->customer?->name }}
            </p>
        </div>

        <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">
            Back to Invoices
        </a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card erp-card mb-4">
                <div class="card-header">Invoice Items</div>

                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Description</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Line Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($invoice->items as $item)
                                <tr>
                                    <td>{{ $item->sku ?? 'N/A' }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td class="text-end">{{ $item->quantity }}</td>
                                    <td class="text-end">${{ number_format($item->unit_price, 2) }}</td>
                                    <td class="text-end">${{ number_format($item->line_total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card erp-card">
                <div class="card-header">Payments</div>

                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Payment #</th>
                                <th>Date</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($invoice->payments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_number }}</td>
                                    <td>{{ $payment->payment_date?->format('m/d/Y') }}</td>
                                    <td>{{ ucfirst($payment->method) }}</td>
                                    <td>
                                        <x-status-badge :status="$payment->status" />
                                    </td>
                                    <td class="text-end">
                                        ${{ number_format($payment->amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        No payments recorded.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card erp-card">
                <div class="card-header">Invoice Summary</div>

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Status</span>
                        <x-status-badge :status="$invoice->status" />
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Invoice Date</span>
                        <strong>{{ $invoice->invoice_date?->format('m/d/Y') }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Due Date</span>
                        <strong>{{ $invoice->due_date?->format('m/d/Y') ?? 'N/A' }}</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong>${{ number_format($invoice->subtotal, 2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax</span>
                        <strong>${{ number_format($invoice->tax_amount, 2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Discount</span>
                        <strong>${{ number_format($invoice->discount_amount, 2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Amount Paid</span>
                        <strong>${{ number_format($invoice->amount_paid, 2) }}</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fs-5">
                        <span>Total</span>
                        <strong>${{ number_format($invoice->total, 2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between fs-5 text-danger">
                        <span>Balance</span>
                        <strong>${{ number_format($invoice->balance_due, 2) }}</strong>
                    </div>

                    @if($invoice->notes)
                        <hr>
                        <p class="mb-0 text-muted">{{ $invoice->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
