<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Response;
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
Route::get('/',[DashboardController::class, 'index'])->name('login');
Route::get('/login',[DashboardController::class, 'index']);
Route::post('/checking',[LoginController::class, 'checklogin']);



/* Masukan route 'yang butuh login dulu kalau bisa masuk' */
Route::group(['middleware' => 'auth'],function(){
    Route::get('/login/successlogin',[LoginController::class, 'successlogin']);
    Route::get('/dashboard',[DashboardController::class, 'dashboardVerification'])->name('dashboard');
    Route::get('/submission',[SubmissionController::class, 'index'])->name('submission');
    Route::post('/submission',[SubmissionController::class, 'store']);

    /* Route untuk izinkan dan tidak diizinkan */
    Route::post('/submission/tidakdiizinkankepsek',[SubmissionController::class, 'storetidakdiizinkankepsek']);
    Route::post('/submission/diizinkankepsek',[SubmissionController::class, 'storediizinkankepsek']);
    Route::post('/submission/tidakdiizinkankakeuangan',[SubmissionController::class, 'storetidakizinkankakeuangan']);
    Route::post('/submission/diizinkankakeuangan',[SubmissionController::class, 'storeizinkankakeuangan']);
    Route::post('/submission/tidakdiizinkanbos',[SubmissionController::class, 'storetidakizinkanbos']);
    Route::post('/submission/diizinkanbos',[SubmissionController::class, 'storeizinkanbos']);
    Route::post('/submission/tidakdiizinkanapbd',[SubmissionController::class, 'storetidakizinkanapbd']);
    Route::post('/submission/diizinkanapbd',[SubmissionController::class, 'storeizinkanapbd']);

    Route::get('/addsubmission', [SubmissionController::class, 'addSubmission'])->name('add_submission');
    Route::post('/createsubmissions', [SubmissionController::class, 'createSubmission']);
    Route::post('/submission/add', [SubmissionController::class, 'store']);
    Route::get('/report',[ReportController::class, ''])->name('report');
    Route::post('/submission/tidakdiizinkan',[SubmissionController::class, 'storetidakdiizinkan']);
    Route::post('/submission/diizinkan',[SubmissionController::class, 'storediizinkan']);
    Route::get('/report',[ReportController::class, 'index'])->name('report');
    Route::get('/report-submission',[ReportController::class, 'reportS'])->name('report_submission');
    Route::get('/report-transaction',[ReportController::class, 'reportT'])->name('report_transaction');
    Route::get('/manage-account',[AccountController::class, 'index'])->name('manage_account');
    Route::get('/add-account',[AccountController::class, 'create'])->name('add_account');
    Route::post('/store-data-account',[AccountController::class, 'store']);
    Route::get('/edit-profil/{nip}',[AccountController::class, 'edit'])->name("edit_profil");
    Route::get('/edit-account-data/{nip}',[AccountController::class, 'edit'])->name("edit_data_account");
    Route::post('/update/{nip}',[AccountController::class, 'update']);
    Route::get('/del-account/{nip}',[AccountController::class, 'destroy']);
    Route::get('/deactive-account/{nip}',[AccountController::class, 'deactive']);
    Route::get('/logout',[LoginController::class, 'logout']);

    Route::get('download/{filename}', function($filename)
    {

        $file_path = storage_path() .'/uploaded_file/'. $filename;
        if (file_exists($file_path))
        {
            $ex = substr($filename,-3);
            if($ex == "pdf"){
                return response()->file($file_path);
            }else{
                return Response::download($file_path, $filename, [
                    'Content-Length: '. filesize($file_path)
                ]);
            }
            
        }
        else
        {
            abort(404);
        }
    })
    ->where('filename', '[A-Za-z0-9\-\_\.]+');
    // Udah bener, silahkan masukkin route disini
});


