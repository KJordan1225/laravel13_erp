@extends('layouts.app')

@section('title', 'Departments')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">Departments</h1>
        <a href="{{ route('departments.create') }}" class="btn btn-primary">Add Department</a>
    </div>

    <div class="card erp-card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Employees</th>
                        <th>Active</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($departments as $department)
                        <tr>
                            <td>{{ $department->code ?? 'N/A' }}</td>
                            <td>{{ $department->name }}</td>
                            <td>{{ $department->employees_count }}</td>
                            <td>{{ $department->is_active ? 'Yes' : 'No' }}</td>
                            <td class="text-end">
                                <a href="{{ route('departments.edit', $department) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">{{ $departments->links() }}</div>
    </div>
</div>
@endsection
