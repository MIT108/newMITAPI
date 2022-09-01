<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('school')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/create', [AuthController::class, 'create'])->name('school-creation');
        Route::post('/list', [SchoolController::class, 'list'])->name('list-creation');
    });
});
