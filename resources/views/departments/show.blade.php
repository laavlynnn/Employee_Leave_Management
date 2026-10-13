@extends('layouts.app')

@section('title', 'Department Details')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Department Details</h2>
        <a href="{{ route('web.departments.index') }}" class="btn btn-secondary">
            Back to Departments
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            Department Information
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 30%">Department ID</th>
                    <td>{{ $department->department_id }}</td>
                </tr>
                <tr>
                    <th>Department Name</th>
                    <td>{{ $department->department_name }}</td>
                </tr>
                <tr>
                    <th>Department Code</th>
                    <td>{{ $department->department_code }}</td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td>{{ $department->location ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $department->description ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Department Head</th>
                    <td>{{ $department->department_head ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Contact Number</th>
                    <td>{{ $department->contact_number ?? 'N/A' }}</td>
                </tr>
            </table>

            <a href="{{ route('web.departments.edit', $department->department_id) }}"
               class="btn btn-warning">
                Edit Department
            </a>

            <a href="{{ route('web.departments.index') }}"
               class="btn btn-outline-secondary">
                Back
            </a>
        </div>
    </div>
</div>
@endsection
