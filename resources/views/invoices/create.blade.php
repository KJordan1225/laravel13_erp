@extends('layouts.app')

@section('title', 'Create Invoice')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Create Invoice</h1>
            <p class="text-muted mb-0">Create a customer invoice with dynamic line items.</p>
        </div>

        <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">
            Back to Invoices
        </a>
    </div>

    <invoice-form></invoice-form>
</div>
@endsection
