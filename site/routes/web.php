<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/start', function () {
    return view('start');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/main', function () {
    return view('main');
});
Route::post('/main', function () {
   return Request::all();
}) -> name('sign-in-form');