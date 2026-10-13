<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id('approval_id');

            // Leave Request relationship
            $table->foreignId('leave_request_id')
                ->constrained('leave_requests', 'leave_request_id')
                ->cascadeOnDelete();

            // Approver is an employee
            $table->foreignId('approver_id')
                ->constrained('employees', 'employee_id')
                ->cascadeOnDelete();

            // Approval information
            $table->date('approval_date');
            $table->string('approval_status');
            $table->text('remarks')->nullable();
            $table->string('approval_level');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};