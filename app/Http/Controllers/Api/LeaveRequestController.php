<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $leaveRequests = LeaveRequest::with([
            'employee.department',
            'leaveType',
            'approvals.approver'
        ])->get();

        return response()->json([
            'message' => 'Leave requests retrieved successfully.',
            'data' => $leaveRequests
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => [
                'required',
                'integer',
                Rule::exists('employees', 'employee_id')
            ],

            'leave_type_id' => [
                'required',
                'integer',
                Rule::exists('leave_types', 'leave_type_id')
            ],

            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'status' => 'nullable|string|max:50',
        ]);

        $validated['status'] = $validated['status'] ?? 'Pending';

        $leaveRequest = LeaveRequest::create($validated);

        return response()->json([
            'message' => 'Leave request created successfully.',
            'data' => $leaveRequest->load([
                'employee',
                'leaveType'
            ])
        ], 201);
    }

    public function show(string $id)
    {
        $leaveRequest = LeaveRequest::with([
            'employee.department',
            'leaveType',
            'approvals.approver'
        ])->find($id);

        if (!$leaveRequest) {
            return response()->json([
                'message' => 'Leave request not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Leave request retrieved successfully.',
            'data' => $leaveRequest
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $leaveRequest = LeaveRequest::find($id);

        if (!$leaveRequest) {
            return response()->json([
                'message' => 'Leave request not found.'
            ], 404);
        }

        $validated = $request->validate([
            'employee_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('employees', 'employee_id')
            ],

            'leave_type_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('leave_types', 'leave_type_id')
            ],

            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'reason' => 'sometimes|required|string',
            'status' => 'sometimes|required|string|max:50',
        ]);

        $leaveRequest->update($validated);

        return response()->json([
            'message' => 'Leave request updated successfully.',
            'data' => $leaveRequest->load([
                'employee',
                'leaveType'
            ])
        ], 200);
    }

    public function destroy(string $id)
    {
        $leaveRequest = LeaveRequest::find($id);

        if (!$leaveRequest) {
            return response()->json([
                'message' => 'Leave request not found.'
            ], 404);
        }

        $leaveRequest->delete();

        return response()->json([
            'message' => 'Leave request deleted successfully.'
        ], 200);
    }
}