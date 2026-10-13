@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Leave Requests</h2>
            <p class="text-muted mb-0">
                Manage and monitor employee leave requests.
            </p>
        </div>

        <a href="{{ route('web.leave-requests.create') }}"
           class="btn btn-primary">
            + Add Leave Request
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please check the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Total Days</th>
                            <th>Status</th>
                            <th style="min-width: 190px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($leaveRequests as $leaveRequest)
                            <tr>
                                <td>{{ $leaveRequest->leave_request_id }}</td>

                                <td>
                                    @if ($leaveRequest->employee)
                                        {{ $leaveRequest->employee->first_name }}
                                        {{ $leaveRequest->employee->last_name }}
                                    @else
                                        Unknown Employee
                                    @endif
                                </td>

                                <td>
                                    {{ $leaveRequest->leaveType->leave_name
                                        ?? 'Unknown Leave Type' }}
                                </td>

                                <td>
                                    {{ $leaveRequest->start_date
                                        ? $leaveRequest->start_date->format('M d, Y')
                                        : 'N/A' }}
                                </td>

                                <td>
                                    {{ $leaveRequest->end_date
                                        ? $leaveRequest->end_date->format('M d, Y')
                                        : 'N/A' }}
                                </td>

                                <td>{{ $leaveRequest->total_days ?? 'N/A' }}</td>

                                <td>
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
                                </td>

                                <td>
                                    <a href="{{ route('web.leave-requests.show', $leaveRequest->leave_request_id) }}"
                                       class="btn btn-info btn-sm">
                                        View
                                    </a>

                                    @if (in_array($leaveRequest->status, ['Pending', 'Rejected']))
                                        <a href="{{ route('web.leave-requests.edit', $leaveRequest->leave_request_id) }}"
                                           class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                    @endif

                                    <form action="{{ route('web.leave-requests.destroy', $leaveRequest->leave_request_id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this leave request?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    No leave requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $leaveRequests->links() }}
            </div>
        </div>
    </div>
</div>
@endsection