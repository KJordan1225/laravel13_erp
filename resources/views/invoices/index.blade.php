@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Invoices</h1>
            <p class="text-muted mb-0">Manage customer invoices and balances.</p>
        </div>

        <a href="{{ route('invoices.create') }}" class="btn btn-primary">
            Create Invoice
        </a>
    </div>

    <div class="card erp-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('invoices.index') }}" class="row g-3">
                <div class="col-md-5">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Search invoice number or customer"
                    >
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        @foreach(['draft', 'sent', 'paid', 'overdue', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">
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
                            <th>Invoice #</th>
                            <th>Customer</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th class="text-end">Total</th>
                            <th class="text-end">Balance</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->customer?->name }}</td>
                                <td>{{ $invoice->invoice_date?->format('m/d/Y') }}</td>
                                <td>{{ $invoice->due_date?->format('m/d/Y') ?? 'N/A' }}</td>
                                <td>
                                    <x-status-badge :status="$invoice->status" />
                                </td>
                                <td class="text-end">
                                    ${{ number_format($invoice->total, 2) }}
                                </td>
                                <td class="text-end">
                                    ${{ number_format($invoice->balance_due, 2) }}
                                </td>
                                <td class="text-end">
                                    <a
                                        href="{{ route('invoices.show', $invoice) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        View
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('invoices.destroy', $invoice) }}"
                                        class="d-inline"
                                        onsubmit="return confirm('Delete this invoice?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No invoices found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($invoices->hasPages())
            <div class="card-footer">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
