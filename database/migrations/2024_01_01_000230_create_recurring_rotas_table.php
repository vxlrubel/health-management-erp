<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recurring_rotas', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rota_id')->constrained()->cascadeOnDelete();
            $table->foreignId('shift_template_id')->constrained()->cascadeOnDelete();
            $table->string('frequency');
            $table->json('days_of_week')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();
            $table->index(['branch_id', 'rota_id', 'status', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recurring_rotas');
    }
};
