@csrf

<div class="mb-3">
    <label class="form-label">Role Name</label>
    <input
        type="text"
        name="name"
        value="{{ old('name', $role->name ?? '') }}"
        class="form-control"
        required
    >
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $role->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Permissions</label>

    <div class="row">
        @foreach($permissions as $permission)
            <div class="col-md-4">
                <div class="form-check">
                    <input
                        type="checkbox"
                        name="permissions[]"
                        value="{{ $permission->id }}"
                        class="form-check-input"
                        id="permission_{{ $permission->id }}"
                        @checked(in_array($permission->id, old('permissions', isset($role) ? $role->permissions->pluck('id')->toArray() : [])))
                    >

                    <label for="permission_{{ $permission->id }}" class="form-check-label">
                        {{ $permission->name }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="mt-4 d-flex justify-content-end gap-2">
    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
    <button class="btn btn-primary">Save Role</button>
</div>
