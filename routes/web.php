<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SubmissionController;
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


/* Masukan route 'yang butuh login dulu kalau bisa masuk' */
Route::group(['middleware' => 'auth'],function(){
    Route::get('/dashboard',[DashboardController::class, 'dashboardVerification']);
    Route::get('/submission',[SubmissionController::class, 'index']);
    Route::get('/report',[ReportController::class, '']);
    Route::get('/add-account',[AccountController::class, '']);
    Route::get('/edit-profil',[AccountController::class, '']);
    Route::get('/logout',[LoginController::class, 'logout']);
    // Udah bener, silahkan masukkin route disini
});

