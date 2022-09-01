<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('user-login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/create', [AuthController::class, 'create'])->name('user-creation');

        Route::get('/logout', [AuthController::class, 'logout'])->name('user-logout');
    });
});
