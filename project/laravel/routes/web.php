<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
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
/*Route::get('/', function () {
  // Сохраняем время перехода пользователя по ссылке
    session(['link_clicked_at' => now()]);
    return view('welcome');
  // Возвращает ваши представления или перенаправляет пользователя на другую страницу
})->middleware('link.expiration');
*/
Route::post('/{id}',[SiteController::class ,'registerPost']) -> name('register.post');
Route::get('/temp',  [SiteController::class, 'table_process']);
Route::get('/{id}',  [SiteController::class, 'table_process'])->name('table.process');