@extends('layouts.app')

@section('title', 'Edit Expense')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Edit Expense</h1>

    <form method="POST" action="{{ route('expenses.update', $expense) }}" class="card erp-card card-body">
        @method('PUT')
        @include('expenses._form')
    </form>
</div>
@endsection
