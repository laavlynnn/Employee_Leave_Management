<?php

namespace Database\Seeders;

use App\Models\Approval;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Database\Seeder;

class ApprovalSeeder extends Seeder
{
    public function run(): void
    {
        $approver = Employee::where(
            'email',
            'juan.delacruz@example.com'
        )->first();

        $rejectedRequest = LeaveRequest::where(
            'reason',
            'Family vacation'
        )->where(
            'start_date',
            '2026-11-02'
        )->first();

        $pendingRequest = LeaveRequest::where(
            'reason',
            'Medical appointment and recovery'
        )->where(
            'start_date',
            '2026-12-07'
        )->first();

        if (!$approver || !$rejectedRequest || !$pendingRequest) {
            $this->command?->warn(
                'Required employee or leave requests not found. Run the previous seeders first.'
            );

            return;
        }

        $approvals = [
            [
                'leave_request_id' => $rejectedRequest->leave_request_id,
                'approver_id' => $approver->employee_id,
                'approval_date' => now()->toDateString(),
                'approval_status' => 'Rejected',
                'remarks' => 'Leave request rejected for testing.',
                'approval_level' => 'Level 1',
            ],
            [
                'leave_request_id' => $pendingRequest->leave_request_id,
                'approver_id' => $approver->employee_id,
                'approval_date' => now()->toDateString(),
                'approval_status' => 'Pending',
                'remarks' => 'Awaiting review.',
                'approval_level' => 'Level 1',
            ],
        ];

        foreach ($approvals as $approval) {
            Approval::firstOrCreate(
                [
                    'leave_request_id' => $approval['leave_request_id'],
                    'approval_level' => $approval['approval_level'],
                ],
                $approval
            );
        }
    }
}