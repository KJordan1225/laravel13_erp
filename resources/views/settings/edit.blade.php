@extends('layouts.app')

@section('title', 'Company Settings')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Company Settings</h1>

    <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="card erp-card card-body">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Company Name</label>
                <input name="company_name" value="{{ old('company_name', $settings->company_name) }}" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $settings->email) }}" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Phone</label>
                <input name="phone" value="{{ old('phone', $settings->phone) }}" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Currency</label>
                <input name="currency" value="{{ old('currency', $settings->currency) }}" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Default Tax Rate %</label>
                <input type="number" step="0.01" min="0" name="tax_rate" value="{{ old('tax_rate', $settings->tax_rate) }}" class="form-control" required>
            </div>

            <div class="col-md-12">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control">{{ old('address', $settings->address) }}</textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label">Company Logo</label>
                <input type="file" name="logo" class="form-control">

                @if($settings->logo_path)
                    <div class="mt-3">
                        <img src="{{ Storage::disk('public')->url($settings->logo_path) }}" style="max-height: 80px;">
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-primary">Save Settings</button>
        </div>
    </form>
</div>
@endsection
