@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Leave Types</h2>
            <p class="text-muted mb-0">Manage available leave categories.</p>
        </div>

        <a href="{{ route('web.leave-types.create') }}" class="btn btn-primary">
            + Add Leave Type
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Leave Name</th>
                            <th>Code</th>
                            <th>Days Allowed</th>
                            <th>Eligibility</th>
                            <th>Status</th>
                            <th style="min-width: 230px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($leaveTypes as $leaveType)
                            <tr>
                                <td>{{ $leaveType->leave_type_id }}</td>
                                <td>{{ $leaveType->leave_name }}</td>
                                <td>{{ $leaveType->leave_code }}</td>
                                <td>{{ $leaveType->number_of_days }}</td>
                                <td>{{ $leaveType->eligibility ?: 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $leaveType->status === 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $leaveType->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('web.leave-types.show', $leaveType->leave_type_id) }}"
                                       class="btn btn-sm btn-info">View</a>

                                    <a href="{{ route('web.leave-types.edit', $leaveType->leave_type_id) }}"
                                       class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('web.leave-types.destroy', $leaveType->leave_type_id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this leave type?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No leave types found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $leaveTypes->links() }}
        </div>
    </div>

</div>
@endsection