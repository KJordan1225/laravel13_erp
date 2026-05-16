@extends('layouts.app')

@section('title', 'Create Purchase Order')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">Create Purchase Order</h1>
        <a href="{{ route('purchase-orders.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('purchase-orders.store') }}">
        @csrf

        <div class="card erp-card mb-4">
            <div class="card-header">Vendor & Order Details</div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Vendor</label>
                        <select name="vendor_id" class="form-select" required>
                            <option value="">Select Vendor</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Order Date</label>
                        <input type="date" name="order_date" value="{{ now()->toDateString() }}" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Expected Date</label>
                        <input type="date" name="expected_date" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft">Draft</option>
                            <option value="ordered">Ordered</option>
                            <option value="received">Received</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tax Rate %</label>
                        <input type="number" step="0.01" min="0" name="tax_rate" value="0" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Discount</label>
                        <input type="number" step="0.01" min="0" name="discount_amount" value="0" class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card erp-card mb-4">
            <div class="card-header">Purchase Items</div>

            <div class="card-body">
                <div id="purchase-items">
                    <div class="row g-3 mb-3 purchase-item">
                        <div class="col-md-5">
                            <label class="form-label">Product</label>
                            <select name="items[0][product_id]" class="form-select" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->sku }} — {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Qty</label>
                            <input type="number" min="1" name="items[0][quantity]" value="1" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Unit Cost</label>
                            <input type="number" min="0" step="0.01" name="items[0][unit_cost]" value="0" class="form-control" required>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-danger remove-item">Remove</button>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-purchase-item" class="btn btn-orange">
                    Add Item
                </button>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary">Save Purchase Order</button>
        </div>
    </form>
</div>

<script>
let purchaseItemIndex = 1;

document.getElementById('add-purchase-item').addEventListener('click', function () {
    const wrapper = document.getElementById('purchase-items');

    const first = document.querySelector('.purchase-item');
    const clone = first.cloneNode(true);

    clone.querySelectorAll('select, input').forEach(function (field) {
        field.name = field.name.replace(/\[\d+\]/, `[${purchaseItemIndex}]`);

        if (field.tagName === 'SELECT') {
            field.selectedIndex = 0;
        } else if (field.type === 'number') {
            field.value = field.name.includes('quantity') ? 1 : 0;
        }
    });

    wrapper.appendChild(clone);
    purchaseItemIndex++;
});

document.addEventListener('click', function (event) {
    if (event.target.classList.contains('remove-item')) {
        const items = document.querySelectorAll('.purchase-item');

        if (items.length > 1) {
            event.target.closest('.purchase-item').remove();
        }
    }
});
</script>
@endsection
