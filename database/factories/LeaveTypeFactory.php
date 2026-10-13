<?php

namespace Database\Factories;

use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeaveType>
 */
class LeaveTypeFactory extends Factory
{
    protected $model = LeaveType::class;

    public function definition(): array
    {
        return [
            'leave_name' => fake()->unique()->randomElement([
                'Vacation Leave',
                'Sick Leave',
                'Emergency Leave',
                'Personal Leave',
                'Maternity Leave',
                'Paternity Leave',
            ]),
            'leave_code' => strtoupper(fake()->unique()->lexify('??')),
            'description' => fake()->sentence(),
            'number_of_days' => fake()->numberBetween(3, 20),
            'eligibility' => fake()->randomElement([
                'All Employees',
                'Regular Employees',
                'Eligible Employees',
            ]),
            'status' => 'Active',
        ];
    }
}