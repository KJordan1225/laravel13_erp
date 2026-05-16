@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Edit Permission</h1>

    <div class="card erp-card">
        <div class="card-body">
            <form method="POST" action="{{ route('permissions.update', $permission) }}">
                @method('PUT')
                @include('permissions._form')
            </form>
        </div>
    </div>
</div>
@endsection
