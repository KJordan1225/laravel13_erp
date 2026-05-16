@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Edit Role</h1>

    <div class="card erp-card">
        <div class="card-body">
            <form method="POST" action="{{ route('roles.update', $role) }}">
                @method('PUT')
                @include('roles._form')
            </form>
        </div>
    </div>
</div>
@endsection
