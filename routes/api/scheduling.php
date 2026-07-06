<?php

use App\Http\Controllers\Api\ActivitiesController;
use App\Http\Controllers\Api\HolidayCalendarController;
use App\Http\Controllers\Api\RatesheetsController;
use App\Http\Controllers\Api\RecurringRotasController;
use App\Http\Controllers\Api\RotasController;
use App\Http\Controllers\Api\SchedulesController;
use App\Http\Controllers\Api\ShiftTemplatesController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // Ratesheets
    Route::prefix('ratesheets')->name('ratesheets.')->group(function () {
        Route::get('/', [RatesheetsController::class, 'index'])->name('index');
        Route::post('/', [RatesheetsController::class, 'store'])->name('store');
        Route::get('trash', [RatesheetsController::class, 'trash'])->name('trash');
        Route::post('bulk-delete', [RatesheetsController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('bulk-restore', [RatesheetsController::class, 'bulkRestore'])->name('bulk-restore');
        Route::get('{uuid}', [RatesheetsController::class, 'show'])->name('show');
        Route::put('{uuid}', [RatesheetsController::class, 'update'])->name('update');
        Route::patch('{uuid}', [RatesheetsController::class, 'update'])->name('update-patch');
        Route::delete('{uuid}', [RatesheetsController::class, 'destroy'])->name('destroy');
        Route::patch('{uuid}/restore', [RatesheetsController::class, 'restore'])->name('restore');
        Route::delete('{uuid}/force-delete', [RatesheetsController::class, 'forceDelete'])->name('force-delete');
    });

    // Rotas
    Route::prefix('rotas')->name('rotas.')->group(function () {
        Route::get('/', [RotasController::class, 'index'])->name('index');
        Route::post('/', [RotasController::class, 'store'])->name('store');
        Route::get('trash', [RotasController::class, 'trash'])->name('trash');
        Route::post('bulk-delete', [RotasController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('bulk-restore', [RotasController::class, 'bulkRestore'])->name('bulk-restore');
        Route::get('{uuid}', [RotasController::class, 'show'])->name('show');
        Route::put('{uuid}', [RotasController::class, 'update'])->name('update');
        Route::patch('{uuid}', [RotasController::class, 'update'])->name('update-patch');
        Route::delete('{uuid}', [RotasController::class, 'destroy'])->name('destroy');
        Route::patch('{uuid}/restore', [RotasController::class, 'restore'])->name('restore');
        Route::delete('{uuid}/force-delete', [RotasController::class, 'forceDelete'])->name('force-delete');
    });

    // Shift Templates
    Route::prefix('shift-templates')->name('shift-templates.')->group(function () {
        Route::get('/', [ShiftTemplatesController::class, 'index'])->name('index');
        Route::post('/', [ShiftTemplatesController::class, 'store'])->name('store');
        Route::get('trash', [ShiftTemplatesController::class, 'trash'])->name('trash');
        Route::post('bulk-delete', [ShiftTemplatesController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('bulk-restore', [ShiftTemplatesController::class, 'bulkRestore'])->name('bulk-restore');
        Route::get('{uuid}', [ShiftTemplatesController::class, 'show'])->name('show');
        Route::put('{uuid}', [ShiftTemplatesController::class, 'update'])->name('update');
        Route::patch('{uuid}', [ShiftTemplatesController::class, 'update'])->name('update-patch');
        Route::delete('{uuid}', [ShiftTemplatesController::class, 'destroy'])->name('destroy');
        Route::patch('{uuid}/restore', [ShiftTemplatesController::class, 'restore'])->name('restore');
        Route::delete('{uuid}/force-delete', [ShiftTemplatesController::class, 'forceDelete'])->name('force-delete');
    });

    // Recurring Rotas
    Route::prefix('recurring-rotas')->name('recurring-rotas.')->group(function () {
        Route::get('/', [RecurringRotasController::class, 'index'])->name('index');
        Route::post('/', [RecurringRotasController::class, 'store'])->name('store');
        Route::get('trash', [RecurringRotasController::class, 'trash'])->name('trash');
        Route::post('bulk-delete', [RecurringRotasController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('bulk-restore', [RecurringRotasController::class, 'bulkRestore'])->name('bulk-restore');
        Route::get('{uuid}', [RecurringRotasController::class, 'show'])->name('show');
        Route::put('{uuid}', [RecurringRotasController::class, 'update'])->name('update');
        Route::patch('{uuid}', [RecurringRotasController::class, 'update'])->name('update-patch');
        Route::delete('{uuid}', [RecurringRotasController::class, 'destroy'])->name('destroy');
        Route::patch('{uuid}/restore', [RecurringRotasController::class, 'restore'])->name('restore');
        Route::delete('{uuid}/force-delete', [RecurringRotasController::class, 'forceDelete'])->name('force-delete');
        Route::post('{uuid}/generate', [RecurringRotasController::class, 'generate'])->name('generate');
    });

    // Holiday Calendar
    Route::prefix('holiday-calendar')->name('holiday-calendar.')->group(function () {
        Route::get('/', [HolidayCalendarController::class, 'index'])->name('index');
        Route::post('/', [HolidayCalendarController::class, 'store'])->name('store');
        Route::get('{uuid}', [HolidayCalendarController::class, 'show'])->name('show');
        Route::put('{uuid}', [HolidayCalendarController::class, 'update'])->name('update');
        Route::patch('{uuid}', [HolidayCalendarController::class, 'update'])->name('update-patch');
        Route::delete('{uuid}', [HolidayCalendarController::class, 'destroy'])->name('destroy');
    });

    // Schedules
    Route::prefix('schedules')->name('schedules.')->group(function () {
        Route::get('/', [SchedulesController::class, 'index'])->name('index');
        Route::post('/', [SchedulesController::class, 'store'])->name('store');
        Route::get('trash', [SchedulesController::class, 'trash'])->name('trash');
        Route::post('bulk-delete', [SchedulesController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('bulk-restore', [SchedulesController::class, 'bulkRestore'])->name('bulk-restore');
        Route::get('{uuid}', [SchedulesController::class, 'show'])->name('show');
        Route::put('{uuid}', [SchedulesController::class, 'update'])->name('update');
        Route::patch('{uuid}', [SchedulesController::class, 'update'])->name('update-patch');
        Route::delete('{uuid}', [SchedulesController::class, 'destroy'])->name('destroy');
        Route::patch('{uuid}/restore', [SchedulesController::class, 'restore'])->name('restore');
        Route::delete('{uuid}/force-delete', [SchedulesController::class, 'forceDelete'])->name('force-delete');
        Route::post('{uuid}/approve', [SchedulesController::class, 'approve'])->name('approve');
        Route::post('{uuid}/cancel', [SchedulesController::class, 'cancel'])->name('cancel');
        Route::post('{uuid}/complete', [SchedulesController::class, 'complete'])->name('complete');
    });

    // Activities
    Route::prefix('activities')->name('activities.')->group(function () {
        Route::get('/', [ActivitiesController::class, 'index'])->name('index');
        Route::post('/', [ActivitiesController::class, 'store'])->name('store');
        Route::get('trash', [ActivitiesController::class, 'trash'])->name('trash');
        Route::post('bulk-delete', [ActivitiesController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('bulk-restore', [ActivitiesController::class, 'bulkRestore'])->name('bulk-restore');
        Route::get('{uuid}', [ActivitiesController::class, 'show'])->name('show');
        Route::put('{uuid}', [ActivitiesController::class, 'update'])->name('update');
        Route::patch('{uuid}', [ActivitiesController::class, 'update'])->name('update-patch');
        Route::delete('{uuid}', [ActivitiesController::class, 'destroy'])->name('destroy');
        Route::patch('{uuid}/restore', [ActivitiesController::class, 'restore'])->name('restore');
        Route::delete('{uuid}/force-delete', [ActivitiesController::class, 'forceDelete'])->name('force-delete');
        Route::post('{uuid}/approve', [ActivitiesController::class, 'approve'])->name('approve');
        Route::post('{uuid}/cancel', [ActivitiesController::class, 'cancel'])->name('cancel');
        Route::post('{uuid}/complete', [ActivitiesController::class, 'complete'])->name('complete');
        Route::post('{uuid}/start', [ActivitiesController::class, 'start'])->name('start');
        Route::post('{uuid}/stop', [ActivitiesController::class, 'stop'])->name('stop');
    });
});
