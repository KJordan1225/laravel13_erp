@extends('layouts.app')

@section('title', 'Create Expense')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Create Expense</h1>

    <form method="POST" action="{{ route('expenses.store') }}" class="card erp-card card-body">
        @include('expenses._form')
    </form>
</div>
@endsection
