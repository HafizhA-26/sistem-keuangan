<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use Excel;
use App\Models\Submission;
use App\Charts\AllTransactionChart;
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

        // Data For Chart
        $kategori = [];
        $kategoriDB = DB::table('transaksi')
                        ->select(DB::raw('DATE_FORMAT(updated_at, "%d-%m-%Y") as tgl'))
                        ->where('jenis','=','keluar')
                        ->orWhere('jenis','=','masuk')
                        ->orderBy('updated_at','asc')
                        ->distinct()
                        ->get();
        $masuk = [];
        $keluar = [];
        // $chartData = $this->laporanT->dataChart(session()->get('nama_jabatan'));
        // foreach($chartData->all() as $data){
        //     if($data->jenis == "masuk"){
        //         $masuk[] = $data->total;
        //     }else{
        //         $masuk[] = null;
        //     }
        //     if($data->jenis == "keluar"){
        //         $keluar[] = $data->total;
        //     }else{
        //         $keluar[] = null;
        //     }
            
        // }
        
        foreach ($kategoriDB->all() as $value) {
            $kategori[] = $value->tgl;
            $dataM = DB::table('transaksi')
                ->select(DB::raw('SUM(jumlah) as total'), DB::raw('DATE_FORMAT(updated_at, "%d-%m-%Y") as tgl'))
                ->where([
                    ['jenis','=','masuk'],
                    [DB::raw('DATE_FORMAT(updated_at, "%d-%m-%Y")'),'=',$value->tgl],
                ])
                ->groupBy('tgl')
                ->first();
            $dataK = DB::table('transaksi')
                ->select(DB::raw('SUM(jumlah) as total'), DB::raw('DATE_FORMAT(updated_at, "%d-%m-%Y") as tgl'))
                ->where([
                    ['jenis','=','keluar'],
                    [DB::raw('DATE_FORMAT(updated_at, "%d-%m-%Y")'),'=',$value->tgl],
                ])
                ->groupBy('tgl')
                ->first();
            if($dataM){
                $masuk[] = (int)$dataM->total;
            }else{
                $masuk[] = null;
            }
            if($dataK){
                $keluar[] = (int)$dataK->total;
            }else{
                $keluar[] = null;
            }
        }
        
        // End Data For Chart
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
        
        return view('contents.report-transaksi',['title' => $title,'masuk' => $in,'keluar' => $out,'report' => $report,'search' => $search, 'categories' => $kategori, 'dataKeluar' => $keluar, 'dataMasuk' => $masuk]);
    }
    
    
}
