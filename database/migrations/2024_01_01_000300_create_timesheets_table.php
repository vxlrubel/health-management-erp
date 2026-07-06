<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('branch_id')->constrained();
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('regular_hours', 10, 2)->default(0);
            $table->decimal('overtime_hours', 10, 2)->default(0);
            $table->decimal('holiday_hours', 10, 2)->default(0);
            $table->string('status')->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timesheets');
    }
};
