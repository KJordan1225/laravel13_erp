@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Create Product</h1>

    <div class="card erp-card">
        <div class="card-body">
            <form method="POST" action="{{ route('products.store') }}">
                @include('products._form')
            </form>
        </div>
    </div>
</div>
@endsection
