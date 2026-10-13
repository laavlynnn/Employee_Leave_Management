<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class LeaveRequestController extends Controller
{
    /**
     * Display all leave requests.
     */
    public function index()
    {
        $leaveRequests = LeaveRequest::with([
            'employee',
            'leaveType',
        ])
            ->orderBy('leave_request_id', 'desc')
            ->paginate(10);

        return view('leave-requests.index', compact('leaveRequests'));
    }

    /**
     * Show the form for creating a leave request.
     */
    public function create()
    {
        $employees = Employee::orderBy('last_name')->get();

        $leaveTypes = LeaveType::where('status', 'Active')
            ->orderBy('leave_name')
            ->get();

        return view(
            'leave-requests.create',
            compact('employees', 'leaveTypes')
        );
    }

    /**
     * Store a new leave request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => [
                'required',
                'exists:employees,employee_id',
            ],
            'leave_type_id' => [
                'required',
                Rule::exists('leave_types', 'leave_type_id')
                    ->where('status', 'Active'),
            ],
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],
            'reason' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        // New leave requests always begin as Pending.
        $validated['status'] = 'Pending';

        LeaveRequest::create($validated);

        return redirect()
            ->route('web.leave-requests.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    /**
     * Display a specific leave request.
     */
    public function show(string $id)
    {
        $leaveRequest = LeaveRequest::with([
            'employee',
            'leaveType',
            'approvals',
        ])->findOrFail($id);

        return view(
            'leave-requests.show',
            compact('leaveRequest')
        );
    }

    /**
     * Show the form for editing a leave request.
     */
    public function edit(string $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        if (!in_array($leaveRequest->status, ['Pending', 'Rejected'])) {
            return redirect()
                ->route('web.leave-requests.index')
                ->with(
                    'error',
                    'Only pending or rejected leave requests can be edited.'
                );
        }

        $employees = Employee::orderBy('last_name')->get();

        $leaveTypes = LeaveType::where('status', 'Active')
            ->orderBy('leave_name')
            ->get();

        // Include the current leave type even if it was later deactivated.
        if (
            $leaveRequest->leaveType &&
            !$leaveTypes->contains('leave_type_id', $leaveRequest->leave_type_id)
        ) {
            $leaveTypes->push($leaveRequest->leaveType);
        }

        return view(
            'leave-requests.edit',
            compact('leaveRequest', 'employees', 'leaveTypes')
        );
    }

    /**
     * Update an existing leave request.
     */
    public function update(Request $request, string $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        if (!in_array($leaveRequest->status, ['Pending', 'Rejected'])) {
            return redirect()
                ->route('web.leave-requests.index')
                ->with(
                    'error',
                    'Only pending or rejected leave requests can be edited.'
                );
        }

        $validated = $request->validate([
            'employee_id' => [
                'required',
                'exists:employees,employee_id',
            ],
            'leave_type_id' => [
                'required',
                Rule::exists('leave_types', 'leave_type_id')
                    ->where('status', 'Active'),
            ],
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],
            'reason' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        // Re-submitted requests return to Pending status.
        $validated['status'] = 'Pending';

        $leaveRequest->update($validated);

        return redirect()
            ->route('web.leave-requests.index')
            ->with(
                'success',
                'Leave request updated successfully and returned to Pending status.'
            );
    }

    /**
     * Delete a leave request if it has no approval records.
     */
    public function destroy(string $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        if ($leaveRequest->approvals()->exists()) {
            return redirect()
                ->route('web.leave-requests.index')
                ->with(
                    'error',
                    'Cannot delete this leave request because it has approval records.'
                );
        }

        $leaveRequest->delete();

        return redirect()
            ->route('web.leave-requests.index')
            ->with('success', 'Leave request deleted successfully.');
    }
}