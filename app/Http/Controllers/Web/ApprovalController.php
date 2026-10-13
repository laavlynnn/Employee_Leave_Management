<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApprovalController extends Controller
{
    /**
     * Display all approval records.
     */
    public function index()
    {
        $approvals = Approval::with([
            'leaveRequest.employee',
            'leaveRequest.leaveType',
            'approver',
        ])
            ->orderBy('approval_id', 'desc')
            ->paginate(10);

        return view('approvals.index', compact('approvals'));
    }

    /**
     * Show the form for creating an approval.
     */
    public function create()
    {
        $leaveRequests = LeaveRequest::with(['employee', 'leaveType'])
            ->orderBy('leave_request_id', 'desc')
            ->get();

        $employees = Employee::orderBy('last_name')->get();

        return view(
            'approvals.create',
            compact('leaveRequests', 'employees')
        );
    }

    /**
     * Store a new approval record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'leave_request_id' => [
                'required',
                'exists:leave_requests,leave_request_id',
            ],
            'approver_id' => [
                'required',
                'exists:employees,employee_id',
            ],
            'approval_date' => [
                'nullable',
                'date',
            ],
            'approval_status' => [
                'required',
                Rule::in(['Pending', 'Approved', 'Rejected']),
            ],
            'remarks' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'approval_level' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        if (
            $validated['approval_status'] === 'Pending'
            && empty($validated['approval_date'])
        ) {
            $validated['approval_date'] = null;
        } elseif (empty($validated['approval_date'])) {
            $validated['approval_date'] = now()->toDateString();
        }

        $approval = Approval::create($validated);

        $this->syncLeaveRequestStatus($approval->leave_request_id);

        return redirect()
            ->route('web.approvals.index')
            ->with('success', 'Approval record created successfully.');
    }

    /**
     * Display a specific approval record.
     */
    public function show(string $id)
    {
        $approval = Approval::with([
            'leaveRequest.employee',
            'leaveRequest.leaveType',
            'approver',
        ])->findOrFail($id);

        return view('approvals.show', compact('approval'));
    }

    /**
     * Show the form for editing an approval record.
     */
    public function edit(string $id)
    {
        $approval = Approval::findOrFail($id);

        $leaveRequests = LeaveRequest::with(['employee', 'leaveType'])
            ->orderBy('leave_request_id', 'desc')
            ->get();

        $employees = Employee::orderBy('last_name')->get();

        return view(
            'approvals.edit',
            compact('approval', 'leaveRequests', 'employees')
        );
    }

    /**
     * Update an approval record.
     */
    public function update(Request $request, string $id)
    {
        $approval = Approval::findOrFail($id);

        $validated = $request->validate([
            'leave_request_id' => [
                'required',
                'exists:leave_requests,leave_request_id',
            ],
            'approver_id' => [
                'required',
                'exists:employees,employee_id',
            ],
            'approval_date' => [
                'nullable',
                'date',
            ],
            'approval_status' => [
                'required',
                Rule::in(['Pending', 'Approved', 'Rejected']),
            ],
            'remarks' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'approval_level' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        if (
            $validated['approval_status'] === 'Pending'
            && empty($validated['approval_date'])
        ) {
            $validated['approval_date'] = null;
        } elseif (empty($validated['approval_date'])) {
            $validated['approval_date'] = now()->toDateString();
        }

        $oldLeaveRequestId = $approval->leave_request_id;

        $approval->update($validated);

        $this->syncLeaveRequestStatus($oldLeaveRequestId);

        if ($approval->leave_request_id != $oldLeaveRequestId) {
            $this->syncLeaveRequestStatus($approval->leave_request_id);
        }

        return redirect()
            ->route('web.approvals.index')
            ->with('success', 'Approval record updated successfully.');
    }

    /**
     * Delete an approval record.
     */
    public function destroy(string $id)
    {
        $approval = Approval::findOrFail($id);
        $leaveRequestId = $approval->leave_request_id;

        $approval->delete();

        $this->syncLeaveRequestStatus($leaveRequestId);

        return redirect()
            ->route('web.approvals.index')
            ->with('success', 'Approval record deleted successfully.');
    }

    /**
     * Synchronize a leave request status with its approval records.
     */
    private function syncLeaveRequestStatus(int $leaveRequestId): void
    {
        $leaveRequest = LeaveRequest::find($leaveRequestId);

        if (!$leaveRequest) {
            return;
        }

        $latestApproval = Approval::where(
            'leave_request_id',
            $leaveRequestId
        )
            ->orderByDesc('approval_date')
            ->orderByDesc('approval_id')
            ->first();

        if (!$latestApproval) {
            $leaveRequest->update(['status' => 'Pending']);
            return;
        }

        if (in_array($latestApproval->approval_status, ['Approved', 'Rejected'])) {
            $leaveRequest->update([
                'status' => $latestApproval->approval_status,
            ]);
        } else {
            $leaveRequest->update(['status' => 'Pending']);
        }
    }
}