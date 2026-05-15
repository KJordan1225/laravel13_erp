@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Edit Product</h1>

    <div class="card erp-card">
        <div class="card-body">
            <form method="POST" action="{{ route('products.update', $product) }}">
                @method('PUT')
                @include('products._form')
            </form>
        </div>
    </div>
</div>
@endsection
