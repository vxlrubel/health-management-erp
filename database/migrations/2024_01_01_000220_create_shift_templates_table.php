<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shift_templates', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('planned_hours', 8, 2);
            $table->integer('break_minutes')->default(0);
            $table->string('status')->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();
            $table->index(['branch_id', 'status', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shift_templates');
    }
};
