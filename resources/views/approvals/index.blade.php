@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Leave Approvals</h2>
            <p class="text-muted mb-0">
                Review and manage employee leave approval records.
            </p>
        </div>

        <a href="{{ route('web.approvals.create') }}"
           class="btn btn-primary">
            + Add Approval
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

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
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Approver</th>
                            <th>Approval Level</th>
                            <th>Approval Date</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th style="min-width: 190px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($approvals as $approval)
                            <tr>
                                <td>{{ $approval->approval_id }}</td>

                                <td>
                                    @if ($approval->leaveRequest && $approval->leaveRequest->employee)
                                        {{ $approval->leaveRequest->employee->first_name }}
                                        {{ $approval->leaveRequest->employee->last_name }}
                                    @else
                                        Unknown Employee
                                    @endif
                                </td>

                                <td>
                                    {{ $approval->leaveRequest->leaveType->leave_name
                                        ?? 'Unknown Leave Type' }}
                                </td>

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
                                        ? $approval->approval_date->format('M d, Y')
                                        : 'N/A' }}
                                </td>

                                <td>
                                    @php
                                        $statusClass = match ($approval->approval_status) {
                                            'Pending' => 'bg-warning text-dark',
                                            'Approved' => 'bg-success',
                                            'Rejected' => 'bg-danger',
                                            default => 'bg-secondary',
                                        };
                                    @endphp

                                    <span class="badge {{ $statusClass }}">
                                        {{ $approval->approval_status }}
                                    </span>
                                </td>

                                <td>
                                    {{ $approval->remarks ?: 'No remarks' }}
                                </td>

                                <td>
                                    <a href="{{ route('web.approvals.show', $approval->approval_id) }}"
                                       class="btn btn-info btn-sm">
                                        View
                                    </a>

                                    <a href="{{ route('web.approvals.edit', $approval->approval_id) }}"
                                       class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('web.approvals.destroy', $approval->approval_id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this approval record?');">
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
                                <td colspan="9" class="text-center py-4">
                                    No approval records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $approvals->links() }}
            </div>
        </div>
    </div>
</div>
@endsection