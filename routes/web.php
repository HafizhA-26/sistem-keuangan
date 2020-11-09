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
Route::get('/login/successlogin',[LoginController::class, 'successlogin']);
Route::get('/dashboard',[DashboardController::class, 'dashboardVerification']);


/* Masukan route 'yang butuh login dulu kalau bisa masuk' */
Route::group(['middleware' => 'auth'],function(){
    // Jangan dipake dulu system protectionnya masih capruk
});

