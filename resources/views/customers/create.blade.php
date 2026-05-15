@extends('layouts.app')

@section('title', 'Create Customer')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Create Customer</h1>

    <div class="card erp-card">
        <div class="card-body">
            <form method="POST" action="{{ route('customers.store') }}">
                @include('customers._form')
            </form>
        </div>
    </div>
</div>
@endsection
