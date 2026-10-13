<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition(): array
    {
        return [
            'department_name' => fake()->unique()->words(2, true) . ' Department',
            'department_code' => strtoupper(Str::random(4)),
            'location' => fake()->streetAddress(),
            'description' => fake()->sentence(),
            'department_head' => fake()->name(),
            'contact_number' => '09' . fake()->numerify('#########'),
        ];
    }
}