@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

    {{-- Dashboard Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">Dashboard</h2>
            <p class="text-secondary mb-0">
                Overview of your Employee Leave Management System.
            </p>
        </div>

        <a href="{{ route('web.leave-requests.create') }}" class="btn btn-primary">
            + New Leave Request
        </a>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl">
            <div class="card dashboard-card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-2">Departments</p>
                    <h2 class="fw-bold">{{ $departmentCount }}</h2>
                    <a href="{{ route('web.departments.index') }}"
                       class="small text-decoration-none">
                        View departments →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <div class="card dashboard-card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-2">Employees</p>
                    <h2 class="fw-bold">{{ $employeeCount }}</h2>
                    <a href="{{ route('web.employees.index') }}"
                       class="small text-decoration-none">
                        View employees →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <div class="card dashboard-card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-2">Leave Types</p>
                    <h2 class="fw-bold">{{ $leaveTypeCount }}</h2>
                    <a href="{{ route('web.leave-types.index') }}"
                       class="small text-decoration-none">
                        View leave types →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <div class="card dashboard-card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-2">Leave Requests</p>
                    <h2 class="fw-bold">{{ $leaveRequestCount }}</h2>
                    <a href="{{ route('web.leave-requests.index') }}"
                       class="small text-decoration-none">
                        View requests →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <div class="card dashboard-card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-2">Approvals</p>
                    <h2 class="fw-bold">{{ $approvalCount }}</h2>
                    <a href="{{ route('web.approvals.index') }}"
                       class="small text-decoration-none">
                        View approvals →
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Quick Actions --}}
    <div class="card content-card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Quick Actions</h5>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('web.departments.create') }}"
                   class="btn btn-outline-primary">
                    + Add Department
                </a>

                <a href="{{ route('web.employees.create') }}"
                   class="btn btn-outline-primary">
                    + Add Employee
                </a>

                <a href="{{ route('web.leave-types.create') }}"
                   class="btn btn-outline-primary">
                    + Add Leave Type
                </a>

                <a href="{{ route('web.leave-requests.create') }}"
                   class="btn btn-outline-primary">
                    + New Leave Request
                </a>

                <a href="{{ route('web.approvals.create') }}"
                   class="btn btn-outline-primary">
                    + Add Approval
                </a>
            </div>
        </div>
    </div>

    {{-- Recent Leave Requests --}}
    <div class="card content-card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <h5 class="fw-bold mb-0">Recent Leave Requests</h5>

                <a href="{{ route('web.leave-requests.index') }}"
                   class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3">Employee</th>
                            <th>Leave Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($recentRequests as $request)
                            <tr>
                                <td class="px-3">
                                    {{ $request->employee
                                        ? $request->employee->first_name . ' ' . $request->employee->last_name
                                        : 'Unknown Employee' }}
                                </td>

                                <td>
                                    {{ $request->leaveType->leave_name ?? 'Unknown Leave Type' }}
                                </td>

                                <td>
                                    {{ $request->start_date
                                        ? \Carbon\Carbon::parse($request->start_date)->format('M d, Y')
                                        : 'N/A' }}
                                </td>

                                <td>
                                    {{ $request->end_date
                                        ? \Carbon\Carbon::parse($request->end_date)->format('M d, Y')
                                        : 'N/A' }}
                                </td>

                                <td>
                                    @php
                                        $status = strtolower($request->status ?? 'pending');

                                        $badgeClass = match ($status) {
                                            'approved' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            'pending' => 'bg-warning text-dark',
                                            default => 'bg-secondary',
                                        };
                                    @endphp

                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($request->status ?? 'Pending') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-4">
                                    No leave requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
