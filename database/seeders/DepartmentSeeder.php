<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'department_name' => 'Information Technology',
                'department_code' => 'IT',
                'location' => 'Main Building',
                'description' => 'Handles information technology and computer systems.',
                'department_head' => 'Juan Dela Cruz',
                'contact_number' => '09171234567',
            ],
            [
                'department_name' => 'Human Resources',
                'department_code' => 'HR',
                'location' => 'Administration Building',
                'description' => 'Handles employee records and human resource services.',
                'department_head' => 'Maria Garcia',
                'contact_number' => '09181234567',
            ],
            [
                'department_name' => 'Finance',
                'department_code' => 'FIN',
                'location' => 'Main Building',
                'description' => 'Handles financial records and budgeting.',
                'department_head' => 'Pedro Santos',
                'contact_number' => '09191234567',
            ],
        ];

        foreach ($departments as $department) {
            Department::firstOrCreate(
                ['department_code' => $department['department_code']],
                $department
            );
        }
    }
}