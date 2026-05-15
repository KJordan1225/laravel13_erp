@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">{{ $customer->name }}</h1>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="card erp-card">
        <div class="card-body">
            <p><strong>Customer #:</strong> {{ $customer->customer_number }}</p>
            <p><strong>Contact:</strong> {{ $customer->contact_name ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $customer->email ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $customer->phone ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $customer->address ?? 'N/A' }}</p>
            <p><strong>City/State:</strong> {{ $customer->city }} {{ $customer->state }}</p>
            <p><strong>Credit Limit:</strong> ${{ number_format($customer->credit_limit, 2) }}</p>
            <p><strong>Status:</strong> <x-status-badge :status="$customer->status" /></p>
        </div>
    </div>
</div>
@endsection
