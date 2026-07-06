<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicine_administrations', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('medicine_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->timestamp('administered_at')->nullable();
            $table->string('dose_given')->nullable();
            $table->string('status')->default('active');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('medicine_administrations');
    }
};
