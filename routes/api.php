<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    require __DIR__.'/api/core.php';
    require __DIR__.'/api/hr.php';
    require __DIR__.'/api/scheduling.php';
    require __DIR__.'/api/finance.php';
    require __DIR__.'/api/utility.php';
});
