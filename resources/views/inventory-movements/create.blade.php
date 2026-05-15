@extends('layouts.app')

@section('title', 'Create Inventory Movement')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Create Inventory Movement</h1>
            <p class="text-muted mb-0">Adjust product stock levels.</p>
        </div>

        <a href="{{ route('inventory-movements.index') }}" class="btn btn-outline-secondary">
            Back to Inventory
        </a>
    </div>

    <inventory-movement-form></inventory-movement-form>
</div>
@endsection
