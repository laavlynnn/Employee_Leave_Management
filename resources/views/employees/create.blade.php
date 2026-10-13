@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add Employee</h2>
        <a href="{{ route('web.employees.index') }}" class="btn btn-secondary">
            Back to Employees
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('web.employees.store') }}" method="POST">
                @csrf

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
                        <input type="text" name="first_name"
                            class="form-control" value="{{ old('first_name') }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Middle Initial</label>
                        <input type="text" name="middle_initial"
                            class="form-control" value="{{ old('middle_initial') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Last Name *</label>
                        <input type="text" name="last_name"
                            class="form-control" value="{{ old('last_name') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Birthdate *</label>
                        <input type="date" name="birthdate"
                            class="form-control" value="{{ old('birthdate') }}"
                            max="{{ date('Y-m-d', strtotime('-1 day')) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Number *</label>
                        <input type="text" name="contact_number"
                            class="form-control" value="{{ old('contact_number') }}" required>
                    </div>
                </div>

                <h5 class="mb-3 mt-3">Address</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Street</label>
                        <input type="text" name="street"
                            class="form-control" value="{{ old('street') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Barangay</label>
                        <input type="text" name="barangay"
                            class="form-control" value="{{ old('barangay') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city"
                            class="form-control" value="{{ old('city') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Province</label>
                        <input type="text" name="province"
                            class="form-control" value="{{ old('province') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">ZIP Code</label>
                        <input type="text" name="zip_code"
                            class="form-control" value="{{ old('zip_code') }}">
                    </div>
                </div>

                <h5 class="mb-3 mt-3">Account and Department</h5>

                <div class="mb-3">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email"
                        class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password *</label>
                        <input type="password" name="password"
                            class="form-control" minlength="8" required>
                        <small class="text-muted">At least 8 characters.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" name="password_confirmation"
                            class="form-control" minlength="8" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Department *</label>
                    <select name="department_id" class="form-select" required>
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->department_id }}"
                                {{ old('department_id') == $department->department_id ? 'selected' : '' }}>
                                {{ $department->department_name }}
                            </option>
                        @endforeach
                    </select>

                    @if ($departments->isEmpty())
                        <div class="text-danger mt-2">
                            No departments available. Please add a department first.
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Save Employee</button>
                <a href="{{ route('web.employees.index') }}"
                    class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection