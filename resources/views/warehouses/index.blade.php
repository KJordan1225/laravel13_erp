@extends('layouts.app')

@section('title', 'Warehouses')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">Warehouses</h1>
        <a href="{{ route('warehouses.create') }}" class="btn btn-primary">Add Warehouse</a>
    </div>

    <div class="card erp-card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Manager</th>
                        <th>Active</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($warehouses as $warehouse)
                        <tr>
                            <td>{{ $warehouse->code }}</td>
                            <td>{{ $warehouse->name }}</td>
                            <td>{{ $warehouse->location ?? 'N/A' }}</td>
                            <td>{{ $warehouse->manager_name ?? 'N/A' }}</td>
                            <td>{{ $warehouse->is_active ? 'Yes' : 'No' }}</td>
                            <td class="text-end">
                                <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">{{ $warehouses->links() }}</div>
    </div>
</div>
@endsection
