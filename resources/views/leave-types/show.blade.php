@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Leave Type Details</h2>

        <div>
            <a href="{{ route('web.leave-types.edit', $leaveType->leave_type_id) }}"
               class="btn btn-warning">
                Edit Leave Type
            </a>

            <a href="{{ route('web.leave-types.index') }}"
               class="btn btn-secondary">
                Back to Leave Types
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $leaveType->leave_name }}</h5>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Leave Type ID:</strong>
                    {{ $leaveType->leave_type_id }}
                </div>

                <div class="col-md-6">
                    <strong>Leave Code:</strong>
                    {{ $leaveType->leave_code }}
                </div>
            </div>

            <hr>

            <div class="mb-3">
                <strong>Description:</strong>
                <p class="mt-2 mb-0">
                    {{ $leaveType->description ?: 'No description provided.' }}
                </p>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Number of Days Allowed:</strong>
                    {{ $leaveType->number_of_days }} days
                </div>

                <div class="col-md-6">
                    <strong>Eligibility:</strong>
                    {{ $leaveType->eligibility ?: 'Not specified' }}
                </div>
            </div>

            <div class="mb-3">
                <strong>Status:</strong>

                @if ($leaveType->status === 'Active')
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-secondary">Inactive</span>
                @endif
            </div>

            <hr>

            <div class="row text-muted">
                <div class="col-md-6">
                    <small>
                        Created:
                        {{ $leaveType->created_at?->format('M d, Y h:i A') ?? 'N/A' }}
                    </small>
                </div>

                <div class="col-md-6">
                    <small>
                        Last Updated:
                        {{ $leaveType->updated_at?->format('M d, Y h:i A') ?? 'N/A' }}
                    </small>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection