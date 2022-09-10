<?php

use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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




require 'modules\authentication.php';
require 'modules\school.php';
require 'modules\user.php';
