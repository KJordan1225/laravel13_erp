@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Create Category</h1>

    <form method="POST" action="{{ route('categories.store') }}" class="card erp-card card-body">
        @csrf
        @include('categories._form')
    </form>
</div>
@endsection
