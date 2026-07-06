<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_records', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('branch_id')->constrained();
            $table->string('month', 7);
            $table->decimal('working_hours', 10, 2)->default(0);
            $table->decimal('hourly_rate', 12, 2)->default(0);
            $table->decimal('overtime', 12, 2)->default(0);
            $table->decimal('bonus', 12, 2)->default(0);
            $table->decimal('deduction', 12, 2)->default(0);
            $table->decimal('net_salary', 12, 2)->default(0);
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_records');
    }
};
