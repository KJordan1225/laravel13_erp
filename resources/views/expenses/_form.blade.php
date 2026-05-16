@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Vendor</label>
        <select name="vendor_id" class="form-select">
            <option value="">No Vendor</option>
            @foreach($vendors as $vendor)
                <option value="{{ $vendor->id }}" @selected(old('vendor_id', $expense->vendor_id ?? '') == $vendor->id)>
                    {{ $vendor->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Category</label>
        <input name="category" value="{{ old('category', $expense->category ?? '') }}" class="form-control" placeholder="Office, Payroll, Travel, Utilities">
    </div>

    <div class="col-md-8">
        <label class="form-label">Title</label>
        <input name="title" value="{{ old('title', $expense->title ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Expense Date</label>
        <input type="date" name="expense_date" value="{{ old('expense_date', isset($expense) ? $expense->expense_date?->format('Y-m-d') : now()->toDateString()) }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Amount</label>
        <input type="number" step="0.01" min="0.01" name="amount" value="{{ old('amount', $expense->amount ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Payment Method</label>
        <input name="payment_method" value="{{ old('payment_method', $expense->payment_method ?? 'cash') }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            @foreach(['pending', 'approved', 'paid', 'rejected'] as $status)
                <option value="{{ $status }}" @selected(old('status', $expense->status ?? 'pending') === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-12">
        <label class="form-label">Reference Number</label>
        <input name="reference_number" value="{{ old('reference_number', $expense->reference_number ?? '') }}" class="form-control">
    </div>

    <div class="col-md-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control">{{ old('notes', $expense->notes ?? '') }}</textarea>
    </div>
</div>

<div class="mt-4 d-flex justify-content-end gap-2">
    <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary">Cancel</a>
    <button class="btn btn-primary">Save Expense</button>
</div>
