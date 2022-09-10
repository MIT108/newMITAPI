<?php

use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    //list all roles
    Route::get('/listRoles', [RoleController::class, 'getRole'])->name('list-role');
    Route::get('/test', [RoleController::class, 'test'])->name('test');
});


/*
|--------------------------------------------------------------------------
| API Routes for authentication
|--------------------------------------------------------------------------
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('user-login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/create', [AuthController::class, 'create'])->name('user-creation');

        Route::get('/logout', [AuthController::class, 'logout'])->name('user-logout');
    });
});




/*
|--------------------------------------------------------------------------
| API Routes for school
|--------------------------------------------------------------------------
|
*/

Route::prefix('school')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/create', [AuthController::class, 'create'])->name('school-creation');
        Route::post('/list', [SchoolController::class, 'list'])->name('list-creation');
    });
});




/*
|--------------------------------------------------------------------------
| API Routes for user
|--------------------------------------------------------------------------
|
*/

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
