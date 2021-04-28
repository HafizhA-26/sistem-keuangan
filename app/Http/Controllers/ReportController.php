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
    public function transaksiExport(Request $request){
        $jabatan = session()->get('nama_jabatan');
        $jangkaW = "1 Bulan";
        $formatW = "%d-%m-%Y";
        $jenisD = "";
        $MK = "";
        $jenisP = null;
        if($request->JangkaWaktu){
            $jangkaW = $request->JangkaWaktu;
        }
        if($request->JenisDana){
            $jenisD = $request->JenisDana;
        }else{
            if($jabatan == "Staf BOS") $jenisD = "BOS";
            else if($jabatan == "Staf APBD") $jenisD = "APBD";
            else $jenisD = "";
        }
        if($request->masuk_keluar){
            $MK = $request->masuk_keluar;
        }
        if($request->JenisPengajuan){
            $jenisP = $request->JenisPengajuan;
        }
        if($jangkaW ==  "1 Bulan"){
            $formatW = "%d-%m-%Y";
            $limit = Carbon::now()->add(-1,'month');
        }else{
            $formatW = "%M %Y";
            $limit = Carbon::now()->add(-1,'year');
        }
        $report = $this->laporanT->reportT($jenisD, $MK, $jenisP, $formatW, $limit);
        $export = new ReportTExport($report);
        return Excel::download($export, Carbon::now()->toDateString().'_report_transaction.xlsx');
    }
    public function reportT(Request $request){

        $title = "Transaction Report";
        // Get request data
        $jabatan = session()->get('nama_jabatan');
        $jangkaW = "1 Bulan";
        $formatW = "%d-%m-%Y";
        $jenisD = "";
        $MK = "";
        $jenisP = null;
        if($request->JangkaWaktu){
            $jangkaW = $request->JangkaWaktu;
        }else{
            $jangkaW = "1 Bulan";
        }
        if($request->JenisDana){
            $jenisD = $request->JenisDana;
        }else{
            if($jabatan == "Staf BOS") $jenisD = "BOS";
            else if($jabatan == "Staf APBD") $jenisD = "APBD";
            else $jenisD = "";
        }
        if($request->masuk_keluar){
            $MK = $request->masuk_keluar;
        }else{
            $MK = "";
        }
        if($request->JenisPengajuan){
            $jenisP = $request->JenisPengajuan;
        }else{
            $jenisP = null;
        }
        // End get request data
        
        // Data For Chart
        $jumlahM = 0;
        $jumlahK = 0;
        $kategori = [];
        $masuk = [];
        $keluar = [];
        $dataM = [];
        $dataK = [];
        if($jangkaW ==  "1 Bulan"){
            $formatW = "%d-%m-%Y";
            $limit = Carbon::now()->add(-1,'month');
        }else{
            $formatW = "%M %Y";
            $limit = Carbon::now()->add(-1,'year');
        }
        $kategoriDB = $this->laporanT->chartCategories($jenisD,$MK, $jenisP, $formatW, $limit);
        foreach ($kategoriDB->all() as $value) {
            $kategori[] = $value->tgl;
            if($MK == "masuk" || !$MK) $dataM = $this->laporanT->getChartDataMasuk($jenisD,$value->tgl, $jenisP, $formatW, $limit);
            if($MK == "keluar" || !$MK) $dataK = $this->laporanT->getChartDataKeluar($jenisD,$value->tgl, $jenisP, $formatW, $limit);

            if($dataM){
                $masuk[] = (int)$dataM->total;
                $jumlahM += (int)$dataM->total;
            }else{
                $masuk[] = null;
            }
            if($dataK){
                $keluar[] = (int)$dataK->total;
                $jumlahK += (int)$dataK->total;
            }else{
                $keluar[] = null;
            }
        }
        
        // End Data For Chart
        $search = "";
        if($request->search){
            $search = $request->search;
        }
        $report = $this->laporanT->reportT($jenisD, $MK, $jenisP, $formatW, $limit);
        $in = 0;
        $out = 0;
        if($MK == "masuk" || !$MK) $in = $this->laporanT->countIn($jenisD, $jenisP, $formatW, $limit);
        if($MK == "keluar" || !$MK) $out = $this->laporanT->countOut($jenisD, $jenisP, $formatW, $limit);

        return view('contents.report-transaksi',[
            'title' => $title,
            'masuk' => $in,
            'keluar' => $out,
            'report' => $report,
            'search' => $search, 
            'categories' => $kategori, 
            'dataKeluar' => $keluar, 
            'dataMasuk' => $masuk,
            'jumlahM' => $jumlahM,
            'jumlahK' => $jumlahK,
            'waktu' => $jangkaW,
            'jenisDana' => $jenisD,
            'masukKeluar' => $MK,
            'jenisPengajuan' => $jenisP]);
    }
    
    
}
