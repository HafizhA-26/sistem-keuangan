<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use App\Models\Submission;
use App\Models\Transaksi;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->laporanS = new Submission();
        $this->laporanT = new Transaksi();
    }
    public function GetReportT($jabatan){
        
    }
    public function index(){
        $title = "Report - ";
        if(session()->get('nama_jabatan') != "Kaprog"){
            return view('contents.report',['title' => $title]);
        }else{
            return redirect("/report-submission");
        }
        
    }
    public function reportS(){
        $title = "Submission Report - ";
        $jabatan = session()->get('nama_jabatan');
        switch($jabatan){
            case 'Kepala Sekolah':
            case 'Admin':
            case 'Kepala Keuangan':
                $report = $this->laporanS->reportA();
                break;
            case 'Staf BOS':
                $report = $this->laporanS->reportBOS();
                break;
               
            case 'Staf APBD':
                $report = $this->laporanS->reportAPBD();
                break;
            case 'Kaprog':
                $report = $this->laporanS->reportKaprog();
                break;
                
            default:
                abort(404);
                break;
        }

        return view('contents.report-submission',['title' => $title,'report' => $report]);
    }
    public function reportT(){
        $title = "Transaction Report - ";
        $in = $this->laporanT->countIn();
        $out = $this->laporanT->countOut();
        $jabatan = session()->get('nama_jabatan');
        switch($jabatan){
            case 'Kepala Sekolah':
            case 'Admin':
            case 'Kepala Keuangan':
                $report = $this->laporanT->reportA();
                break;
            case 'Staf BOS':
                $report = $this->laporanT->reportBOS();
                break;
            case 'Staf APBD':
                $report = $this->laporanT->reportAPBD();
                break;
            default:
                abort(404);
                break;
        }
        
        return view('contents.report-transaksi',['title' => $title,'masuk' => $in,'keluar' => $out,'report' => $report]);
    }
    
    
}
