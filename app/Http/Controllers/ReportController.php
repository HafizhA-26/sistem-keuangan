<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
class ReportController extends Controller
{
    public function GetReportT($jabatan){
        
    }
    public function index(){
        $title = "Report - ";
        return view('contents.report',['title' => $title]);
    }
    public function reportS(){
        $title = "Submission Report - ";
        return view('contents.report-submission',['title' => $title]);
    }
    public function reportT(){
        $title = "Transaction Report - ";
        $in = DB::table('transaksi')
                ->where('jenis','=','Keluar')
                ->count();
        $out = DB::table('transaksi')
                ->where('jenis','=','Keluar')
                ->count();
        $jabatan = session()->get('nama_jabatan');
        switch($jabatan){
            case 'Kepala Sekolah':
            case 'Admin':
                $laporan = DB::table('transaksi')
                            ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
                            ->select('transaksi.*','submissions.id_pengaju')
                            ->where('transaksi.jenis','!=','Pending')
                            ->get();
                $report = $laporan;
                break;
            case 'Kepala Keuangan':
                $laporan = DB::table('transaksi')
                            ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
                            ->select('transaksi.*','submissions.id_pengaju')
                            ->where('transaksi.jenis','!=','Pending')
                            ->get();
                $report = $laporan;
                break;
            case 'Staf BOS':
                $laporan = DB::table('transaksi')
                            ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
                            ->select('transaksi.*','submissions.id_pengaju')
                            ->where([
                                'transaksi.jenis','!=','Pending',
                                'id_dana','=','BOS',
                            ])
                            ->get();
                $report = $laporan;
                break;
            case 'Staf APBD':
                $laporan = DB::table('transaksi')
                            ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
                            ->select('transaksi.*','submissions.id_pengaju')
                            ->where([
                                'transaksi.jenis','!=','Pending',
                                'id_dana','=','APBD',
                            ])
                            ->get();
                $report = $laporan;
                break;
            default:
                abort(404);
                break;
        }
        
        return view('contents.report-transaksi',['title' => $title,'masuk' => $in,'keluar' => $out,'report' => $report]);
    }
    
    
}
