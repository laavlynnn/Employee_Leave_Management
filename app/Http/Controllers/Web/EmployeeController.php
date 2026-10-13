<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('department')
            ->orderBy('employee_id', 'desc')
            ->paginate(10);

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::orderBy('department_name')->get();

        return view('employees.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'middle_initial' => ['nullable', 'string', 'max:10'],
            'birthdate' => ['required', 'date', 'before:today'],
            'street' => ['nullable', 'string', 'max:255'],
            'barangay' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'contact_number' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255', 'unique:employees,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'department_id' => ['required', 'exists:departments,department_id'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Employee::create($validated);

        return redirect()
            ->route('web.employees.index')
            ->with('success', 'Employee added successfully.');
    }

    public function show(string $id)
    {
        $employee = Employee::with('department')->findOrFail($id);

        return view('employees.show', compact('employee'));
    }

    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::orderBy('department_name')->get();

        return view('employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'middle_initial' => ['nullable', 'string', 'max:10'],
            'birthdate' => ['required', 'date', 'before:today'],
            'street' => ['nullable', 'string', 'max:255'],
            'barangay' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'contact_number' => ['required', 'string', 'max:30'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('employees', 'email')
                    ->ignore($employee->employee_id, 'employee_id'),
            ],
            'department_id' => ['required', 'exists:departments,department_id'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $employee->update($validated);

        return redirect()
            ->route('web.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);

        if (
            $employee->leaveRequests()->exists() ||
            $employee->approvals()->exists()
        ) {
            return redirect()
                ->route('web.employees.index')
                ->with('error', 'Cannot delete this employee because they have leave requests or approvals.');
        }

        $employee->delete();

        return redirect()
            ->route('web.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}