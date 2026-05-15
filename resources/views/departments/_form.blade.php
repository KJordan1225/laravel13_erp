@csrf

<div class="mb-3">
    <label class="form-label">Department Name</label>
    <input name="name" value="{{ old('name', $department->name ?? '') }}" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Code</label>
    <input name="code" value="{{ old('code', $department->code ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $department->description ?? '') }}</textarea>
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $department->is_active ?? true))>
    <label class="form-check-label">Active</label>
</div>

<button class="btn btn-primary">Save Department</button>
