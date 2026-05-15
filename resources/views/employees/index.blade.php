@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">Employees</h1>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
    </div>

    <div class="card erp-card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Employee #</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Job Title</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td>{{ $employee->employee_number }}</td>
                            <td>{{ $employee->full_name }}</td>
                            <td>{{ $employee->department?->name ?? 'N/A' }}</td>
                            <td>{{ $employee->job_title ?? 'N/A' }}</td>
                            <td><x-status-badge :status="$employee->status" /></td>
                            <td class="text-end">
                                <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No employees found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">{{ $employees->links() }}</div>
    </div>
</div>
@endsection
