<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('employees')->get();

        return response()->json([
            'message' => 'Departments retrieved successfully.',
            'data' => $departments
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:255',
            'department_code' => 'required|string|max:50|unique:departments,department_code',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department_head' => 'required|string|max:255',
            'contact_number' => 'required|string|max:30',
        ]);

        $department = Department::create($validated);

        return response()->json([
            'message' => 'Department created successfully.',
            'data' => $department
        ], 201);
    }

    public function show(string $id)
    {
        $department = Department::with('employees')->find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Department not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Department retrieved successfully.',
            'data' => $department
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Department not found.'
            ], 404);
        }

        $validated = $request->validate([
            'department_name' => 'sometimes|required|string|max:255',
            'department_code' => 'sometimes|required|string|max:50|unique:departments,department_code,' . $id . ',department_id',
            'location' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'department_head' => 'sometimes|required|string|max:255',
            'contact_number' => 'sometimes|required|string|max:30',
        ]);

        $department->update($validated);

        return response()->json([
            'message' => 'Department updated successfully.',
            'data' => $department
        ], 200);
    }

    public function destroy(string $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Department not found.'
            ], 404);
        }

        $department->delete();

        return response()->json([
            'message' => 'Department deleted successfully.'
        ], 200);
    }
}