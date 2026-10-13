<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('department')
            ->orderBy('employee_id', 'desc')
            ->get();

        return response()->json($employees);
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
            'password' => ['required', 'string', 'min:8'],
            'department_id' => ['required', 'exists:departments,department_id'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $employee = Employee::create($validated);

        return response()->json([
            'message' => 'Employee created successfully.',
            'employee' => $employee->load('department'),
        ], 201);
    }

    public function show(string $id)
    {
        $employee = Employee::with('department')
            ->findOrFail($id);

        return response()->json($employee);
    }

    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'first_name' => ['sometimes', 'required', 'string', 'max:100'],
            'last_name' => ['sometimes', 'required', 'string', 'max:100'],
            'middle_initial' => ['sometimes', 'nullable', 'string', 'max:10'],
            'birthdate' => ['sometimes', 'required', 'date', 'before:today'],
            'street' => ['sometimes', 'nullable', 'string', 'max:255'],
            'barangay' => ['sometimes', 'nullable', 'string', 'max:100'],
            'city' => ['sometimes', 'nullable', 'string', 'max:100'],
            'province' => ['sometimes', 'nullable', 'string', 'max:100'],
            'zip_code' => ['sometimes', 'nullable', 'string', 'max:10'],
            'contact_number' => ['sometimes', 'required', 'string', 'max:30'],
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('employees', 'email')
                    ->ignore($employee->employee_id, 'employee_id'),
            ],
            'password' => ['sometimes', 'required', 'string', 'min:8'],
            'department_id' => ['sometimes', 'required', 'exists:departments,department_id'],
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $employee->update($validated);

        return response()->json([
            'message' => 'Employee updated successfully.',
            'employee' => $employee->fresh()->load('department'),
        ]);
    }

    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);

        if (
            $employee->leaveRequests()->exists() ||
            $employee->approvals()->exists()
        ) {
            return response()->json([
                'message' => 'Cannot delete this employee because they have leave requests or approvals.',
            ], 422);
        }

        $employee->delete();

        return response()->json([
            'message' => 'Employee deleted successfully.',
        ]);
    }
}