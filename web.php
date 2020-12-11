<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BosSubmissionController;
use App\Http\Controllers\ApbdSubmissionController;
use App\Http\Controllers\KaprogSubmissionController;
use App\Http\Controllers\ReportController;
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
    Route::post('/submission',[SubmissionController::class, 'store']);
    Route::post('/submission/tidakdiizinkan',[SubmissionController::class, 'storetidakdiizinkan']);
    Route::post('/submission/diizinkan',[SubmissionController::class, 'storediizinkan']);
    Route::get('/report',[ReportController::class, '']);
    Route::get('/manage-account',[AccountController::class, 'index']);
    Route::post('/store-data-account',[AccountController::class, 'store']);
    Route::get('/edit-profil/{nip}',[AccountController::class, 'edit']);
    Route::post('/update/{nip}',[AccountController::class, 'update']);
    Route::get('/del-account/{nip}',[AccountController::class, 'destroy']);
    Route::get('/deactive-account/{nip}',[AccountController::class, 'deactive']);
    Route::get('/logout',[LoginController::class, 'logout']);
    // Udah bener, silahkan masukkin route disini
    Route::get('/bos-dashboard',[BosSubmissionController::class, 'index']);
    Route::get('/bos-submission',[BosSubmissionController::class, 'create']);
    Route::post('/bos-submission',[BosSubmissionController::class, 'store']);

    Route::get('/apbd-dashboard',[ApbdSubmissionController::class, 'index']);
    Route::get('/apbd-submission',[ApbdSubmissionController::class, 'create']);
    Route::post('/apbd-submission',[ApbdSubmissionController::class, 'store']);

    Route::get('/kaprog-dashboard',[KaprogSubmissionController::class, 'index']);
    Route::get('/kaprog-submission',[KaprogSubmissionController::class, 'create']);
    Route::post('/kaprog-submission',[KaprogSubmissionController::class, 'store']);
});


