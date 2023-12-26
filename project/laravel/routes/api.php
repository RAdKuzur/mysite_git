<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Resources\studentsResource;
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


//Route::get('/data/{token}', [ApiController::class, 'getData'])->name('getData');
//Route::post('/data', [ApiController::class, 'postData'])->name('posrData');
Route::get('/data', [ApiController::class, 'getData'])->name('getData');
Route::post('/data/{id}/{token}', [ApiController::class, 'postData'])->name('postData');



Route::get('/index', [ApiController::class, 'index'])->name('index');
Route::get('/show/{id}', [ApiController::class, 'show'])->name('show');
Route::post('/store', [ApiController::class, 'store'])->name('store');
Route::put('/update', [ApiController::class, 'update'])->name('update');
Route::delete('/destroy', [ApiController::class, 'destroy'])->name('destroy');