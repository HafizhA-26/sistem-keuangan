<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;

class ReportController extends Controller
{
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
                $laporan = DB::table('submissions')
                            ->join('transaksi','submissions.id_transaksi','=','transaksi.id_transaksi')
                            ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
                            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
                            ->select('submissions.*','detail_submissions.deskripsi','detail_submissions.file_lampiran','detail_accounts.nama')
                            ->where('transaksi.jenis','!=','Pending')
                            ->get();
                $report = $laporan;
                break;
            case 'Staf BOS':
                $laporan = DB::table('submissions')
                            ->join('transaksi','submissions.id_transaksi','=','transaksi.id_transaksi')
                            ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
                            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
                            ->select('submissions.*','detail_submissions.deskripsi','detail_submissions.file_lampiran','detail_accounts.nama')
                            ->where([
                                'transaksi.jenis','!=','Pending',
                                'transaksi.id_dana','=','BOS',
                            ])
                            ->get();
                $report = $laporan;
                break;
               
            case 'Staf APBD':
                $laporan = DB::table('submissions')
                            ->join('transaksi','submissions.id_transaksi','=','transaksi.id_transaksi')
                            ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
                            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
                            ->select('submissions.*','detail_submissions.deskripsi','detail_submissions.file_lampiran','detail_accounts.nama')
                            ->where([
                                'transaksi.jenis','!=','Pending',
                                'transaksi.id_dana','=','APBD',
                            ])
                            ->get();
                $report = $laporan;
                break;
            case 'Kaprog':
                $laporan = DB::table('submissions')
                            ->join('transaksi','submissions.id_transaksi','=','transaksi.id_transaksi')
                            ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
                            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
                            ->join('jurusan','detail_accounts.id_jurusan','=','jurusan.id_jurusan')
                            ->select('submissions.*','detail_submissions.deskripsi','detail_submissions.file_lampiran','detail_accounts.nama','jurusan.nama_jurusan')
                            ->where([
                                'transaksi.jenis','!=','Pending',
                                'submissions.id_pengaju','=',Auth::user()->nip,
                            ])
                            ->get();
                $report = $laporan;
                break;
                
            default:
                abort(404);
                break;
        }

        return view('contents.report-submission',['title' => $title,'report' => $report]);
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
