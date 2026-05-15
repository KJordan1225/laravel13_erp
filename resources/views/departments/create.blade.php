@extends('layouts.app')
@section('title', 'Create Department')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Create Department</h1>
    <form method="POST" action="{{ route('departments.store') }}" class="card erp-card card-body">
        @include('departments._form')
    </form>
</div>
@endsection
