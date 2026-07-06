<?php

use App\Http\Controllers\Finance\FormController;
use App\Http\Controllers\Finance\InvoiceController;
use App\Http\Controllers\Finance\InvoicePaymentController;
use App\Http\Controllers\Finance\LeaveController;
use App\Http\Controllers\Finance\SalaryController;
use App\Http\Controllers\Finance\TimesheetController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('timesheets', TimesheetController::class)->parameters(['timesheets' => 'uuid']);
    Route::prefix('timesheets')->name('timesheets.')->group(function () {
        Route::get('/trash/list', [TimesheetController::class, 'trash'])->name('trash');
        Route::patch('{uuid}/restore', [TimesheetController::class, 'restore'])->name('restore');
        Route::delete('{uuid}/force', [TimesheetController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk/delete', [TimesheetController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk/restore', [TimesheetController::class, 'bulkRestore'])->name('bulk-restore');
    });

    Route::apiResource('leaves', LeaveController::class)->parameters(['leaves' => 'uuid']);
    Route::prefix('leaves')->name('leaves.')->group(function () {
        Route::patch('{uuid}/approve', [LeaveController::class, 'approve'])->name('approve');
        Route::patch('{uuid}/reject', [LeaveController::class, 'reject'])->name('reject');
    });

    Route::apiResource('forms', FormController::class)->parameters(['forms' => 'uuid']);
    Route::prefix('forms')->name('forms.')->group(function () {
        Route::patch('{uuid}/publish', [FormController::class, 'publish'])->name('publish');
        Route::patch('{uuid}/archive', [FormController::class, 'archive'])->name('archive');
        Route::post('{uuid}/assign', [FormController::class, 'assign'])->name('assign');
        Route::get('/trash/list', [FormController::class, 'trash'])->name('trash');
        Route::patch('{uuid}/restore', [FormController::class, 'restore'])->name('restore');
        Route::delete('{uuid}/force', [FormController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk/delete', [FormController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk/restore', [FormController::class, 'bulkRestore'])->name('bulk-restore');
    });

    Route::apiResource('invoices', InvoiceController::class)->parameters(['invoices' => 'uuid']);
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::post('{uuid}/pay', [InvoiceController::class, 'pay'])->name('pay');
        Route::patch('{uuid}/cancel', [InvoiceController::class, 'cancel'])->name('cancel');
        Route::get('/export/list', [InvoiceController::class, 'export'])->name('export');
        Route::get('/trash/list', [InvoiceController::class, 'trash'])->name('trash');
        Route::patch('{uuid}/restore', [InvoiceController::class, 'restore'])->name('restore');
        Route::delete('{uuid}/force', [InvoiceController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk/delete', [InvoiceController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk/restore', [InvoiceController::class, 'bulkRestore'])->name('bulk-restore');
    });

    Route::apiResource('invoice-payments', InvoicePaymentController::class)->parameters(['invoice_payments' => 'uuid']);
    Route::prefix('invoice-payments')->name('invoice-payments.')->group(function () {
        Route::get('/trash/list', [InvoicePaymentController::class, 'trash'])->name('trash');
        Route::patch('{uuid}/restore', [InvoicePaymentController::class, 'restore'])->name('restore');
        Route::delete('{uuid}/force', [InvoicePaymentController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk/delete', [InvoicePaymentController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk/restore', [InvoicePaymentController::class, 'bulkRestore'])->name('bulk-restore');
    });

    Route::apiResource('salary', SalaryController::class)->parameters(['salary' => 'uuid']);
    Route::prefix('salary')->name('salary.')->group(function () {
        Route::post('/generate', [SalaryController::class, 'generate'])->name('generate');
        Route::get('/export/list', [SalaryController::class, 'export'])->name('export');
        Route::get('/trash/list', [SalaryController::class, 'trash'])->name('trash');
        Route::patch('{uuid}/restore', [SalaryController::class, 'restore'])->name('restore');
        Route::delete('{uuid}/force', [SalaryController::class, 'forceDelete'])->name('force-delete');
        Route::post('/bulk/delete', [SalaryController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk/restore', [SalaryController::class, 'bulkRestore'])->name('bulk-restore');
    });
});
