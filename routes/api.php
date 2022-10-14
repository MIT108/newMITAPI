<?php

use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
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
    Route::get('/test', [RoleController::class, 'test'])->name('test');

    //list all roles
    Route::get('/listRoles', [RoleController::class, 'getRole'])->name('list-role');

    //list all countries
    Route::get('/list-countries', [RoleController::class, 'getCountries'])->name('list-countries');
});


/*
|--------------------------------------------------------------------------
| API Routes for authentication
|--------------------------------------------------------------------------
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('user-login');
    Route::get('/send-otp/{id}', [AuthController::class, 'sendOTPCode'])->name('send-otp-code');
    Route::post('/send-otp/{id}', [AuthController::class, 'validateOTPCode'])->name('validate-otp-code');
    Route::post('/change-startup-password/{id}', [AuthController::class, 'changeUserStartupPassword'])->name('change-user-startup-password');

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

        //location Routes
        Route::prefix('location')->group(function(){
            Route::post('create', [SchoolController::class, 'createSchoolLocation'])->name('create-school-location');
            Route::get('active-user-list-locations', [SchoolController::class, 'activeUserListLocations'])->name('active-user-list-locations');
            Route::get('list-school-locations/{user_id}', [SchoolController::class, 'listSchoolLocations'])->name('list-school-location');
            Route::get('location-information/{id}', [SchoolController::class, 'locationInformation'])->name('location-information');
            Route::get('change-status/{id}/{status}', [SchoolController::class, 'changeSchoolLocationStatus'])->name('change-status-school-location');
            Route::get('delete/{id}', [SchoolController::class, 'deleteSchoolLocation'])->name('delete-school-location');
        });

        //teachers Routes
        Route::prefix('teacher')->group(function(){
            Route::post('upload-teacher-excel', [TeacherController::class, 'uploadTeacherExcel'])->name('upload-teacher-excel');
        });

        Route::prefix('classe')->group(function(){
            Route::post('add-classe', [ClasseController::class, 'add'])->name('add-classe');
            Route::get('delete/{id}', [ClasseController::class, 'delete'])->name('delete-classe');
            Route::get('list/{school_id}', [ClasseController::class, 'list'])->name('lis-classes');
        });
        Route::prefix('subject')->group(function(){
            Route::post('add', [SubjectController::class, 'add'])->name('add-subject');
            Route::get('delete/{id}', [SubjectController::class, 'delete'])->name('delete-subject');
            Route::get('list/{classe_id}', [SubjectController::class, 'list'])->name('lis-subject');
        });

    });

    //location
    Route::prefix('location')->group(function(){
        Route::get('list-locations', [SchoolController::class, 'listLocations'])->name('list-location');
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

        //school
        Route::get('/list-account', [UserController::class, 'listAccount'])->name('list-account');

    });
});
