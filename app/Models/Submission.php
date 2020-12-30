<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'status'
    ];
    public function allDataForKepsek(){
        return DB::table('submissions')
            ->join('detail_submissions', 'detail_submissions.id_pengajuan', '=', 'submissions.id_pengajuan')
            ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
            ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'submissions.id_transaksi')
            ->select('submissions.*','detail_submissions.*', 'detail_accounts.*', 'accounts.nip', 'transaksi.jumlah', 'transaksi.id_dana', 'transaksi.jenis', 'submissions.created_at')
            ->where('submissions.status', 'LIKE', 'ACC-2%')
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
            ->get();
    }
    public function reportA($search='')
    {
        return DB::table('submissions')
            ->join('transaksi','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
            ->select('submissions.*','detail_submissions.deskripsi','detail_submissions.file_lampiran','detail_accounts.nama','detail_accounts.id_jurusan')
            ->where('transaksi.jenis','!=','Pending')
            ->where(function($query) use ($search){
                $query->where('submissions.judul', 'LIKE', '%'.$search.'%')
                      ->orWhere('detail_accounts.nama', 'LIKE', '%'.$search.'%')
                      ->orWhere('submissions.created_at', 'LIKE', '%'.$search.'%')
                      ->orWhere('submissions.status', 'LIKE', '%'.$search.'%');
            })
            ->paginate(10);
    }
    public function reportBOS($search='')
    {
        return DB::table('submissions')
            ->join('transaksi','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
            ->select('submissions.*','detail_submissions.deskripsi','detail_submissions.file_lampiran','detail_accounts.nama','detail_accounts.id_jurusan')
            ->where([
                ['transaksi.jenis','!=','Pending'],
                ['transaksi.id_dana','=','BOS'],
            ])
            ->where(function($query) use ($search){
                $query->where('submissions.judul', 'LIKE', '%'.$search.'%')
                      ->orWhere('detail_accounts.nama', 'LIKE', '%'.$search.'%')
                      ->orWhere('submissions.created_at', 'LIKE', '%'.$search.'%')
                      ->orWhere('submissions.status', 'LIKE', '%'.$search.'%');
            })
            ->paginate(10);
    }
    public function reportAPBD($search='')
    {
        return DB::table('submissions')
            ->join('transaksi','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
            ->select('submissions.*','detail_submissions.deskripsi','detail_submissions.file_lampiran','detail_accounts.nama','detail_accounts.id_jurusan')
            ->where([
                ['transaksi.jenis','!=','Pending'],
                ['transaksi.id_dana','=','APBD'],
            ])
            ->where(function($query) use ($search){
                $query->where('submissions.judul', 'LIKE', '%'.$search.'%')
                      ->orWhere('detail_accounts.nama', 'LIKE', '%'.$search.'%')
                      ->orWhere('submissions.created_at', 'LIKE', '%'.$search.'%')
                      ->orWhere('submissions.status', 'LIKE', '%'.$search.'%');
            })
            ->paginate(10);
    }
    public function reportKaprog($search='')
    {
        return DB::table('submissions')
            ->join('transaksi','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
            ->select('submissions.*','detail_submissions.deskripsi','detail_submissions.file_lampiran','detail_accounts.nama','detail_accounts.id_jurusan')
            ->where([
                ['transaksi.jenis','!=','Pending'],
                ['submissions.id_pengaju','=',Auth::user()->nip],
            ])
            ->where(function($query) use ($search){
                $query->where('submissions.judul', 'LIKE', '%'.$search.'%')
                      ->orWhere('detail_accounts.nama', 'LIKE', '%'.$search.'%')
                      ->orWhere('submissions.created_at', 'LIKE', '%'.$search.'%')
                      ->orWhere('submissions.status', 'LIKE', '%'.$search.'%');
            })
            ->paginate(10);
    }
}
