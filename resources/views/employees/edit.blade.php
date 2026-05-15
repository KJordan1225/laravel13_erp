
@extends('layouts.app')
@section('title', 'Edit Employee')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Edit Employee</h1>
    <div class="card erp-card"><div class="card-body">
        <form method="POST" action="{{ route('employees.update', $employee) }}">
            @method('PUT')
            @include('employees._form')
        </form>
    </div></div>
</div>
@endsection
