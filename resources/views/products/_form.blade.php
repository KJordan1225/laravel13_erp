@csrf

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">SKU</label>
        <input
            type="text"
            name="sku"
            value="{{ old('sku', $product->sku ?? '') }}"
            class="form-control"
            required
        >
    </div>

    <div class="col-md-8">
        <label class="form-label">Product Name</label>
        <input
            type="text"
            name="name"
            value="{{ old('name', $product->name ?? '') }}"
            class="form-control"
            required
        >
    </div>

    <div class="col-md-6">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select">
            <option value="">No Category</option>
            @foreach($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(old('category_id', $product->category_id ?? '') == $category->id)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">Cost</label>
        <input
            type="number"
            name="cost"
            step="0.01"
            min="0"
            value="{{ old('cost', $product->cost ?? 0) }}"
            class="form-control"
            required
        >
    </div>

    <div class="col-md-3">
        <label class="form-label">Price</label>
        <input
            type="number"
            name="price"
            step="0.01"
            min="0"
            value="{{ old('price', $product->price ?? 0) }}"
            class="form-control"
            required
        >
    </div>

    <div class="col-md-3">
        <label class="form-label">Stock Quantity</label>
        <input
            type="number"
            name="stock_quantity"
            min="0"
            value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}"
            class="form-control"
            required
        >
    </div>

    <div class="col-md-3">
        <label class="form-label">Reorder Level</label>
        <input
            type="number"
            name="reorder_level"
            min="0"
            value="{{ old('reorder_level', $product->reorder_level ?? 5) }}"
            class="form-control"
            required
        >
    </div>

    <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="active" @selected(old('status', $product->status ?? 'active') === 'active')>
                Active
            </option>
            <option value="inactive" @selected(old('status', $product->status ?? '') === 'inactive')>
                Inactive
            </option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea
            name="description"
            class="form-control"
            rows="4"
        >{{ old('description', $product->description ?? '') }}</textarea>
    </div>
</div>

<div class="mt-4 d-flex justify-content-end gap-2">
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancel</a>
    <button class="btn btn-primary">Save Product</button>
</div>
