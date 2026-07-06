<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('status', 20)->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funders');
    }
};
