<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratesheets', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('hourly_rate', 12, 2);
            $table->decimal('weekend_rate', 12, 2);
            $table->decimal('holiday_rate', 12, 2);
            $table->decimal('night_rate', 12, 2);
            $table->string('status')->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();
            $table->index(['status', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratesheets');
    }
};
