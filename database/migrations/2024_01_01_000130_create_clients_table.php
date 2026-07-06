<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('funder_id')->nullable()->constrained()->nullOnDelete();
            $table->string('client_no')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('care_level', 50)->nullable();
            $table->string('status', 20)->default('active');
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_phone')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['branch_id', 'status', 'deleted_at']);
            $table->index(['funder_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
