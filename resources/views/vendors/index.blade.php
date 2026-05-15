@extends('layouts.app')

@section('title', 'Vendors')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">Vendors</h1>
        <a href="{{ route('vendors.create') }}" class="btn btn-primary">Add Vendor</a>
    </div>

    <div class="card erp-card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Vendor #</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor->vendor_number }}</td>
                            <td>{{ $vendor->name }}</td>
                            <td>{{ $vendor->contact_name ?? 'N/A' }}</td>
                            <td>{{ $vendor->email ?? 'N/A' }}</td>
                            <td><x-status-badge :status="$vendor->status" /></td>
                            <td class="text-end">
                                <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No vendors found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">{{ $vendors->links() }}</div>
    </div>
</div>
@endsection
