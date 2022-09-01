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




require __DIR__.'\modules\authentication.php';
require __DIR__.'\modules\school.php';
require __DIR__.'\modules\user.php';
