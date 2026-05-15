@csrf

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Vendor Number</label>
        <input name="vendor_number" value="{{ old('vendor_number', $vendor->vendor_number ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-8">
        <label class="form-label">Vendor Name</label>
        <input name="name" value="{{ old('name', $vendor->name ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Contact Name</label>
        <input name="contact_name" value="{{ old('contact_name', $vendor->contact_name ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $vendor->email ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Phone</label>
        <input name="phone" value="{{ old('phone', $vendor->phone ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="active" @selected(old('status', $vendor->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $vendor->status ?? '') === 'inactive')>Inactive</option>
        </select>
    </div>

    <div class="col-md-12">
        <label class="form-label">Address</label>
        <input name="address" value="{{ old('address', $vendor->address ?? '') }}" class="form-control">
    </div>
</div>

<div class="mt-4 d-flex justify-content-end gap-2">
    <a href="{{ route('vendors.index') }}" class="btn btn-outline-secondary">Cancel</a>
    <button class="btn btn-primary">Save Vendor</button>
</div>
