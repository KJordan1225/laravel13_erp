@csrf

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Customer Number</label>
        <input name="customer_number" value="{{ old('customer_number', $customer->customer_number ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-8">
        <label class="form-label">Company / Customer Name</label>
        <input name="name" value="{{ old('name', $customer->name ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Contact Name</label>
        <input name="contact_name" value="{{ old('contact_name', $customer->contact_name ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $customer->email ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Phone</label>
        <input name="phone" value="{{ old('phone', $customer->phone ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Credit Limit</label>
        <input type="number" step="0.01" min="0" name="credit_limit" value="{{ old('credit_limit', $customer->credit_limit ?? 0) }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="active" @selected(old('status', $customer->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $customer->status ?? '') === 'inactive')>Inactive</option>
        </select>
    </div>

    <div class="col-md-12">
        <label class="form-label">Address</label>
        <input name="address" value="{{ old('address', $customer->address ?? '') }}" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">City</label>
        <input name="city" value="{{ old('city', $customer->city ?? '') }}" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">State</label>
        <input name="state" value="{{ old('state', $customer->state ?? '') }}" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Postal Code</label>
        <input name="postal_code" value="{{ old('postal_code', $customer->postal_code ?? '') }}" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Country</label>
        <input name="country" value="{{ old('country', $customer->country ?? 'USA') }}" class="form-control">
    </div>
</div>

<div class="mt-4 d-flex justify-content-end gap-2">
    <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">Cancel</a>
    <button class="btn btn-primary">Save Customer</button>
</div>
