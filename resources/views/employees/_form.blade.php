@csrf

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Employee Number</label>
        <input name="employee_number" value="{{ old('employee_number', $employee->employee_number ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">First Name</label>
        <input name="first_name" value="{{ old('first_name', $employee->first_name ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Last Name</label>
        <input name="last_name" value="{{ old('last_name', $employee->last_name ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Department</label>
        <select name="department_id" class="form-select">
            <option value="">No Department</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" @selected(old('department_id', $employee->department_id ?? '') == $department->id)>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Linked User Account</label>
        <select name="user_id" class="form-select">
            <option value="">No User Account</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @selected(old('user_id', $employee->user_id ?? '') == $user->id)>
                    {{ $user->name }} — {{ $user->email }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $employee->email ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Phone</label>
        <input name="phone" value="{{ old('phone', $employee->phone ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Job Title</label>
        <input name="job_title" value="{{ old('job_title', $employee->job_title ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Hire Date</label>
        <input type="date" name="hire_date" value="{{ old('hire_date', isset($employee) && $employee->hire_date ? $employee->hire_date->format('Y-m-d') : '') }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Salary</label>
        <input type="number" step="0.01" min="0" name="salary" value="{{ old('salary', $employee->salary ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="active" @selected(old('status', $employee->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $employee->status ?? '') === 'inactive')>Inactive</option>
            <option value="terminated" @selected(old('status', $employee->status ?? '') === 'terminated')>Terminated</option>
        </select>
    </div>
</div>

<div class="mt-4 d-flex justify-content-end gap-2">
    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">Cancel</a>
    <button class="btn btn-primary">Save Employee</button>
</div>
