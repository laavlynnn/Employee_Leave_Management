@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Leave Type</h2>

        <a href="{{ route('web.leave-types.index') }}" class="btn btn-secondary">
            Back to Leave Types
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Please correct the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('web.leave-types.update', $leaveType->leave_type_id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="leave_name" class="form-label">Leave Name *</label>
                    <input
                        type="text"
                        name="leave_name"
                        id="leave_name"
                        class="form-control"
                        value="{{ old('leave_name', $leaveType->leave_name) }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="leave_code" class="form-label">Leave Code *</label>
                    <input
                        type="text"
                        name="leave_code"
                        id="leave_code"
                        class="form-control"
                        value="{{ old('leave_code', $leaveType->leave_code) }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="3"
                    >{{ old('description', $leaveType->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="number_of_days" class="form-label">Number of Days Allowed *</label>
                    <input
                        type="number"
                        name="number_of_days"
                        id="number_of_days"
                        class="form-control"
                        value="{{ old('number_of_days', $leaveType->number_of_days) }}"
                        min="1"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="eligibility" class="form-label">Eligibility</label>
                    <input
                        type="text"
                        name="eligibility"
                        id="eligibility"
                        class="form-control"
                        value="{{ old('eligibility', $leaveType->eligibility) }}"
                    >
                </div>

                <div class="mb-4">
                    <label for="status" class="form-label">Status *</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="Active"
                            {{ old('status', $leaveType->status) === 'Active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="Inactive"
                            {{ old('status', $leaveType->status) === 'Inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Update Leave Type
                </button>

                <a href="{{ route('web.leave-types.index') }}"
                   class="btn btn-outline-secondary">
                    Cancel
                </a>
            </form>

        </div>
    </div>
</div>
@endsection