<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| MISC - Miscellaneous API Routes
|--------------------------------------------------------------------------
|
| Routes for medicines, media, messages, notifications,
| settings, reports, and dashboard endpoints.
|
*/

Route::middleware('auth:sanctum')->group(function () {

    // Medicines
    Route::get('medicines/trash', [MedicineController::class, 'trash']);
    Route::post('medicines/trash/restore', [MedicineController::class, 'bulkRestore']);
    Route::post('medicines/trash/delete', [MedicineController::class, 'bulkDelete']);
    Route::get('medicines/export', [MedicineController::class, 'export']);
    Route::post('medicines/{uuid}/restore', [MedicineController::class, 'restore']);
    Route::delete('medicines/{uuid}/force', [MedicineController::class, 'forceDelete']);
    Route::apiResource('medicines', MedicineController::class)->except(['edit', 'create']);

    // Media
    Route::get('media/export', [MediaController::class, 'export']);
    Route::post('media/trash/restore', [MediaController::class, 'bulkRestore']);
    Route::post('media/trash/delete', [MediaController::class, 'bulkDelete']);
    Route::delete('media/{uuid}/force', [MediaController::class, 'forceDelete']);
    Route::apiResource('media', MediaController::class)->only(['index', 'show', 'store', 'destroy']);

    // Messages
    Route::prefix('messages')->group(function () {
        Route::get('conversations', [MessageController::class, 'conversations']);
        Route::put('read', [MessageController::class, 'markRead']);
        Route::get('{conversation}', [MessageController::class, 'show']);
        Route::post('{conversation}', [MessageController::class, 'send']);
    });

    // Notifications
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::put('read', [NotificationController::class, 'markRead']);
        Route::put('read-all', [NotificationController::class, 'markAllRead']);
    });

    // Settings
    Route::get('settings/public', [SettingController::class, 'public']);
    Route::get('settings/export', [SettingController::class, 'export']);
    Route::get('settings/group/{group}', [SettingController::class, 'byGroup']);
    Route::apiResource('settings', SettingController::class)->except(['edit', 'create']);

    // Reports
    Route::prefix('reports')->group(function () {
        Route::get('dashboard', [ReportController::class, 'dashboard']);
        Route::get('activity', [ReportController::class, 'activity']);
        Route::get('schedule', [ReportController::class, 'schedule']);
        Route::get('employee', [ReportController::class, 'employee']);
        Route::get('client', [ReportController::class, 'client']);
        Route::get('invoice', [ReportController::class, 'invoice']);
        Route::get('salary', [ReportController::class, 'salary']);
        Route::get('leave', [ReportController::class, 'leave']);
        Route::get('export/pdf/{uuid}', [ReportController::class, 'exportPdf']);
        Route::get('export/excel/{uuid}', [ReportController::class, 'exportExcel']);
    });
    Route::apiResource('reports', ReportController::class)->except(['edit', 'create', 'update']);

    // Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('statistics', [DashboardController::class, 'statistics']);
        Route::get('charts', [DashboardController::class, 'charts']);
        Route::get('recent-activities', [DashboardController::class, 'recentActivities']);
        Route::get('today-schedule', [DashboardController::class, 'todaySchedule']);
        Route::get('revenue', [DashboardController::class, 'revenue']);
        Route::get('salary', [DashboardController::class, 'salary']);
    });

});
