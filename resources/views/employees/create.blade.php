@extends('layouts.app')
@section('title', 'Create Employee')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Create Employee</h1>
    <div class="card erp-card"><div class="card-body">
        <form method="POST" action="{{ route('employees.store') }}">
            @include('employees._form')
        </form>
    </div></div>
</div>
@endsection
