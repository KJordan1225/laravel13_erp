@extends('layouts.app')

@section('title', 'Expenses')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">Expenses</h1>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary">Add Expense</a>
    </div>

    <div class="card erp-card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Expense #</th>
                        <th>Title</th>
                        <th>Vendor</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end">Amount</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($expenses as $expense)
                        <tr>
                            <td>{{ $expense->expense_number }}</td>
                            <td>{{ $expense->title }}</td>
                            <td>{{ $expense->vendor?->name ?? 'N/A' }}</td>
                            <td>{{ $expense->category ?? 'N/A' }}</td>
                            <td>{{ $expense->expense_date?->format('m/d/Y') }}</td>
                            <td><x-status-badge :status="$expense->status" /></td>
                            <td class="text-end">${{ number_format($expense->amount, 2) }}</td>
                            <td class="text-end">
                                <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No expenses found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">{{ $expenses->links() }}</div>
    </div>
</div>
@endsection
