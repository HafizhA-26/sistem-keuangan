<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use Excel;
use App\Models\Submission;
use App\Models\Transaksi;
use App\Exports\ReportTExport;
use App\Exports\ReportSExport;
use Carbon\Carbon;

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
        $title = "Report";
        if(session()->get('nama_jabatan') != "Kaprog"){
            return view('contents.report',['title' => $title]);
        }else{
            return redirect("/report-submission");
        }
        
    }
    public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
    public function reportS(Request $request){
        $title = "Report Submission";
        $jabatan = session()->get('nama_jabatan');
        $search = "";
        if($request->search){
            $search = $request->search;
        }
        switch($jabatan){
            case 'Kepala Sekolah':
            case 'Admin':
            case 'Kepala Keuangan':
                $report = $this->laporanS->reportA();
                break;
            case 'Staf BOS':
                $title = "Report Submission BOS";
                $report = $this->laporanS->reportBOS();
                break;
               
            case 'Staf APBD':
                $title = "Report Submission APBD";
                $report = $this->laporanS->reportAPBD();
                break;
            case 'Kaprog':
                $title = "Your Report Submission";
                $report = $this->laporanS->reportKaprog();
                break;
                
            default:
                abort(404);
                break;
        }

        return view('contents.report-submission',['title' => $title,'report' => $report,'search' => $search]);
    }
    public function submissionExport()
    {
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
            $export = new ReportSExport($report);
            return Excel::download($export, Carbon::now()->toDateString().'_report_submission.xlsx');
    }
    public function transaksiExport(){
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
        $export = new ReportTExport($report);
        return Excel::download($export, Carbon::now()->toDateString().'_report_transaction.xlsx');
    }
    public function reportT(Request $request){
        $title = "Transaction Report";
        $jabatan = session()->get('nama_jabatan');
        $in = $this->laporanT->countIn($jabatan);
        $out = $this->laporanT->countOut($jabatan);
        $search = "";
        if($request->search){
            $search = $request->search;
        }
        switch($jabatan){
            case 'Kepala Sekolah':
            case 'Admin':
            case 'Kepala Keuangan':
                $report = $this->laporanT->reportA();
                break;
            case 'Staf BOS':
                $title = "Transaction Report BOS";
                $report = $this->laporanT->reportBOS();
                break;
            case 'Staf APBD':
                $title = "Transaction Report APBD";
                $report = $this->laporanT->reportAPBD();
                break;
            default:
                abort(404);
                break;
        }
        
        return view('contents.report-transaksi',['title' => $title,'masuk' => $in,'keluar' => $out,'report' => $report,'search' => $search]);
    }
    
    
}
