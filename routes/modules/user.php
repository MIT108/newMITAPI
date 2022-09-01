<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user/{user_id}', [UserController::class, 'user'])->name('user-information');
        Route::get('/user', [UserController::class, 'authUser'])->name('auth-user-information');
        Route::get('/change-user-status/{user_id}/{status}', [UserController::class, 'changeUserStatus'])->name('change-user-status');
        Route::get('/list-user/{role_id}', [UserController::class, 'listUser'])->name('list-user');
        Route::get('/list-active-user/{role_id}', [UserController::class, 'listActiveUser'])->name('list-active-user');
        Route::get('/list-inactive-user/{role_id}', [UserController::class, 'listInActiveUser'])->name('list-inactive-user');

    });
});
