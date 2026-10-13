<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeaveRequest>
 */
class LeaveRequestFactory extends Factory
{
    protected $model = LeaveRequest::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('+1 day', '+3 months');
        $totalDays = fake()->numberBetween(1, 5);

        $endDate = (clone $startDate)->modify('+' . ($totalDays - 1) . ' days');

        return [
            'employee_id' => Employee::factory(),
            'leave_type_id' => LeaveType::factory(),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'reason' => fake()->sentence(),
            'status' => fake()->randomElement([
                'Pending',
                'Approved',
                'Rejected',
            ]),
        ];
    }
}