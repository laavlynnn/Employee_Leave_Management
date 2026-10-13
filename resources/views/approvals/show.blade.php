@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Approval Details</h2>
            <p class="text-muted mb-0">
                View the complete information for this approval record.
            </p>
        </div>

        <a href="{{ route('web.approvals.index') }}" class="btn btn-secondary">
            Back to Approvals
        </a>
    </div>

    @php
        $statusClass = match ($approval->approval_status) {
            'Pending' => 'bg-warning text-dark',
            'Approved' => 'bg-success',
            'Rejected' => 'bg-danger',
            default => 'bg-secondary',
        };
    @endphp

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <strong>Approval #{{ $approval->approval_id }}</strong>
            <span class="badge {{ $statusClass }}">
                {{ $approval->approval_status }}
            </span>
        </div>

        <div class="card-body">
            <h5 class="mb-3">Approval Information</h5>

            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <strong>Approval ID:</strong>
                    <p>{{ $approval->approval_id }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Approval Level:</strong>
                    <p>{{ $approval->approval_level ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Decision:</strong>
                    <p>
                        <span class="badge {{ $statusClass }}">
                            {{ $approval->approval_status }}
                        </span>
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Approval Date:</strong>
                    <p>
                        {{ $approval->approval_date
                            ? $approval->approval_date->format('F d, Y')
                            : 'Not yet recorded' }}
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Approver:</strong>
                    <p>
                        @if ($approval->approver)
                            {{ $approval->approver->first_name }}
                            {{ $approval->approver->last_name }}
                        @else
                            Unknown Approver
                        @endif
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Remarks:</strong>
                    <p class="text-break">
                        {{ $approval->remarks ?: 'No remarks provided.' }}
                    </p>
                </div>
            </div>

            <hr>

            <h5 class="mb-3">Leave Request Information</h5>

            @if ($approval->leaveRequest)
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Leave Request ID:</strong>
                        <p>{{ $approval->leaveRequest->leave_request_id }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Employee:</strong>
                        <p>
                            @if ($approval->leaveRequest->employee)
                                {{ $approval->leaveRequest->employee->first_name }}
                                {{ $approval->leaveRequest->employee->last_name }}
                            @else
                                Unknown Employee
                            @endif
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Leave Type:</strong>
                        <p>
                            {{ $approval->leaveRequest->leaveType->leave_name ?? 'Unknown Leave Type' }}
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Leave Request Status:</strong>
                        <p>
                            <span class="badge
                                @if ($approval->leaveRequest->status === 'Approved') bg-success
                                @elseif ($approval->leaveRequest->status === 'Rejected') bg-danger
                                @else bg-warning text-dark
                                @endif">
                                {{ $approval->leaveRequest->status }}
                            </span>
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Start Date:</strong>
                        <p>
                            {{ $approval->leaveRequest->start_date
                                ? $approval->leaveRequest->start_date->format('F d, Y')
                                : 'N/A' }}
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>End Date:</strong>
                        <p>
                            {{ $approval->leaveRequest->end_date
                                ? $approval->leaveRequest->end_date->format('F d, Y')
                                : 'N/A' }}
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Total Leave Days:</strong>
                        <p>{{ $approval->leaveRequest->total_days ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Reason:</strong>
                        <p class="text-break">
                            {{ $approval->leaveRequest->reason ?: 'No reason provided.' }}
                        </p>
                    </div>
                </div>
            @else
                <div class="alert alert-warning mb-0">
                    The associated leave request could not be found.
                </div>
            @endif
        </div>

        <div class="card-footer d-flex gap-2">
            <a href="{{ route('web.approvals.edit', $approval->approval_id) }}"
               class="btn btn-warning">
                Edit Approval
            </a>

            <a href="{{ route('web.approvals.index') }}"
               class="btn btn-outline-secondary">
                Back to List
            </a>
        </div>
    </div>

</div>
@endsection