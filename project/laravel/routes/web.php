<?php
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
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





Route::post('/id/{id}',[SiteController::class ,'registerPost']) -> name('register.post');
Route::get('/giveurl', function () {
    $num = DB::table('teacher')->count();
    $urls = array();
    for ($i = 0; $i < $num ; $i++) {
        
        array_push($urls,URL::temporarySignedRoute('table.process', now()->addSeconds(1000), ['id' => $i+1]));
    }
 // $url = URL::temporarySignedRoute('table.process', now()->addSeconds(1000), ['id' => 1]);
 // $url2 = URL::temporarySignedRoute('table.process', now()->addSeconds(1000), ['id' => 2]);
 // $url3 = URL::temporarySignedRoute('table.process', now()->addSeconds(1000), ['id' => 3]);
 // return view('giveurl')->with('url', $url)->with('url2', $url2)->with('url3', $url3);
    return view('giveurl')->with('url', $urls)->with('num', $num);
});
Route::get('/main',  [SiteController::class, 'main'])->name('main');
Route::get('/id/{id}',  [SiteController::class, 'table_process'])->name('table.process');
Route::get('/test', function () {
    return view('test');


});




