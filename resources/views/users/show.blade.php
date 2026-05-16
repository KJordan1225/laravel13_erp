@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">{{ $user->name }}</h1>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="card erp-card">
        <div class="card-body">
            <p><strong>Email:</strong> {{ $user->email }}</p>

            <h5 class="mt-4">Roles</h5>
            @forelse($user->roles as $role)
                <span class="badge bg-primary">{{ $role->name }}</span>
            @empty
                <p class="text-muted">No roles assigned.</p>
            @endforelse

            <h5 class="mt-4">Permissions</h5>
            @forelse($user->permissions() as $permission)
                <span class="badge bg-secondary">{{ $permission->name }}</span>
            @empty
                <p class="text-muted">No permissions assigned.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
