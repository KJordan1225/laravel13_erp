@extends('layouts.app')

@section('title', 'Expense Details')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Expense {{ $expense->expense_number }}</h1>

    <div class="card erp-card">
        <div class="card-body">
            <p><strong>Title:</strong> {{ $expense->title }}</p>
            <p><strong>Vendor:</strong> {{ $expense->vendor?->name ?? 'N/A' }}</p>
            <p><strong>Category:</strong> {{ $expense->category ?? 'N/A' }}</p>
            <p><strong>Date:</strong> {{ $expense->expense_date?->format('m/d/Y') }}</p>
            <p><strong>Amount:</strong> ${{ number_format($expense->amount, 2) }}</p>
            <p><strong>Status:</strong> <x-status-badge :status="$expense->status" /></p>
            <p><strong>Payment Method:</strong> {{ ucfirst($expense->payment_method) }}</p>
            <p><strong>Reference:</strong> {{ $expense->reference_number ?? 'N/A' }}</p>
            <p><strong>Notes:</strong> {{ $expense->notes ?? 'N/A' }}</p>
        </div>
    </div>
</div>
@endsection
