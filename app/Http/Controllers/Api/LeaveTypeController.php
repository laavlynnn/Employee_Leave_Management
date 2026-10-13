<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::with('leaveRequests')->get();

        return response()->json([
            'message' => 'Leave types retrieved successfully.',
            'data' => $leaveTypes
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'leave_name' => 'required|string|max:255',
            'leave_code' => 'required|string|max:50|unique:leave_types,leave_code',
            'description' => 'nullable|string',
            'number_of_days' => 'required|integer|min:1',
            'eligibility' => 'required|string|max:255',
            'status' => 'required|string|max:50',
        ]);

        $leaveType = LeaveType::create($validated);

        return response()->json([
            'message' => 'Leave type created successfully.',
            'data' => $leaveType
        ], 201);
    }

    public function show(string $id)
    {
        $leaveType = LeaveType::with('leaveRequests')->find($id);

        if (!$leaveType) {
            return response()->json([
                'message' => 'Leave type not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Leave type retrieved successfully.',
            'data' => $leaveType
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $leaveType = LeaveType::find($id);

        if (!$leaveType) {
            return response()->json([
                'message' => 'Leave type not found.'
            ], 404);
        }

        $validated = $request->validate([
            'leave_name' => 'sometimes|required|string|max:255',
            'leave_code' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('leave_types', 'leave_code')
                    ->ignore($leaveType->leave_type_id, 'leave_type_id')
            ],
            'description' => 'nullable|string',
            'number_of_days' => 'sometimes|required|integer|min:1',
            'eligibility' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|string|max:50',
        ]);

        $leaveType->update($validated);

        return response()->json([
            'message' => 'Leave type updated successfully.',
            'data' => $leaveType
        ], 200);
    }

    public function destroy(string $id)
    {
        $leaveType = LeaveType::find($id);

        if (!$leaveType) {
            return response()->json([
                'message' => 'Leave type not found.'
            ], 404);
        }

        $leaveType->delete();

        return response()->json([
            'message' => 'Leave type deleted successfully.'
        ], 200);
    }
}