<?php

use App\Http\Controllers\Api\CarePlanController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\EmployeeDocumentController;
use App\Http\Controllers\Api\FunderController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // Employees
    Route::prefix('employees')->name('employees.')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::post('/', [EmployeeController::class, 'store'])->name('store');
        Route::get('/trash', [EmployeeController::class, 'trash'])->name('trash');
        Route::post('/bulk-delete', [EmployeeController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk-restore', [EmployeeController::class, 'bulkRestore'])->name('bulk-restore');
        Route::get('/export', [EmployeeController::class, 'export'])->name('export');
        Route::get('{employee}', [EmployeeController::class, 'show'])->name('show');
        Route::put('{employee}', [EmployeeController::class, 'update'])->name('update');
        Route::patch('{employee}', [EmployeeController::class, 'update'])->name('update-patch');
        Route::delete('{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
        Route::patch('{employee}/restore', [EmployeeController::class, 'restore'])->name('restore');
        Route::delete('{employee}/force-delete', [EmployeeController::class, 'forceDelete'])->name('force-delete');
        Route::post('{employee}/assign-client/{client}', [EmployeeController::class, 'assignClient'])->name('assign-client');
        Route::delete('{employee}/remove-client/{client}', [EmployeeController::class, 'removeClient'])->name('remove-client');
        Route::get('{employee}/activities', [EmployeeController::class, 'activities'])->name('activities');
        Route::get('{employee}/schedules', [EmployeeController::class, 'schedules'])->name('schedules');
        Route::get('{employee}/salary', [EmployeeController::class, 'salary'])->name('salary');
    });

    // Employee Documents
    Route::prefix('employee-documents')->name('employee-documents.')->group(function () {
        Route::get('/', [EmployeeDocumentController::class, 'index'])->name('index');
        Route::post('/', [EmployeeDocumentController::class, 'store'])->name('store');
        Route::get('/trash', [EmployeeDocumentController::class, 'trash'])->name('trash');
        Route::post('/bulk-delete', [EmployeeDocumentController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk-restore', [EmployeeDocumentController::class, 'bulkRestore'])->name('bulk-restore');
        Route::get('/export', [EmployeeDocumentController::class, 'export'])->name('export');
        Route::get('{employee_document}', [EmployeeDocumentController::class, 'show'])->name('show');
        Route::put('{employee_document}', [EmployeeDocumentController::class, 'update'])->name('update');
        Route::patch('{employee_document}', [EmployeeDocumentController::class, 'update'])->name('update-patch');
        Route::delete('{employee_document}', [EmployeeDocumentController::class, 'destroy'])->name('destroy');
        Route::patch('{employee_document}/restore', [EmployeeDocumentController::class, 'restore'])->name('restore');
        Route::delete('{employee_document}/force-delete', [EmployeeDocumentController::class, 'forceDelete'])->name('force-delete');
    });

    // Clients
    Route::prefix('clients')->name('clients.')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('index');
        Route::post('/', [ClientController::class, 'store'])->name('store');
        Route::get('/trash', [ClientController::class, 'trash'])->name('trash');
        Route::post('/bulk-delete', [ClientController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk-restore', [ClientController::class, 'bulkRestore'])->name('bulk-restore');
        Route::get('/export', [ClientController::class, 'export'])->name('export');
        Route::get('{client}', [ClientController::class, 'show'])->name('show');
        Route::put('{client}', [ClientController::class, 'update'])->name('update');
        Route::patch('{client}', [ClientController::class, 'update'])->name('update-patch');
        Route::delete('{client}', [ClientController::class, 'destroy'])->name('destroy');
        Route::patch('{client}/restore', [ClientController::class, 'restore'])->name('restore');
        Route::delete('{client}/force-delete', [ClientController::class, 'forceDelete'])->name('force-delete');
        Route::post('{client}/assign-employee/{employee}', [ClientController::class, 'assignEmployee'])->name('assign-employee');
        Route::delete('{client}/remove-employee/{employee}', [ClientController::class, 'removeEmployee'])->name('remove-employee');
        Route::get('{client}/activities', [ClientController::class, 'activities'])->name('activities');
        Route::get('{client}/employees', [ClientController::class, 'employees'])->name('employees');
    });

    // Care Plans
    Route::prefix('care-plans')->name('care-plans.')->group(function () {
        Route::get('/', [CarePlanController::class, 'index'])->name('index');
        Route::post('/', [CarePlanController::class, 'store'])->name('store');
        Route::get('/trash', [CarePlanController::class, 'trash'])->name('trash');
        Route::post('/bulk-delete', [CarePlanController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk-restore', [CarePlanController::class, 'bulkRestore'])->name('bulk-restore');
        Route::get('/export', [CarePlanController::class, 'export'])->name('export');
        Route::get('{care_plan}', [CarePlanController::class, 'show'])->name('show');
        Route::put('{care_plan}', [CarePlanController::class, 'update'])->name('update');
        Route::patch('{care_plan}', [CarePlanController::class, 'update'])->name('update-patch');
        Route::delete('{care_plan}', [CarePlanController::class, 'destroy'])->name('destroy');
        Route::patch('{care_plan}/restore', [CarePlanController::class, 'restore'])->name('restore');
        Route::delete('{care_plan}/force-delete', [CarePlanController::class, 'forceDelete'])->name('force-delete');
    });

    // Funders
    Route::prefix('funders')->name('funders.')->group(function () {
        Route::get('/', [FunderController::class, 'index'])->name('index');
        Route::post('/', [FunderController::class, 'store'])->name('store');
        Route::get('/trash', [FunderController::class, 'trash'])->name('trash');
        Route::post('/bulk-delete', [FunderController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk-restore', [FunderController::class, 'bulkRestore'])->name('bulk-restore');
        Route::get('/export', [FunderController::class, 'export'])->name('export');
        Route::get('{funder}', [FunderController::class, 'show'])->name('show');
        Route::put('{funder}', [FunderController::class, 'update'])->name('update');
        Route::patch('{funder}', [FunderController::class, 'update'])->name('update-patch');
        Route::delete('{funder}', [FunderController::class, 'destroy'])->name('destroy');
        Route::patch('{funder}/restore', [FunderController::class, 'restore'])->name('restore');
        Route::delete('{funder}/force-delete', [FunderController::class, 'forceDelete'])->name('force-delete');
    });
});
