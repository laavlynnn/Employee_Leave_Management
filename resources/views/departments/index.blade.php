@extends('layouts.app')

@section('title', 'Departments')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-1">Departments</h2>
        <p class="text-secondary mb-0">Manage your organization's departments.</p>
    </div>
    <a href="{{ route('web.departments.create') }}" class="btn btn-primary">
        + Add Department
    </a>
</div>

<div class="card content-card shadow-sm">
    <div class="card-body">
        @if ($departments->isEmpty())
            <div class="text-center py-5">
                <h5>No departments found</h5>
                <p class="text-secondary">Add your first department to get started.</p>
                <a href="{{ route('web.departments.create') }}" class="btn btn-primary">
                    Add Department
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Department Name</th>
                            <th>Code</th>
                            <th>Location</th>
                            <th>Department Head</th>
                            <th>Contact Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                            <tr>
                                <td>{{ $department->department_id }}</td>
                                <td>{{ $department->department_name }}</td>
                                <td>{{ $department->department_code }}</td>
                                <td>{{ $department->location ?? '—' }}</td>
                                <td>{{ $department->department_head ?? '—' }}</td>
                                <td>{{ $department->contact_number ?? '—' }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('web.departments.show', $department->department_id) }}"
                                           class="btn btn-sm btn-outline-info">View</a>

                                        <a href="{{ route('web.departments.edit', $department->department_id) }}"
                                           class="btn btn-sm btn-outline-primary">Edit</a>

                                        <form action="{{ route('web.departments.destroy', $department->department_id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this department?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $departments->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection