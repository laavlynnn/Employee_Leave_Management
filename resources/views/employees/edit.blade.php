@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Employee</h2>
        <a href="{{ route('web.employees.index') }}" class="btn btn-secondary">
            Back to Employees
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('web.employees.update', $employee->employee_id) }}" method="POST">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h5 class="mb-3">Personal Information</h5>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">First Name *</label>
                        <input type="text" name="first_name" class="form-control"
                            value="{{ old('first_name', $employee->first_name) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Middle Initial</label>
                        <input type="text" name="middle_initial" class="form-control"
                            value="{{ old('middle_initial', $employee->middle_initial) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Last Name *</label>
                        <input type="text" name="last_name" class="form-control"
                            value="{{ old('last_name', $employee->last_name) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Birthdate *</label>
                        <input type="date" name="birthdate" class="form-control"
                            value="{{ old('birthdate', $employee->birthdate ? \Illuminate\Support\Carbon::parse($employee->birthdate)->format('Y-m-d') : '') }}"
                            max="{{ date('Y-m-d', strtotime('-1 day')) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Number *</label>
                        <input type="text" name="contact_number" class="form-control"
                            value="{{ old('contact_number', $employee->contact_number) }}" required>
                    </div>
                </div>

                <h5 class="mb-3 mt-3">Address</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Street</label>
                        <input type="text" name="street" class="form-control"
                            value="{{ old('street', $employee->street) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Barangay</label>
                        <input type="text" name="barangay" class="form-control"
                            value="{{ old('barangay', $employee->barangay) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control"
                            value="{{ old('city', $employee->city) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Province</label>
                        <input type="text" name="province" class="form-control"
                            value="{{ old('province', $employee->province) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">ZIP Code</label>
                        <input type="text" name="zip_code" class="form-control"
                            value="{{ old('zip_code', $employee->zip_code) }}">
                    </div>
                </div>

                <h5 class="mb-3 mt-3">Account and Department</h5>

                <div class="mb-3">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" class="form-control"
                        value="{{ old('email', $employee->email) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control" minlength="8">
                        <small class="text-muted">Leave blank to keep the current password.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" minlength="8">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Department *</label>
                    <select name="department_id" class="form-select" required>
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->department_id }}"
                                {{ old('department_id', $employee->department_id) == $department->department_id ? 'selected' : '' }}>
                                {{ $department->department_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Employee</button>
                <a href="{{ route('web.employees.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection