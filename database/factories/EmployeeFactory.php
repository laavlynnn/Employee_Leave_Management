<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'middle_initial' => fake()->optional()->randomLetter(),
            'street' => fake()->streetAddress(),
            'barangay' => 'Barangay ' . fake()->numberBetween(1, 50),
            'city' => fake()->city(),
            'province' => fake()->randomElement([
                'Cebu',
                'Bohol',
                'Negros Oriental',
                'Leyte',
            ]),
            'zip_code' => (string) fake()->numberBetween(6000, 6999),
            'birthdate' => fake()->dateTimeBetween('-60 years', '-22 years')
                ->format('Y-m-d'),
            'contact_number' => '09' . fake()->numerify('#########'),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'department_id' => Department::factory(),
        ];
    }
}