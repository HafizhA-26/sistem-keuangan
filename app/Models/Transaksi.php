<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected  $primaryKey = 'id_transaksi';
    public $incrementing = false;
    protected $fillable = [
        'id_transaksi',
        'id_dana',
        'jenis',
        'id_pengaju'
    ];

    public function countIn($jabatan)
    {
        if($jabatan == "Staf BOS"){
            return DB::table('transaksi')
                ->where([
                    ['jenis','=','Masuk'],
                    ['id_dana','=','BOS'],
                ])
                ->count();
        }else if ($jabatan == "Staf APBD"){
            return DB::table('transaksi')
                ->where([
                    ['jenis','=','Masuk'],
                    ['id_dana','=','APBD'],
                ])
                ->count();
        }else{
            return DB::table('transaksi')
                ->where('jenis','=','Masuk')
                ->count();
        }
        
    }
    public function countOut($jabatan)
    {
        if($jabatan == "Staf BOS"){
            return DB::table('transaksi')
                ->where([
                    ['jenis','=','Keluar'],
                    ['id_dana','=','BOS'],
                ])
                ->count();
        }else if ($jabatan == "Staf APBD"){
            return DB::table('transaksi')
                ->where([
                    ['jenis','=','Keluar'],
                    ['id_dana','=','APBD'],
                ])
                ->count();
        }else{
            return DB::table('transaksi')
                ->where('jenis','=','Keluar')
                ->count();
        }
    }
    public function reportA()
    {
        return DB::table('transaksi')
            ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
            ->select('transaksi.*','detail_accounts.nama','detail_accounts.id_jurusan')
            ->where([
                ['transaksi.jenis','!=','Pending'],
                ['transaksi.jenis','!=','rejected'],
            ])
            ->orderBy('submissions.updated_at', 'desc')
            ->get();
    }
    public function reportBOS()
    {
        return DB::table('transaksi')
            ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
            ->select('transaksi.*','detail_accounts.nama','detail_accounts.id_jurusan')
            ->where([
                ['transaksi.jenis','!=','Pending'],
                ['transaksi.id_dana','=','BOS'],
                ['transaksi.jenis','!=','rejected'],
            ])
            ->orderBy('submissions.updated_at', 'desc')
            ->get();
    }
    public function reportAPBD()
    {
        return DB::table('transaksi')
            ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
            ->select('transaksi.*','detail_accounts.nama','detail_accounts.id_jurusan')
            ->where([
                ['transaksi.jenis','!=','Pending'],
                ['transaksi.jenis','!=','rejected'],
                ['transaksi.id_dana','=','APBD'],
            ])
            ->orderBy('submissions.updated_at', 'desc')
            ->get();
    }

}
