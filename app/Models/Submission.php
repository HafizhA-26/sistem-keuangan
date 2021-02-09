<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Submission extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'submissions';
    protected  $primaryKey = 'id_pengajuan';
    public $incrementing = false;
    protected $fillable = [
        'id_pengajuan',
        'judul',
        'tgl_pengajuan',
        'status',
        'created_at',
        'updated_at',
    ];
    //untuk submission
    public function allDataForKepsek(){
        return DB::table('submissions')
            ->join('detail_submissions', 'detail_submissions.id_pengajuan', '=', 'submissions.id_pengajuan')
            ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
            ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'submissions.id_transaksi')
            ->select('submissions.*','detail_submissions.*', 'detail_accounts.*', 'accounts.nip', 'transaksi.jumlah', 'transaksi.id_dana', 'transaksi.jenis', 'submissions.created_at')
            ->where('submissions.status', 'LIKE', 'ACC-2%')
            ->orderBy('submissions.updated_at', 'desc')
            ->get();
    }
    public function allDataForKeuangan(){
        return DB::table('submissions')
            ->join('detail_submissions', 'detail_submissions.id_pengajuan', '=', 'submissions.id_pengajuan')
            ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
            ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'submissions.id_transaksi')
            ->select('submissions.*','detail_submissions.*', 'detail_accounts.*', 'accounts.nip', 'transaksi.jumlah', 'transaksi.id_dana', 'transaksi.jenis', 'submissions.created_at')
            ->where('submissions.status', 'LIKE', 'ACC-1%')
            ->orderBy('submissions.updated_at', 'desc')
            ->get();
    }
    public function allDataForAPBD(){
        return DB::table('submissions')
            ->join('detail_submissions', 'detail_submissions.id_pengajuan', '=', 'submissions.id_pengajuan')
            ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
            ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'submissions.id_transaksi')
            ->select('submissions.*','detail_submissions.*', 'detail_accounts.*', 'accounts.nip', 'transaksi.jumlah', 'transaksi.id_dana', 'transaksi.jenis', 'submissions.created_at')
            ->where('submissions.status', 'LIKE', 'ACC-A%')
            ->orderBy('submissions.updated_at', 'desc')
            ->get();
    }
    public function allDataForBOS(){
        return DB::table('submissions')
            ->join('detail_submissions', 'detail_submissions.id_pengajuan', '=', 'submissions.id_pengajuan')
            ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
            ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'submissions.id_transaksi')
            ->select('submissions.*','detail_submissions.*', 'detail_accounts.*', 'accounts.nip', 'transaksi.jumlah', 'transaksi.id_dana', 'transaksi.jenis', 'submissions.created_at')
            ->where('submissions.status', 'LIKE', 'ACC-B%')
            ->orderBy('submissions.updated_at', 'desc')
            ->get();
    }

    //untuk dashboard
    //kepsek
    public function submissionKepsek(){
        return DB::table('submissions')
            ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
            ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
            ->select('submissions.judul', 'detail_accounts.nama')
            ->where('submissions.status', 'LIKE', 'ACC-2%')
            ->orderBy('submissions.updated_at', 'desc')
            ->count();
    }

    public function reportSKepsek(){
        return DB::table('submissions')
        ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
        ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
        ->join('transaksi', 'transaksi.id_transaksi','=', 'submissions.id_transaksi')
        ->join('dana', 'dana.id_dana','=', 'transaksi.id_dana')
        ->select('submissions.judul')
        ->where('submissions.status','like','ACC-3%')
        ->orWhere('submissions.status','like','Rejected')
        ->count();
    }
    public function reportTKepsek(){
        return DB::table('submissions')
        ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
        ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
        ->join('transaksi', 'transaksi.id_transaksi','=', 'submissions.id_transaksi')
        ->join('dana', 'dana.id_dana','=', 'transaksi.id_dana')
        ->select('transaksi.id_transaksi')
        ->where('transaksi.jenis','!=','pending')
        ->count();
    }

    //Ka Keuangan
    public function submissionKaKeuangan(){
        return DB::table('submissions')
            ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
            ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
            ->select('submissions.judul', 'detail_accounts.nama')
            ->where('submissions.status', 'LIKE', 'ACC-1%')
            ->orderBy('submissions.updated_at', 'desc')
            ->count();
    }

    public function reportSKaKeuangan(){
        return DB::table('submissions')
        ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
        ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
        ->join('transaksi', 'transaksi.id_transaksi','=', 'submissions.id_transaksi')
        ->join('dana', 'dana.id_dana','=', 'transaksi.id_dana')
        ->select('submissions.judul')
        ->where('submissions.status','like','ACC-3%')
        ->orWhere('submissions.status','like','Rejected')
        ->count();
    }
    public function reportTKaKeuangan(){
        return DB::table('submissions')
        ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
        ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
        ->join('transaksi', 'transaksi.id_transaksi','=', 'submissions.id_transaksi')
        ->join('dana', 'dana.id_dana','=', 'transaksi.id_dana')
        ->select('transaksi.id_transaksi')
        ->where('transaksi.jenis','!=','pending')
        ->count();
    }

    //BOS
    public function submissionBOS(){
        return DB::table('submissions')
            ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
            ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
            ->select('submissions.judul', 'detail_accounts.nama')
            ->where('submissions.status', 'LIKE', 'ACC-B%')
            ->orderBy('submissions.updated_at', 'desc')
            ->count();
    }

    public function reportSfordashboardBOS(){
        return DB::table('submissions')
        ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
        ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
        ->join('transaksi', 'transaksi.id_transaksi','=', 'submissions.id_transaksi')
        ->join('dana', 'dana.id_dana','=', 'transaksi.id_dana')
        ->select('submissions.judul')
        ->where('transaksi.id_dana', '=', 'BOS')
        ->where([
            ['submissions.status','like','ACC-3%'],
            ['dana.id_dana','=','BOS'],
        ])
        ->count();
    }
    public function reportTfordashboardBOS(){
        return DB::table('submissions')
        ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
        ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
        ->join('transaksi', 'transaksi.id_transaksi','=', 'submissions.id_transaksi')
        ->join('dana', 'dana.id_dana','=', 'transaksi.id_dana')
        ->select('transaksi.id_transaksi')
        ->where([
            ['submissions.status','like','ACC-3%'],
            ['dana.id_dana','=','BOS'],
        ])
        ->count();
    }

    //APBD
    public function submissionAPBD(){
        return DB::table('submissions')
            ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
            ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
            ->select('submissions.judul', 'detail_accounts.nama')
            ->where('submissions.status', 'LIKE', 'ACC-A%')
            ->orderBy('submissions.updated_at', 'desc')
            ->count();
    }

    public function reportSfordashboardAPBD(){
        return DB::table('submissions')
        ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
        ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
        ->join('transaksi', 'transaksi.id_transaksi','=', 'submissions.id_transaksi')
        ->join('dana', 'dana.id_dana','=', 'transaksi.id_dana')
        ->select('submissions.judul')
        ->where([
            ['submissions.status','like','ACC-3%'],
            ['dana.id_dana','=','APBD'],
        ])
        ->count();
    }
    public function reportTfordashboardAPBD(){
        return DB::table('submissions')
        ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
        ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
        ->join('transaksi', 'transaksi.id_transaksi','=', 'submissions.id_transaksi')
        ->join('dana', 'dana.id_dana','=', 'transaksi.id_dana')
        ->select('transaksi.id_transaksi')
        ->where([
            ['submissions.status','like','ACC-3%'],
            ['dana.id_dana','=','APBD'],
        ])
        ->count();
    }



    public function reportA($search='')
    {
        return DB::table('submissions')
            ->join('transaksi','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
            ->select('submissions.*','detail_submissions.deskripsi','detail_submissions.file_lampiran','detail_accounts.nama','detail_accounts.id_jurusan','transaksi.jumlah')
            ->where('transaksi.jenis','!=','Pending')
            ->orderBy('submissions.updated_at', 'desc')
            ->get();
    }
    public function reportBOS($search='')
    {
        return DB::table('submissions')
            ->join('transaksi','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
            ->select('submissions.*','detail_submissions.deskripsi','detail_submissions.file_lampiran','detail_accounts.nama','detail_accounts.id_jurusan','transaksi.jumlah')
            ->where([
                ['transaksi.jenis','!=','Pending'],
                ['transaksi.id_dana','=','BOS'],
            ])
            ->where(function($query) use ($search){
                $query->where('submissions.judul', 'LIKE', '%'.$search.'%')
                      ->orWhere('detail_accounts.nama', 'LIKE', '%'.$search.'%')
                      ->orWhere('submissions.created_at', 'LIKE', '%'.$search.'%')
                      ->orWhere('submissions.status', 'LIKE', '%'.$search.'%')
                      ->orWhere('transaksi.jumlah', 'LIKE', '%'.$search.'%');
            })
            ->orderBy('submissions.updated_at', 'desc')
            ->get();
    }
    public function reportAPBD($search='')
    {
        return DB::table('submissions')
            ->join('transaksi','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
            ->select('submissions.*','detail_submissions.deskripsi','detail_submissions.file_lampiran','detail_accounts.nama','detail_accounts.id_jurusan','transaksi.jumlah')
            ->where([
                ['transaksi.jenis','!=','Pending'],
                ['transaksi.id_dana','=','APBD'],
            ])
            ->where(function($query) use ($search){
                $query->where('submissions.judul', 'LIKE', '%'.$search.'%')
                      ->orWhere('detail_accounts.nama', 'LIKE', '%'.$search.'%')
                      ->orWhere('submissions.created_at', 'LIKE', '%'.$search.'%')
                      ->orWhere('submissions.status', 'LIKE', '%'.$search.'%')
                      ->orWhere('transaksi.jumlah', 'LIKE', '%'.$search.'%');
            })
            ->orderBy('submissions.updated_at', 'desc')
            ->get();
    }
    public function reportKaprog($search='')
    {
        return DB::table('submissions')
            ->join('transaksi','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
            ->select('submissions.*','detail_submissions.deskripsi','detail_submissions.file_lampiran','detail_accounts.nama','detail_accounts.id_jurusan','transaksi.jumlah','transaksi.id_dana')
            ->where([
                ['transaksi.jenis','!=','Pending'],
                ['submissions.id_pengaju','=',Auth::user()->nip],
            ])
            ->where(function($query) use ($search){
                $query->where('submissions.judul', 'LIKE', '%'.$search.'%')
                      ->orWhere('detail_accounts.nama', 'LIKE', '%'.$search.'%')
                      ->orWhere('submissions.created_at', 'LIKE', '%'.$search.'%')
                      ->orWhere('submissions.status', 'LIKE', '%'.$search.'%')
                      ->orWhere('transaksi.jumlah', 'LIKE', '%'.$search.'%')
                      ->orWhere('transaksi.id_dana', 'LIKE', '%'.$search.'%');
            })
            ->orderBy('submissions.updated_at', 'desc')
            ->get();
    }
    public function yoursubmission()
    {
        return DB::table('submissions')
            ->join('transaksi','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
            ->select('submissions.*','detail_submissions.deskripsi','detail_submissions.file_lampiran','detail_accounts.nama','detail_accounts.id_jurusan','transaksi.jumlah','transaksi.id_dana')
            ->where([
                ['transaksi.jenis','=','Pending'],
                ['submissions.id_pengaju','=',Auth::user()->nip],
            ])
            ->orderBy('submissions.updated_at', 'desc')
            ->get();
    }
}
