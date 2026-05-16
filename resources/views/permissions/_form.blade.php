@csrf

<div class="mb-3">
    <label class="form-label">Permission Name</label>
    <input
        type="text"
        name="name"
        value="{{ old('name', $permission->name ?? '') }}"
        class="form-control"
        required
    >
</div>

<div class="mt-4 d-flex justify-content-end gap-2">
    <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">Cancel</a>
    <button class="btn btn-primary">Save Permission</button>
</div>
