<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\LeaveRequest;
use App\Models\Approval;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'departmentCount' => Department::count(),
            'employeeCount' => Employee::count(),
            'leaveTypeCount' => LeaveType::count(),
            'leaveRequestCount' => LeaveRequest::count(),
            'approvalCount' => Approval::count(),
            'recentRequests' => LeaveRequest::with([
                'employee',
                'leaveType',
            ])->latest()->take(5)->get(),
        ]);
    }
}