@extends('layouts.app')

@section('title', 'Sales Report')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Sales Report</h1>

    <div class="card erp-card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                </div>

                <div class="col-md-3">
                    <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                </div>

                <div class="col-md-6">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('reports.sales') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="alert alert-primary">
        Total on this page: <strong>${{ number_format($total, 2) }}</strong>
    </div>

    <div class="card erp-card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->customer?->name }}</td>
                            <td>{{ $order->order_date?->format('m/d/Y') }}</td>
                            <td><x-status-badge :status="$order->status" /></td>
                            <td class="text-end">${{ number_format($order->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">{{ $orders->links() }}</div>
    </div>
</div>
@endsection
