<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ApprovalController extends Controller
{
    public function index()
    {
        $approvals = Approval::with([
            'leaveRequest.employee',
            'leaveRequest.leaveType',
            'approver'
        ])->get();

        return response()->json([
            'message' => 'Approvals retrieved successfully.',
            'data' => $approvals
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'leave_request_id' => [
                'required',
                'integer',
                Rule::exists('leave_requests', 'leave_request_id')
            ],
            'approver_id' => [
                'required',
                'integer',
                Rule::exists('employees', 'employee_id')
            ],
            'approval_date' => 'required|date',
            'approval_status' => [
                'required',
                'string',
                'max:50',
                Rule::in(['Pending', 'Approved', 'Rejected'])
            ],
            'remarks' => 'nullable|string',
            'approval_level' => 'required|string|max:100',
        ]);

        $approval = DB::transaction(function () use ($validated) {
            $approval = Approval::create($validated);

            $this->syncLeaveRequestStatus($approval);

            return $approval;
        });

        return response()->json([
            'message' => 'Approval created successfully.',
            'data' => $approval->load([
                'leaveRequest',
                'approver'
            ])
        ], 201);
    }

    public function show(string $id)
    {
        $approval = Approval::with([
            'leaveRequest.employee',
            'leaveRequest.leaveType',
            'approver'
        ])->find($id);

        if (!$approval) {
            return response()->json([
                'message' => 'Approval not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Approval retrieved successfully.',
            'data' => $approval
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $approval = Approval::find($id);

        if (!$approval) {
            return response()->json([
                'message' => 'Approval not found.'
            ], 404);
        }

        $validated = $request->validate([
            'leave_request_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('leave_requests', 'leave_request_id')
            ],
            'approver_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('employees', 'employee_id')
            ],
            'approval_date' => 'sometimes|required|date',
            'approval_status' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::in(['Pending', 'Approved', 'Rejected'])
            ],
            'remarks' => 'nullable|string',
            'approval_level' => 'sometimes|required|string|max:100',
        ]);

        DB::transaction(function () use ($approval, $validated) {
            $approval->update($validated);
            $this->syncLeaveRequestStatus($approval);
        });

        return response()->json([
            'message' => 'Approval updated successfully.',
            'data' => $approval->fresh()->load([
                'leaveRequest',
                'approver'
            ])
        ], 200);
    }

    private function syncLeaveRequestStatus(Approval $approval): void
    {
        $leaveRequest = $approval->leaveRequest;

        if (!$leaveRequest) {
            return;
        }

        if ($approval->approval_status === 'Approved') {
            $leaveRequest->update([
                'status' => 'Approved'
            ]);
        } elseif ($approval->approval_status === 'Rejected') {
            $leaveRequest->update([
                'status' => 'Rejected'
            ]);
        } else {
            $leaveRequest->update([
                'status' => 'Pending'
            ]);
        }
    }

    public function destroy(string $id)
    {
        $approval = Approval::find($id);

        if (!$approval) {
            return response()->json([
                'message' => 'Approval not found.'
            ], 404);
        }

        $approval->delete();

        return response()->json([
            'message' => 'Approval deleted successfully.'
        ], 200);
    }
}
