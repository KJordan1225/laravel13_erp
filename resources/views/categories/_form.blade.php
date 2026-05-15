<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $category->description ?? '') }}</textarea>
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $category->is_active ?? true))>
    <label class="form-check-label">Active</label>
</div>

<button class="btn btn-primary">Save Category</button>
