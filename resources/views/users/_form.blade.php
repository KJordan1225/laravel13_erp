@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Name</label>
        <input
            type="text"
            name="name"
            value="{{ old('name', $user->name ?? '') }}"
            class="form-control"
            required
        >
    </div>

    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input
            type="email"
            name="email"
            value="{{ old('email', $user->email ?? '') }}"
            class="form-control"
            required
        >
    </div>

    <div class="col-md-6">
        <label class="form-label">Password</label>
        <input
            type="password"
            name="password"
            class="form-control"
            @if(!isset($user)) required @endif
        >
        @isset($user)
            <small class="text-muted">Leave blank to keep current password.</small>
        @endisset
    </div>

    <div class="col-md-6">
        <label class="form-label">Confirm Password</label>
        <input
            type="password"
            name="password_confirmation"
            class="form-control"
            @if(!isset($user)) required @endif
        >
    </div>

    <div class="col-md-12">
        <label class="form-label">Roles</label>

        <div class="row">
            @foreach($roles as $role)
                <div class="col-md-4">
                    <div class="form-check">
                        <input
                            type="checkbox"
                            name="roles[]"
                            value="{{ $role->id }}"
                            class="form-check-input"
                            id="role_{{ $role->id }}"
                            @checked(in_array($role->id, old('roles', isset($user) ? $user->roles->pluck('id')->toArray() : [])))
                        >

                        <label for="role_{{ $role->id }}" class="form-check-label">
                            {{ $role->name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-end gap-2">
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
    <button class="btn btn-primary">Save User</button>
</div>
