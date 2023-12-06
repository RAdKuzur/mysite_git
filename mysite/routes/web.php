<?php
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\apicontroller;
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
//Route::get('/welcome', function () {
 //   return view('welcome');
//}) ->name('welcome');
Route::get('/welcome',[SiteController::class ,'welcome']) -> name('welcome');
Route::get('/data', [apicontroller::class, 'getData']);