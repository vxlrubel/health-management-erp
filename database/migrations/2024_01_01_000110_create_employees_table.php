<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('employee_no')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender', 20)->nullable();
            $table->text('address')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('employment_type', 20);
            $table->decimal('hourly_rate', 12, 2)->nullable();
            $table->string('salary_type', 20);
            $table->string('status', 20)->default('active');
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['branch_id', 'status', 'deleted_at']);
            $table->index(['employment_type', 'salary_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
