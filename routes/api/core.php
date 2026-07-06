<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot-password');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('auth.profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('auth.update-profile');
    Route::put('/change-password', [AuthController::class, 'changePassword'])->name('auth.change-password');

    Route::apiResource('users', UserController::class)->parameters(['users' => 'uuid']);
    Route::apiResource('branches', BranchController::class)->parameters(['branches' => 'uuid']);

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/trash/all', [UserController::class, 'trash'])->name('trash');
        Route::post('/{uuid}/restore', [UserController::class, 'restore'])->name('restore');
        Route::delete('/{uuid}/force-delete', [UserController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk/delete', [UserController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk/restore', [UserController::class, 'bulkRestore'])->name('bulk-restore');
        Route::get('/export', [UserController::class, 'export'])->name('export');
    });

    Route::prefix('branches')->name('branches.')->group(function () {
        Route::get('/trash/all', [BranchController::class, 'trash'])->name('trash');
        Route::post('/{uuid}/restore', [BranchController::class, 'restore'])->name('restore');
        Route::delete('/{uuid}/force-delete', [BranchController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk/delete', [BranchController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk/restore', [BranchController::class, 'bulkRestore'])->name('bulk-restore');
        Route::get('/export', [BranchController::class, 'export'])->name('export');
    });
});

require __DIR__ . '/misc.php';
