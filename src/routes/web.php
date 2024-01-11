<?php

use Illuminate\Support\Facades\Route;
use Shumonpal\ProjectSecurity\Controllers\ProjectSecurityController;

Route::prefix('project-security')->middleware('web')->group(function(){
    Route::get('/licences', [ProjectSecurityController::class, 'create']);
    Route::post('/licences', [ProjectSecurityController::class, 'storeLicences'])->name('project-security.licences');
    // Route::get('/verify', [ProjectSecurityController::class, 'verify']);
});
