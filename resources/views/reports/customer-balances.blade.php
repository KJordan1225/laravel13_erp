@extends('layouts.app')

@section('title', 'Customer Balances')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Customer Balance Report</h1>

    <div class="card erp-card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th class="text-end">Total Invoiced</th>
                        <th class="text-end">Total Paid</th>
                        <th class="text-end">Balance</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($customers as $customer)
                        @php
                            $invoiced = $customer->total_invoiced ?? 0;
                            $paid = $customer->total_paid ?? 0;
                            $balance = $invoiced - $paid;
                        @endphp

                        <tr>
                            <td>{{ $customer->name }}</td>
                            <td class="text-end">${{ number_format($invoiced, 2) }}</td>
                            <td class="text-end">${{ number_format($paid, 2) }}</td>
                            <td class="text-end">${{ number_format($balance, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">{{ $customers->links() }}</div>
    </div>
</div>
@endsection
