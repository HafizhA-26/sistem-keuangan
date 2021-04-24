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
                    ['jenis','=','masuk'],
                    ['id_dana','=','BOS'],
                ])
                ->count();
        }else if ($jabatan == "Staf APBD"){
            return DB::table('transaksi')
                ->where([
                    ['jenis','=','masuk'],
                    ['id_dana','=','APBD'],
                ])
                ->count();
        }else{
            return DB::table('transaksi')
                ->where('jenis','=','masuk')
                ->count();
        }
        
    }
    public function countOut($jabatan)
    {
        if($jabatan == "Staf BOS"){
            return DB::table('transaksi')
                ->where([
                    ['jenis','=','keluar'],
                    ['id_dana','=','BOS'],
                ])
                ->count();
        }else if ($jabatan == "Staf APBD"){
            return DB::table('transaksi')
                ->where([
                    ['jenis','=','keluar'],
                    ['id_dana','=','APBD'],
                ])
                ->count();
        }else{
            return DB::table('transaksi')
                ->where('jenis','=','Keluar')
                ->count();
        }
    }
    public function dataIn($jabatan)
    {
        if($jabatan == "Staf BOS"){
            return DB::table('transaksi')
                ->where([
                    ['jenis','=','masuk'],
                    ['id_dana','=','BOS'],
                ])
                ->groupBy('updated_at')
                ->get();
        }else if ($jabatan == "Staf APBD"){
            return DB::table('transaksi')
                ->where([
                    ['jenis','=','masuk'],
                    ['id_dana','=','APBD'],
                ])
                ->groupBy('updated_at')
                ->get();
        }else{
            return DB::table('transaksi')
                ->select(DB::raw('SUM(jumlah) as total'))
                ->where('jenis','=','masuk')
                ->groupBy('updated_at')
                ->get();
        }
        
    }
    public function dataChart($jabatan){
        if($jabatan == "Staf BOS"){
            return DB::table('transaksi')
                ->select(DB::raw('SUM(jumlah) as total'), DB::raw('DATE_FORMAT(updated_at, "%d-%m-%Y") as tgl'), 'jenis')
                ->where('id_dana','=','BOS')
                ->groupByRaw('tgl, jenis')
                ->orderBy('updated_at','asc')
                ->get();
        }else if ($jabatan == "Staf APBD"){
            return DB::table('transaksi')
                ->select(DB::raw('SUM(jumlah) as total'), DB::raw('DATE_FORMAT(updated_at, "%d-%m-%Y") as tgl'), 'jenis')
                ->where('id_dana','=','APBD')
                ->groupByRaw('tgl, jenis')
                ->orderBy('updated_at','asc')
                ->get();
        }else{
            return DB::table('transaksi')
                ->select(DB::raw('SUM(jumlah) as total'), DB::raw('DATE_FORMAT(updated_at, "%d-%m-%Y") as tgl'), 'jenis')
                ->where('jenis','!=','pending')
                ->groupByRaw('tgl, jenis')
                ->orderBy('updated_at','asc')
                ->get();
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
