@extends('layouts.app')

@section('title', 'Add Department')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add Department</h2>
        <a href="{{ route('web.departments.index') }}"
           class="btn btn-secondary">
            Back to Departments
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('web.departments.store') }}"
                  method="POST">
                @csrf

                <div class="mb-3">
                    <label for="department_name" class="form-label">
                        Department Name
                    </label>
                    <input
                        type="text"
                        name="department_name"
                        id="department_name"
                        class="form-control @error('department_name') is-invalid @enderror"
                        value="{{ old('department_name') }}"
                        required
                    >
                    @error('department_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="department_code" class="form-label">
                        Department Code
                    </label>
                    <input
                        type="text"
                        name="department_code"
                        id="department_code"
                        class="form-control @error('department_code') is-invalid @enderror"
                        value="{{ old('department_code') }}"
                        required
                    >
                    @error('department_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">
                        Location
                    </label>
                    <input
                        type="text"
                        name="location"
                        id="location"
                        class="form-control"
                        value="{{ old('location') }}"
                    >
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">
                        Description
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="3"
                    >{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="department_head" class="form-label">
                        Department Head
                    </label>
                    <input
                        type="text"
                        name="department_head"
                        id="department_head"
                        class="form-control"
                        value="{{ old('department_head') }}"
                    >
                </div>

                <div class="mb-3">
                    <label for="contact_number" class="form-label">
                        Contact Number
                    </label>
                    <input
                        type="text"
                        name="contact_number"
                        id="contact_number"
                        class="form-control"
                        value="{{ old('contact_number') }}"
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    Save Department
                </button>

                <a href="{{ route('web.departments.index') }}"
                   class="btn btn-outline-secondary">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
