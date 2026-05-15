@extends('layouts.app')

@section('title', 'Create Sales Order')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Create Sales Order</h1>
            <p class="text-muted mb-0">Create a customer order with dynamic line items.</p>
        </div>

        <a href="{{ route('sales-orders.index') }}" class="btn btn-outline-secondary">
            Back to Sales Orders
        </a>
    </div>

    <sales-order-form></sales-order-form>
</div>
@endsection
