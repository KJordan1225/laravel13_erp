@extends('layouts.app')

@section('title', 'Sales Orders')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Sales Orders</h1>
            <p class="text-muted mb-0">Manage customer sales orders.</p>
        </div>

        <a href="{{ route('sales-orders.create') }}" class="btn btn-primary">
            Create Sales Order
        </a>
    </div>

    <div class="card erp-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('sales-orders.index') }}" class="row g-3">
                <div class="col-md-5">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Search order number or customer"
                    >
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        @foreach(['draft', 'pending', 'approved', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <button class="btn btn-primary">
                        Filter
                    </button>

                    <a href="{{ route('sales-orders.index') }}" class="btn btn-outline-secondary">
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
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-end">Total</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->customer?->name }}</td>
                                <td>{{ $order->order_date?->format('m/d/Y') }}</td>
                                <td>
                                    <x-status-badge :status="$order->status" />
                                </td>
                                <td class="text-end">
                                    ${{ number_format($order->total, 2) }}
                                </td>
                                <td class="text-end">
                                    <a
                                        href="{{ route('sales-orders.show', $order) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        View
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('sales-orders.destroy', $order) }}"
                                        class="d-inline"
                                        onsubmit="return confirm('Delete this sales order?')"
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
                                <td colspan="6" class="text-center text-muted py-4">
                                    No sales orders found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($orders->hasPages())
            <div class="card-footer">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
