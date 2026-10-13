@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Edit Leave Request #{{ $leaveRequest->leave_request_id }}</h2>
            <p class="text-muted mb-0">
                Update the details of this leave request.
            </p>
        </div>

        <a href="{{ route('web.leave-requests.index') }}"
           class="btn btn-secondary">
            Back to Leave Requests
        </a>
    </div>

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

    <div class="card shadow-sm">
        <div class="card-header bg-warning">
            Edit Leave Request Information
        </div>

        <div class="card-body">
            <form action="{{ route('web.leave-requests.update', $leaveRequest->leave_request_id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="employee_id" class="form-label">
                        Employee <span class="text-danger">*</span>
                    </label>

                    <select name="employee_id"
                            id="employee_id"
                            class="form-select @error('employee_id') is-invalid @enderror"
                            required>
                        <option value="">Select Employee</option>

                        @foreach ($employees as $employee)
                            <option value="{{ $employee->employee_id }}"
                                {{ old('employee_id', $leaveRequest->employee_id) == $employee->employee_id ? 'selected' : '' }}>
                                {{ $employee->first_name }}
                                {{ $employee->last_name }}
                                ({{ $employee->email }})
                            </option>
                        @endforeach
                    </select>

                    @error('employee_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="leave_type_id" class="form-label">
                        Leave Type <span class="text-danger">*</span>
                    </label>

                    <select name="leave_type_id"
                            id="leave_type_id"
                            class="form-select @error('leave_type_id') is-invalid @enderror"
                            required>
                        <option value="">Select Leave Type</option>

                        @foreach ($leaveTypes as $leaveType)
                            <option value="{{ $leaveType->leave_type_id }}"
                                {{ old('leave_type_id', $leaveRequest->leave_type_id) == $leaveType->leave_type_id ? 'selected' : '' }}>
                                {{ $leaveType->leave_name }}
                                ({{ $leaveType->number_of_days }} days)
                            </option>
                        @endforeach
                    </select>

                    @error('leave_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">
                            Start Date <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="start_date"
                               id="start_date"
                               min="{{ date('Y-m-d') }}"
                               value="{{ old('start_date', $leaveRequest->start_date?->format('Y-m-d')) }}"
                               class="form-control @error('start_date') is-invalid @enderror"
                               required>

                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">
                            End Date <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="end_date"
                               id="end_date"
                               min="{{ old('start_date', $leaveRequest->start_date?->format('Y-m-d') ?? date('Y-m-d')) }}"
                               value="{{ old('end_date', $leaveRequest->end_date?->format('Y-m-d')) }}"
                               class="form-control @error('end_date') is-invalid @enderror"
                               required>

                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="reason" class="form-label">
                        Reason for Leave <span class="text-danger">*</span>
                    </label>

                    <textarea name="reason"
                              id="reason"
                              rows="4"
                              maxlength="2000"
                              class="form-control @error('reason') is-invalid @enderror"
                              required>{{ old('reason', $leaveRequest->reason) }}</textarea>

                    @error('reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="alert alert-info">
                    Current status:
                    <strong>{{ $leaveRequest->status }}</strong><br>
                    Saving changes will return the request to
                    <strong>Pending</strong> for review.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Save Changes
                    </button>

                    <a href="{{ route('web.leave-requests.index') }}"
                       class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    startDate.addEventListener('change', function () {
        endDate.min = this.value;

        if (endDate.value && endDate.value < this.value) {
            endDate.value = this.value;
        }
    });
</script>
@endsection