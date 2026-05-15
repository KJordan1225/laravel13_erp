@extends('layouts.app')
@section('title', 'Create Vendor')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Create Vendor</h1>
    <div class="card erp-card"><div class="card-body">
        <form method="POST" action="{{ route('vendors.store') }}">
            @include('vendors._form')
        </form>
    </div></div>
</div>
@endsection
