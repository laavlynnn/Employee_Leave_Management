@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Edit Leave Approval</h2>
            <p class="text-muted mb-0">
                Update the approval decision and its details.
            </p>
        </div>

        <a href="{{ route('web.approvals.index') }}" class="btn btn-secondary">
            Back to Approvals
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
            <strong>Approval #{{ $approval->approval_id }}</strong>
        </div>

        <div class="card-body">
            <form action="{{ route('web.approvals.update', $approval->approval_id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="leave_request_id" class="form-label">
                        Leave Request <span class="text-danger">*</span>
                    </label>

                    <select name="leave_request_id"
                            id="leave_request_id"
                            class="form-select @error('leave_request_id') is-invalid @enderror"
                            required>
                        <option value="">Select Leave Request</option>

                        @foreach ($leaveRequests as $leaveRequest)
                            <option value="{{ $leaveRequest->leave_request_id }}"
                                {{ old('leave_request_id', $approval->leave_request_id) == $leaveRequest->leave_request_id ? 'selected' : '' }}>
                                Request #{{ $leaveRequest->leave_request_id }}
                                -
                                {{ $leaveRequest->employee->first_name ?? 'Unknown' }}
                                {{ $leaveRequest->employee->last_name ?? '' }}
                                -
                                {{ $leaveRequest->leaveType->leave_name ?? 'Unknown Leave Type' }}
                                ({{ $leaveRequest->status }})
                            </option>
                        @endforeach
                    </select>

                    @error('leave_request_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="approver_id" class="form-label">
                        Approver <span class="text-danger">*</span>
                    </label>

                    <select name="approver_id"
                            id="approver_id"
                            class="form-select @error('approver_id') is-invalid @enderror"
                            required>
                        <option value="">Select Approver</option>

                        @foreach ($employees as $employee)
                            <option value="{{ $employee->employee_id }}"
                                {{ old('approver_id', $approval->approver_id) == $employee->employee_id ? 'selected' : '' }}>
                                {{ $employee->first_name }}
                                {{ $employee->last_name }}
                                ({{ $employee->email }})
                            </option>
                        @endforeach
                    </select>

                    @error('approver_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="approval_level" class="form-label">
                        Approval Level <span class="text-danger">*</span>
                    </label>

                    <select name="approval_level"
                            id="approval_level"
                            class="form-select @error('approval_level') is-invalid @enderror"
                            required>
                        <option value="">Select Approval Level</option>

                        @foreach (['Level 1', 'Level 2', 'Level 3'] as $level)
                            <option value="{{ $level }}"
                                {{ old('approval_level', $approval->approval_level) == $level ? 'selected' : '' }}>
                                {{ $level }}
                            </option>
                        @endforeach
                    </select>

                    @error('approval_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="approval_status" class="form-label">
                        Decision <span class="text-danger">*</span>
                    </label>

                    <select name="approval_status"
                            id="approval_status"
                            class="form-select @error('approval_status') is-invalid @enderror"
                            required>
                        <option value="">Select Decision</option>

                        @foreach (['Pending', 'Approved', 'Rejected'] as $status)
                            <option value="{{ $status }}"
                                {{ old('approval_status', $approval->approval_status) == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>

                    @error('approval_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="approval_date" class="form-label">
                        Approval Date
                    </label>

                    <input type="date"
                           name="approval_date"
                           id="approval_date"
                           value="{{ old('approval_date', $approval->approval_date?->format('Y-m-d')) }}"
                           class="form-control @error('approval_date') is-invalid @enderror">

                    <small class="text-muted">
                        If left blank, today's date is used for an Approved or Rejected decision.
                    </small>

                    @error('approval_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>

                    <textarea name="remarks"
                              id="remarks"
                              rows="4"
                              maxlength="2000"
                              class="form-control @error('remarks') is-invalid @enderror"
                              placeholder="Enter comments or the reason for the decision...">{{ old('remarks', $approval->remarks) }}</textarea>

                    @error('remarks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="alert alert-info">
                    Updating this approval may also update the status of its
                    associated leave request.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Save Changes
                    </button>

                    <a href="{{ route('web.approvals.index') }}"
                       class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection