@extends('layouts.app')

@section('title', 'Purchase Orders')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">Purchase Orders</h1>
        <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary">Create PO</a>
    </div>

    <div class="card erp-card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>PO #</th>
                        <th>Vendor</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end">Total</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($purchaseOrders as $po)
                        <tr>
                            <td>{{ $po->purchase_order_number }}</td>
                            <td>{{ $po->vendor?->name }}</td>
                            <td>{{ $po->order_date?->format('m/d/Y') }}</td>
                            <td><x-status-badge :status="$po->status" /></td>
                            <td class="text-end">${{ number_format($po->total, 2) }}</td>
                            <td class="text-end">
                                <a href="{{ route('purchase-orders.show', $po) }}" class="btn btn-sm btn-outline-primary">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No purchase orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">{{ $purchaseOrders->links() }}</div>
    </div>
</div>
@endsection
