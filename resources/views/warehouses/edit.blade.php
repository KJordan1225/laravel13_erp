@extends('layouts.app')

@section('title', 'Edit Warehouse')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Edit Warehouse</h1>

    <form method="POST" action="{{ route('warehouses.update', $warehouse) }}" class="card erp-card card-body">
        @csrf
        @method('PUT')
        @include('warehouses._form')
    </form>
</div>
@endsection
