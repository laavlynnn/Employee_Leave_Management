<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::orderBy('leave_type_id', 'desc')
            ->paginate(10);

        return view('leave-types.index', compact('leaveTypes'));
    }

    public function create()
    {
        return view('leave-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'leave_name' => ['required', 'string', 'max:100'],
            'leave_code' => ['required', 'string', 'max:20', 'unique:leave_types,leave_code'],
            'description' => ['nullable', 'string'],
            'number_of_days' => ['required', 'integer', 'min:1'],
            'eligibility' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        LeaveType::create($validated);

        return redirect()
            ->route('web.leave-types.index')
            ->with('success', 'Leave type added successfully.');
    }

    public function show(string $id)
    {
        $leaveType = LeaveType::findOrFail($id);

        return view('leave-types.show', compact('leaveType'));
    }

    public function edit(string $id)
    {
        $leaveType = LeaveType::findOrFail($id);

        return view('leave-types.edit', compact('leaveType'));
    }

    public function update(Request $request, string $id)
    {
        $leaveType = LeaveType::findOrFail($id);

        $validated = $request->validate([
            'leave_name' => ['required', 'string', 'max:100'],
            'leave_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('leave_types', 'leave_code')
                    ->ignore($leaveType->leave_type_id, 'leave_type_id'),
            ],
            'description' => ['nullable', 'string'],
            'number_of_days' => ['required', 'integer', 'min:1'],
            'eligibility' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        $leaveType->update($validated);

        return redirect()
            ->route('web.leave-types.index')
            ->with('success', 'Leave type updated successfully.');
    }

    public function destroy(string $id)
    {
        $leaveType = LeaveType::findOrFail($id);

        if ($leaveType->leaveRequests()->exists()) {
            return redirect()
                ->route('web.leave-types.index')
                ->with('error', 'Cannot delete this leave type because it is used by existing leave requests.');
        }

        $leaveType->delete();

        return redirect()
            ->route('web.leave-types.index')
            ->with('success', 'Leave type deleted successfully.');
    }
}