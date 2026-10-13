@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Employees</h2>
            <p class="text-secondary mb-0">Manage employee records.</p>
        </div>

        <a href="{{ route('web.employees.create') }}" class="btn btn-primary">
            + Add Employee
        </a>
    </div>

    <div class="card content-card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Employee Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Department</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($employees as $employee)
                            <tr>
                                <td>{{ $employee->employee_id }}</td>
                                <td>
                                    {{ $employee->first_name }}
                                    {{ $employee->middle_initial }}
                                    {{ $employee->last_name }}
                                </td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->contact_number }}</td>
                                <td>{{ $employee->department->department_name ?? 'Unassigned' }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('web.employees.show', $employee->employee_id) }}"
                                       class="btn btn-sm btn-info text-white">View</a>

                                    <a href="{{ route('web.employees.edit', $employee->employee_id) }}"
                                       class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('web.employees.destroy', $employee->employee_id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this employee?')">
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
                                <td colspan="6" class="text-center py-4">
                                    No employees found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $employees->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection