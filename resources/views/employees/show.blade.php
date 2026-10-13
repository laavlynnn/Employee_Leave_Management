@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Employee Details</h2>

        <div>
            <a href="{{ route('web.employees.edit', $employee->employee_id) }}"
               class="btn btn-warning">
                Edit Employee
            </a>

            <a href="{{ route('web.employees.index') }}"
               class="btn btn-secondary">
                Back to Employees
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                {{ $employee->first_name }}
                {{ $employee->middle_initial }}
                {{ $employee->last_name }}
            </h5>
        </div>

        <div class="card-body">

            <h5 class="mb-3">Personal Information</h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Employee ID:</strong>
                    {{ $employee->employee_id }}
                </div>

                <div class="col-md-6">
                    <strong>Full Name:</strong>
                    {{ $employee->first_name }}
                    {{ $employee->middle_initial }}
                    {{ $employee->last_name }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Birthdate:</strong>
                    {{ $employee->birthdate
                        ? \Illuminate\Support\Carbon::parse($employee->birthdate)->format('F d, Y')
                        : 'N/A' }}
                </div>

                <div class="col-md-6">
                    <strong>Age:</strong>
                    {{ $employee->birthdate
                        ? \Illuminate\Support\Carbon::parse($employee->birthdate)->age . ' years old'
                        : 'N/A' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Email:</strong>
                    {{ $employee->email }}
                </div>

                <div class="col-md-6">
                    <strong>Contact Number:</strong>
                    {{ $employee->contact_number }}
                </div>
            </div>

            <hr>

            <h5 class="mb-3">Address Information</h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Street:</strong>
                    {{ $employee->street ?: 'N/A' }}
                </div>

                <div class="col-md-6">
                    <strong>Barangay:</strong>
                    {{ $employee->barangay ?: 'N/A' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>City:</strong>
                    {{ $employee->city ?: 'N/A' }}
                </div>

                <div class="col-md-4">
                    <strong>Province:</strong>
                    {{ $employee->province ?: 'N/A' }}
                </div>

                <div class="col-md-4">
                    <strong>ZIP Code:</strong>
                    {{ $employee->zip_code ?: 'N/A' }}
                </div>
            </div>

            <hr>

            <h5 class="mb-3">Department Information</h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Department:</strong>
                    {{ $employee->department->department_name ?? 'Not assigned' }}
                </div>

                <div class="col-md-6">
                    <strong>Department Code:</strong>
                    {{ $employee->department->department_code ?? 'N/A' }}
                </div>
            </div>

        </div>
    </div>

</div>
@endsection