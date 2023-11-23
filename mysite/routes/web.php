<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login',[SiteController::class ,'login']) -> name('login');
Route::post('/login',[SiteController::class ,'loginPost']) -> name('login.post');
Route::get('/register',[SiteController::class ,'register']) -> name('register');
Route::post('/register',[SiteController::class ,'registerPost']) -> name('register.post');
Route::get('/welcome', function () {
    return view('welcome');
}) ->name('welcome');

