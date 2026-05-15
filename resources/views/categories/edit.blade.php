@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Edit Category</h1>

    <form method="POST" action="{{ route('categories.update', $category) }}" class="card erp-card card-body">
        @csrf
        @method('PUT')
        @include('categories._form')
    </form>
</div>
@endsection