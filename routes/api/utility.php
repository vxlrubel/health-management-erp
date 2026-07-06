<?php

use App\Http\Controllers\Utility\BulkActionsController;
use App\Http\Controllers\Utility\ExportCenterController;
use App\Http\Controllers\Utility\HealthController;
use App\Http\Controllers\Utility\SearchController;
use App\Http\Controllers\Utility\SystemConfigurationController;
use App\Http\Controllers\Utility\TrashController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Utility API Routes
|--------------------------------------------------------------------------
|
| All routes here are protected by auth except /health.
|
*/

// Health - public (no auth)
Route::get('/health', [HealthController::class, 'check']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // System Configuration
    Route::get('/system-configuration/trash', [SystemConfigurationController::class, 'trash']);
    Route::post('/system-configuration/{uuid}/restore', [SystemConfigurationController::class, 'restore']);
    Route::delete('/system-configuration/{uuid}/force-delete', [SystemConfigurationController::class, 'forceDelete']);
    Route::post('/system-configuration/bulk/delete', [SystemConfigurationController::class, 'bulkDelete']);
    Route::post('/system-configuration/bulk/restore', [SystemConfigurationController::class, 'bulkRestore']);
    Route::get('/system-configuration/export/{format}', [SystemConfigurationController::class, 'export']);
    Route::apiResource('/system-configuration', SystemConfigurationController::class);

    // Export Center
    Route::post('/export-center/csv', [ExportCenterController::class, 'exportCsv']);
    Route::post('/export-center/excel', [ExportCenterController::class, 'exportExcel']);
    Route::post('/export-center/pdf', [ExportCenterController::class, 'exportPdf']);
    Route::get('/export-center/download/{path}', [ExportCenterController::class, 'download'])->where('path', '.*');
    Route::get('/export-center', [ExportCenterController::class, 'index']);

    // Trash & Restore
    Route::get('/trash', [TrashController::class, 'index']);
    Route::post('/trash/restore', [TrashController::class, 'restore']);
    Route::delete('/trash/force-delete', [TrashController::class, 'forceDelete']);
    Route::post('/trash/bulk/restore', [TrashController::class, 'bulkRestore']);
    Route::delete('/trash/bulk/delete', [TrashController::class, 'bulkDelete']);

    // Global Search
    Route::get('/search/modules', [SearchController::class, 'modules']);
    Route::get('/search', [SearchController::class, 'index']);

    // Bulk Actions
    Route::get('/bulk-actions', [BulkActionsController::class, 'index']);
    Route::post('/bulk-actions', [BulkActionsController::class, 'store']);
});
