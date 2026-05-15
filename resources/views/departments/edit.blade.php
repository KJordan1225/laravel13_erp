@extends('layouts.app')
@section('title', 'Edit Department')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Edit Department</h1>
    <form method="POST" action="{{ route('departments.update', $department) }}" class="card erp-card card-body">
        @method('PUT')
        @include('departments._form')
    </form>
</div>
@endsection
