@extends('layouts.app')

@section('title', 'Expense Report')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Expense Report</h1>

    <div class="alert alert-warning">
        Total Expenses: <strong>${{ number_format($total, 2) }}</strong>
    </div>

    <div class="card erp-card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Expense #</th>
                        <th>Title</th>
                        <th>Vendor</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($expenses as $expense)
                        <tr>
                            <td>{{ $expense->expense_number }}</td>
                            <td>{{ $expense->title }}</td>
                            <td>{{ $expense->vendor?->name ?? 'N/A' }}</td>
                            <td>{{ $expense->expense_date?->format('m/d/Y') }}</td>
                            <td><x-status-badge :status="$expense->status" /></td>
                            <td class="text-end">${{ number_format($expense->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">{{ $expenses->links() }}</div>
    </div>
</div>
@endsection
