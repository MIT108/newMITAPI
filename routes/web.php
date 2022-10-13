<?php

use App\Events\TestEvent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
     event(new TestEvent());
    return view('welcome');
});

Route::get('/basic', function () {
    return view('email.basic');
});

Route::get('/bill', function () {
    return view('email.billout');
});

Route::get('/alert', function () {
    return view('email.alert');
});
