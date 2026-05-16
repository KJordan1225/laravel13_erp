@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Create User</h1>

    <div class="card erp-card">
        <div class="card-body">
            <form method="POST" action="{{ route('users.store') }}">
                @include('users._form')
            </form>
        </div>
    </div>
</div>
@endsection
