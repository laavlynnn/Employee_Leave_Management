<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employee_id');

            // Name
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_initial')->nullable();

            // Address
            $table->string('street');
            $table->string('barangay');
            $table->string('city');
            $table->string('province');
            $table->string('zip_code');

            // Other employee information
            $table->date('birthdate');
            $table->string('email')->unique();
            $table->string('contact_number');

            // Relationship: Department 1 : Many Employees
            $table->foreignId('department_id')
                ->constrained('departments', 'department_id')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};