<?php

use App\Jobs\SendEmailJob;
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

    // app('App\Http\Controllers\EmailController')->sendMail("School account created", "success", "miendjemthierry01@gmail.com", "Miendjem Thierry Idris");
    SendEmailJob::dispatch("School account created", "success", "miendjemthierry01@gmail.com", "Miendjem Thierry Idris");
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
