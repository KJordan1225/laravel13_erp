<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Code</label>
        <input type="text" name="code" value="{{ old('code', $warehouse->code ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-8">
        <label class="form-label">Name</label>
        <input type="text" name="name" value="{{ old('name', $warehouse->name ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Location</label>
        <input type="text" name="location" value="{{ old('location', $warehouse->location ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Manager Name</label>
        <input type="text" name="manager_name" value="{{ old('manager_name', $warehouse->manager_name ?? '') }}" class="form-control">
    </div>
</div>

<div class="form-check my-3">
    <input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $warehouse->is_active ?? true))>
    <label class="form-check-label">Active</label>
</div>

<button class="btn btn-primary">Save Warehouse</button>
