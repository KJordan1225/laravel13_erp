@extends('layouts.app')

@section('title', 'Payments')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Payments</h1>
            <p class="text-muted mb-0">View customer invoice payments.</p>
        </div>
    </div>

    <div class="card erp-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('payments.index') }}" class="row g-3">
                <div class="col-md-6">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Search payment number, reference, or customer"
                    >
                </div>

                <div class="col-md-6">
                    <button class="btn btn-primary">Search</button>
                    <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card erp-card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Payment #</th>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_number }}</td>
                            <td>{{ $payment->invoice?->invoice_number }}</td>
                            <td>{{ $payment->customer?->name }}</td>
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
                            <td colspan="7" class="text-center text-muted py-4">
                                No payments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="card-footer">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
