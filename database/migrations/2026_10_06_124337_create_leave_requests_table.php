<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id('leave_request_id');

            // Relationships
            $table->foreignId('employee_id')
                ->constrained('employees', 'employee_id')
                ->cascadeOnDelete();

            $table->foreignId('leave_type_id')
                ->constrained('leave_types', 'leave_type_id')
                ->cascadeOnDelete();

            // Leave information
            $table->date('start_date');
            $table->date('end_date');
            $table->text('reason');
            $table->string('status')->default('Pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};