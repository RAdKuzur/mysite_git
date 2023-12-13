<?php
use App\Http\Controllers\apicontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/data/{token}', [apicontroller::class, 'getData']);
Route::get('/schools', [apicontroller::class, 'schools_get']);
Route::get('/register/{name}', [apicontroller::class, 'register_teacher']);
Route::get('/show_students/{id}', [apicontroller::class, 'show_students']);
Route::get('/register_students', [apicontroller::class, 'register_students']);
Route::post('/data/{id_users}', [apicontroller::class, 'postData']);
Route::get('/students/{id_user}', [apicontroller::class, 'students']);