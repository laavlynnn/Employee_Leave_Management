<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $leaveTypes = [
            [
                'leave_name' => 'Vacation Leave',
                'leave_code' => 'VL',
                'description' => 'Leave for rest, travel, and personal vacations.',
                'number_of_days' => 20,
                'eligibility' => 'Regular Employees',
                'status' => 'Active',
            ],
            [
                'leave_name' => 'Sick Leave',
                'leave_code' => 'SL',
                'description' => 'Leave for illness, medical treatment, or recovery.',
                'number_of_days' => 15,
                'eligibility' => 'All Employees',
                'status' => 'Active',
            ],
            [
                'leave_name' => 'Emergency Leave',
                'leave_code' => 'EL',
                'description' => 'Leave for urgent personal or family emergencies.',
                'number_of_days' => 5,
                'eligibility' => 'All Employees',
                'status' => 'Active',
            ],
            [
                'leave_name' => 'Maternity Leave',
                'leave_code' => 'ML',
                'description' => 'Leave for eligible employees related to childbirth.',
                'number_of_days' => 105,
                'eligibility' => 'Eligible Employees',
                'status' => 'Active',
            ],
            [
                'leave_name' => 'Paternity Leave',
                'leave_code' => 'PL',
                'description' => 'Leave for eligible fathers following childbirth.',
                'number_of_days' => 7,
                'eligibility' => 'Eligible Employees',
                'status' => 'Active',
            ],
        ];

        foreach ($leaveTypes as $leaveType) {
            LeaveType::firstOrCreate(
                ['leave_code' => $leaveType['leave_code']],
                $leaveType
            );
        }
    }
}