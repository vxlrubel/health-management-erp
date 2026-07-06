<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('invoice_id')->constrained();
            $table->decimal('amount', 12, 2)->default(0);
            $table->date('payment_date');
            $table->string('payment_method');
            $table->string('reference')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_payments');
    }
};
