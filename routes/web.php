<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;

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

Route::get('/',[DashboardController::class, 'index']);
Route::get('/login',[LoginController::class, 'index'])->name('login');
Route::post('/checking',[LoginController::class, 'checklogin']);

/* Masukan route 'yang butuh login dulu kalau bisa masuk' */
Route::middleware('auth:accounts')->group(function () { 
    Route::get('/login/successlogin',[LoginController::class, 'successlogin']);
});
Route::group(['middleware' => 'auth:'],function(){
    //Route yang butuh autentikasi terlebih dahulu untuk masuk
    Route::get('/kepsek',function(){
        return view('index-kepsek');
    });
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
