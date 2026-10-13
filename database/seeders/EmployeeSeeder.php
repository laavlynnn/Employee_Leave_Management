<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $department = Department::where('department_code', 'IT')->first();

        if (!$department) {
            $this->command?->warn(
                'IT department not found. Run DepartmentSeeder first.'
            );

            return;
        }

        $employees = [
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'middle_initial' => 'R',
                'street' => '123 Main Street',
                'barangay' => 'Lahug',
                'city' => 'Cebu City',
                'province' => 'Cebu',
                'zip_code' => '6000',
                'birthdate' => '2000-05-15',
                'contact_number' => '09171234567',
                'email' => 'maria.santos@example.com',
                'password' => Hash::make('password'),
                'department_id' => $department->department_id,
            ],
            [
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'middle_initial' => 'M',
                'street' => '45 Mabini Street',
                'barangay' => 'Lahug',
                'city' => 'Cebu City',
                'province' => 'Cebu',
                'zip_code' => '6000',
                'birthdate' => '1985-08-20',
                'contact_number' => '09181234568',
                'email' => 'juan.delacruz@example.com',
                'password' => Hash::make('password'),
                'department_id' => $department->department_id,
            ],
        ];

        foreach ($employees as $employee) {
            Employee::firstOrCreate(
                ['email' => $employee['email']],
                $employee
            );
        }
    }
}