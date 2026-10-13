<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveRequestSeeder extends Seeder
{
    public function run(): void
    {
        $employee = Employee::where(
            'email',
            'maria.santos@example.com'
        )->first();

        $vacationLeave = LeaveType::where(
            'leave_code',
            'VL'
        )->first();

        $sickLeave = LeaveType::where(
            'leave_code',
            'SL'
        )->first();

        if (!$employee || !$vacationLeave || !$sickLeave) {
            $this->command?->warn(
                'Required employee or leave type not found. Run the previous seeders first.'
            );

            return;
        }

        $leaveRequests = [
            [
                'employee_id' => $employee->employee_id,
                'leave_type_id' => $vacationLeave->leave_type_id,
                'start_date' => '2026-11-02',
                'end_date' => '2026-11-04',
                'reason' => 'Family vacation',
                'status' => 'Rejected',
            ],
            [
                'employee_id' => $employee->employee_id,
                'leave_type_id' => $sickLeave->leave_type_id,
                'start_date' => '2026-12-07',
                'end_date' => '2026-12-08',
                'reason' => 'Medical appointment and recovery',
                'status' => 'Pending',
            ],
        ];

        foreach ($leaveRequests as $leaveRequest) {
            LeaveRequest::firstOrCreate(
                [
                    'employee_id' => $leaveRequest['employee_id'],
                    'leave_type_id' => $leaveRequest['leave_type_id'],
                    'start_date' => $leaveRequest['start_date'],
                    'end_date' => $leaveRequest['end_date'],
                ],
                $leaveRequest
            );
        }
    }
}