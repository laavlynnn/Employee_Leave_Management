@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Add Leave Approval</h2>
            <p class="text-muted mb-0">
                Record an approval decision for a leave request.
            </p>
        </div>

        <a href="{{ route('web.approvals.index') }}"
           class="btn btn-secondary">
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
        <div class="card-header bg-primary text-white">
            Approval Information
        </div>

        <div class="card-body">
            <form action="{{ route('web.approvals.store') }}" method="POST">
                @csrf

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
                                {{ old('leave_request_id') == $leaveRequest->leave_request_id ? 'selected' : '' }}>
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
                                {{ old('approver_id') == $employee->employee_id ? 'selected' : '' }}>
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
                        <option value="Level 1" {{ old('approval_level') == 'Level 1' ? 'selected' : '' }}>
                            Level 1
                        </option>
                        <option value="Level 2" {{ old('approval_level') == 'Level 2' ? 'selected' : '' }}>
                            Level 2
                        </option>
                        <option value="Level 3" {{ old('approval_level') == 'Level 3' ? 'selected' : '' }}>
                            Level 3
                        </option>
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
                        <option value="Pending" {{ old('approval_status', 'Pending') == 'Pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="Approved" {{ old('approval_status') == 'Approved' ? 'selected' : '' }}>
                            Approved
                        </option>
                        <option value="Rejected" {{ old('approval_status') == 'Rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>
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
                           value="{{ old('approval_date') }}"
                           class="form-control @error('approval_date') is-invalid @enderror">

                    <small class="text-muted">
                        Leave this blank to use today's date for an Approved or Rejected decision.
                    </small>

                    @error('approval_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="remarks" class="form-label">
                        Remarks
                    </label>

                    <textarea name="remarks"
                              id="remarks"
                              rows="4"
                              maxlength="2000"
                              class="form-control @error('remarks') is-invalid @enderror"
                              placeholder="Enter comments or the reason for the decision...">{{ old('remarks') }}</textarea>

                    @error('remarks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="alert alert-info">
                    <strong>Important:</strong> Selecting Approved or Rejected
                    updates the associated leave request's status based on the
                    latest approval record.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Save Approval
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