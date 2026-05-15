@extends('layouts.app')

@section('title', 'Create Warehouse')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Create Warehouse</h1>

    <form method="POST" action="{{ route('warehouses.store') }}" class="card erp-card card-body">
        @csrf
        @include('warehouses._form')
    </form>
</div>
@endsection
