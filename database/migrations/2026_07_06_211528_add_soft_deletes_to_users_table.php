<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
            $table->string('uuid')->nullable()->unique()->after('id');
            $table->unsignedBigInteger('branch_id')->nullable()->after('uuid');
            $table->unsignedBigInteger('role_id')->nullable()->after('branch_id');
            $table->string('phone')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('phone');
            $table->string('status')->default('active')->after('avatar');
            $table->timestamp('last_login_at')->nullable()->after('status');
            $table->unsignedBigInteger('created_by')->nullable()->after('remember_token');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            $table->unsignedBigInteger('deleted_by')->nullable()->after('updated_by');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['uuid', 'branch_id', 'role_id', 'phone', 'avatar', 'status', 'last_login_at', 'created_by', 'updated_by', 'deleted_by']);
        });
    }
};
