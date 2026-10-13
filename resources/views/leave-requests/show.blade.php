@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Leave Request Details</h2>
            <p class="text-muted mb-0">
                Request #{{ $leaveRequest->leave_request_id }}
            </p>
        </div>

        <a href="{{ route('web.leave-requests.index') }}"
           class="btn btn-secondary">
            Back to Leave Requests
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            Leave Request Information
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Request ID:</strong>
                    <p>{{ $leaveRequest->leave_request_id }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Status:</strong>
                    <p>
                        @php
                            $statusClass = match ($leaveRequest->status) {
                                'Pending' => 'bg-warning text-dark',
                                'Approved' => 'bg-success',
                                'Rejected' => 'bg-danger',
                                default => 'bg-secondary',
                            };
                        @endphp

                        <span class="badge {{ $statusClass }}">
                            {{ $leaveRequest->status }}
                        </span>
                    </p>
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Employee Name:</strong>
                    <p>
                        @if ($leaveRequest->employee)
                            {{ $leaveRequest->employee->first_name }}
                            {{ $leaveRequest->employee->middle_initial
                                ? $leaveRequest->employee->middle_initial . '. '
                                : ' ' }}
                            {{ $leaveRequest->employee->last_name }}
                        @else
                            Unknown Employee
                        @endif
                    </p>
                </div>

                <div class="col-md-6">
                    <strong>Employee Email:</strong>
                    <p>
                        {{ $leaveRequest->employee->email ?? 'N/A' }}
                    </p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Leave Type:</strong>
                    <p>
                        {{ $leaveRequest->leaveType->leave_name
                            ?? 'Unknown Leave Type' }}
                    </p>
                </div>

                <div class="col-md-6">
                    <strong>Allowed Days for Leave Type:</strong>
                    <p>
                        {{ $leaveRequest->leaveType->number_of_days
                            ?? 'N/A' }}
                    </p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Start Date:</strong>
                    <p>
                        {{ $leaveRequest->start_date
                            ? $leaveRequest->start_date->format('F d, Y')
                            : 'N/A' }}
                    </p>
                </div>

                <div class="col-md-6">
                    <strong>End Date:</strong>
                    <p>
                        {{ $leaveRequest->end_date
                            ? $leaveRequest->end_date->format('F d, Y')
                            : 'N/A' }}
                    </p>
                </div>
            </div>

            <div class="mb-3">
                <strong>Total Leave Days:</strong>
                <p>{{ $leaveRequest->total_days ?? 'N/A' }} day(s)</p>
            </div>

            <div class="mb-3">
                <strong>Reason for Leave:</strong>
                <div class="border rounded p-3 bg-light">
                    {{ $leaveRequest->reason }}
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                @if (in_array($leaveRequest->status, ['Pending', 'Rejected']))
                    <a href="{{ route('web.leave-requests.edit', $leaveRequest->leave_request_id) }}"
                       class="btn btn-warning">
                        Edit Request
                    </a>
                @endif

                <a href="{{ route('web.leave-requests.index') }}"
                   class="btn btn-outline-secondary">
                    Back
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Approval History
        </div>

        <div class="card-body">
            @if ($leaveRequest->approvals->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Approval ID</th>
                                <th>Approver</th>
                                <th>Approval Level</th>
                                <th>Approval Date</th>
                                <th>Status</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($leaveRequest->approvals as $approval)
                                <tr>
                                    <td>{{ $approval->approval_id }}</td>

                                    <td>
                                        @if ($approval->approver)
                                            {{ $approval->approver->first_name }}
                                            {{ $approval->approver->last_name }}
                                        @else
                                            Unknown Approver
                                        @endif
                                    </td>

                                    <td>
                                        {{ $approval->approval_level ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $approval->approval_date
                                            ? \Carbon\Carbon::parse($approval->approval_date)->format('M d, Y')
                                            : 'N/A' }}
                                    </td>

                                    <td>
                                        @php
                                            $approvalClass = match ($approval->approval_status) {
                                                'Approved' => 'bg-success',
                                                'Rejected' => 'bg-danger',
                                                default => 'bg-warning text-dark',
                                            };
                                        @endphp

                                        <span class="badge {{ $approvalClass }}">
                                            {{ $approval->approval_status }}
                                        </span>
                                    </td>

                                    <td>{{ $approval->remarks ?? 'No remarks' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mb-0">
                    No approval records are available for this leave request yet.
                </div>
            @endif
        </div>
    </div>

</div>
@endsection