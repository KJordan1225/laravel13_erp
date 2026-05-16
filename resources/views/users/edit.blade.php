@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Edit User</h1>

    <div class="card erp-card">
        <div class="card-body">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @method('PUT')
                @include('users._form')
            </form>
        </div>
    </div>
</div>
@endsection
