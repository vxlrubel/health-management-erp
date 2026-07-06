<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('care_plans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('summary');
            $table->text('goals')->nullable();
            $table->text('risks')->nullable();
            $table->date('effective_from');
            $table->date('effective_to')->nullable();
            $table->string('status', 20)->default('active');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['client_id', 'status', 'deleted_at']);
            $table->index(['effective_from', 'effective_to']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('care_plans');
    }
};
