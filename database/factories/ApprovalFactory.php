<?php

namespace Database\Factories;

use App\Models\Approval;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Approval>
 */
class ApprovalFactory extends Factory
{
    protected $model = Approval::class;

    public function definition(): array
    {
        $status = fake()->randomElement([
            'Pending',
            'Approved',
            'Rejected',
        ]);

        return [
            'leave_request_id' => LeaveRequest::factory(),
            'approver_id' => Employee::factory(),
            'approval_date' => fake()
                ->dateTimeBetween('-3 months', 'now')
                ->format('Y-m-d'),
            'approval_status' => $status,
            'remarks' => fake()->optional()->sentence(),
            'approval_level' => fake()->randomElement([
                'Level 1',
                'Level 2',
                'Level 3',
            ]),
        ];
    }
}