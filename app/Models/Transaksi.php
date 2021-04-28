<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
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

    public function countIn($jenisDana, $jenisPengajuan, $formatW, $limitW)
    {
        if($jenisPengajuan){
            return DB::table('transaksi')
                    ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
                    ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
                    ->where([
                        ['transaksi.jenis','=','masuk'],
                        ['transaksi.id_dana','LIKE', '%'.$jenisDana.'%'],
                        ['detail_submissions.sub_jenis','=',$jenisPengajuan],
                    ])
                    ->whereBetween('transaksi.updated_at', [$limitW, Carbon::now()])
                    ->count();
        }else{
            return DB::table('transaksi')
                    ->where([
                        ['jenis','=','masuk'],
                        ['id_dana','LIKE', '%'.$jenisDana.'%'],
                    ])
                    ->whereBetween('transaksi.updated_at', [$limitW, Carbon::now()])
                    ->count();
        }
        
    }
    public function countOut($jenisDana, $jenisPengajuan, $formatW, $limitW)
    {
        if($jenisPengajuan){
            return DB::table('transaksi')
                    ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
                    ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
                    ->where([
                        ['transaksi.jenis','=','keluar'],
                        ['transaksi.id_dana','LIKE', '%'.$jenisDana.'%'],
                        ['detail_submissions.sub_jenis','=',$jenisPengajuan],
                    ])
                    ->whereBetween('transaksi.updated_at', [$limitW, Carbon::now()])
                    ->count();
        }else{
            return DB::table('transaksi')
                ->where([
                    ['jenis','=','keluar'],
                    ['id_dana','LIKE', '%'.$jenisDana.'%'],
                ])
                ->whereBetween('transaksi.updated_at', [$limitW, Carbon::now()])
                ->count();
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
    
    public function reportT($jenisDana, $masukKeluar, $jenisPengajuan, $formatW, $limitW)
    {
        if($jenisPengajuan){
            return DB::table('transaksi')
                ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
                ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
                ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
                ->select('transaksi.*','detail_accounts.nama','detail_accounts.id_jurusan')
                ->where([
                    ['transaksi.jenis','!=','pending'],
                    ['transaksi.jenis','!=','rejected'],
                    ['transaksi.id_dana','LIKE','%'.$jenisDana.'%'],
                    ['transaksi.jenis','LIKE','%'.$masukKeluar.'%'],
                    ['detail_submissions.sub_jenis','=',$jenisPengajuan],
                ])
                ->whereBetween('transaksi.updated_at', [$limitW, Carbon::now()])
                ->orderBy('transaksi.updated_at', 'desc')
                ->get();
        }else{
            return DB::table('transaksi')
                ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
                ->join('detail_accounts','submissions.id_pengaju','=','detail_accounts.nip')
                ->select('transaksi.*','detail_accounts.nama','detail_accounts.id_jurusan')
                ->where([
                    ['transaksi.jenis','!=','pending'],
                    ['transaksi.jenis','!=','rejected'],
                    ['transaksi.id_dana','LIKE','%'.$jenisDana.'%'],
                    ['transaksi.jenis','LIKE','%'.$masukKeluar.'%'],
                ])
                ->whereBetween('transaksi.updated_at', [$limitW, Carbon::now()])
                ->orderBy('transaksi.updated_at', 'desc')
                ->get();
        }
    }
    
    public function chartCategories($jenisDana, $masukKeluar, $jenisPengajuan, $formatW, $limitW){
        if($jenisPengajuan){
            return DB::table('transaksi')
                ->join('submissions','transaksi.id_transaksi','=','submissions.id_transaksi')
                ->join('detail_submissions','detail_submissions.id_pengajuan','=','submissions.id_pengajuan')
                ->select(DB::raw('DATE_FORMAT(transaksi.updated_at, "'.$formatW.'") as tgl'))
                ->where([
                    ['transaksi.jenis','!=','pending'],
                    ['transaksi.jenis','!=','rejected'],
                    ['transaksi.id_dana','LIKE','%'.$jenisDana.'%'],
                    ['transaksi.jenis','LIKE','%'.$masukKeluar.'%'],
                ])
                ->whereBetween('transaksi.updated_at', [$limitW, Carbon::now()])
                ->where('detail_submissions.sub_jenis','=', $jenisPengajuan)
                ->orderBy('transaksi.updated_at','asc')
                ->distinct()
                ->get();
        }else{
            return DB::table('transaksi')
                ->select(DB::raw('DATE_FORMAT(updated_at, "'.$formatW.'") as tgl'))
                ->where([
                    ['transaksi.jenis','!=','pending'],
                    ['transaksi.jenis','!=','rejected'],
                    ['transaksi.id_dana','LIKE','%'.$jenisDana.'%'],
                    ['transaksi.jenis','LIKE','%'.$masukKeluar.'%'],
                ])
                ->whereBetween('transaksi.updated_at', [$limitW, Carbon::now()])
                ->orderBy('updated_at','asc')
                ->distinct()
                ->get();
        }
    }
   
    public function getChartDataMasuk($jenisDana, $tgl, $jenisPengajuan, $formatW, $limitW){
        if($jenisPengajuan){
            return DB::table('transaksi')
                ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
                ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
                ->select(DB::raw('SUM(transaksi.jumlah) as total'), DB::raw('DATE_FORMAT(transaksi.updated_at, "'.$formatW.'") as tgl'))
                ->where([
                    ['transaksi.jenis','=','masuk'],
                    ['transaksi.id_dana','LIKE','%'.$jenisDana.'%'],
                    [DB::raw('DATE_FORMAT(transaksi.updated_at, "'.$formatW.'")'),'=',$tgl],
                    ['detail_submissions.sub_jenis','=',$jenisPengajuan],
                ])
                ->whereBetween('transaksi.updated_at', [$limitW, Carbon::now()])
                ->groupBy('tgl')
                ->first();
        }else{
            return DB::table('transaksi')
                ->select(DB::raw('SUM(jumlah) as total'), DB::raw('DATE_FORMAT(updated_at, "'.$formatW.'") as tgl'))
                ->where([
                    ['jenis','=','masuk'],
                    ['id_dana','LIKE','%'.$jenisDana.'%'],
                    [DB::raw('DATE_FORMAT(updated_at, "'.$formatW.'")'),'=',$tgl],
                ])
                ->whereBetween('transaksi.updated_at', [$limitW, Carbon::now()])
                ->groupBy('tgl')
                ->first();
        }
        
    }
    public function getChartDataKeluar($jenisDana, $tgl, $jenisPengajuan, $formatW, $limitW){
        if($jenisPengajuan){
            return DB::table('transaksi')
            ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->join('detail_submissions','submissions.id_pengajuan','=','detail_submissions.id_pengajuan')
            ->select(DB::raw('SUM(transaksi.jumlah) as total'), DB::raw('DATE_FORMAT(transaksi.updated_at, "'.$formatW.'") as tgl'))
            ->where([
                ['jenis','=','keluar'],
                ['id_dana','LIKE','%'.$jenisDana.'%'],
                [DB::raw('DATE_FORMAT(transaksi.updated_at,"'.$formatW.'")'),'=',$tgl],
                ['detail_submissions.sub_jenis','=',$jenisPengajuan],
            ])
            ->whereBetween('transaksi.updated_at', [$limitW, Carbon::now()])
            ->groupBy('tgl')
            ->first();
        }else{
            return DB::table('transaksi')
            ->select(DB::raw('SUM(jumlah) as total'), DB::raw('DATE_FORMAT(updated_at, "'.$formatW.'") as tgl'))
            ->where([
                ['jenis','=','keluar'],
                ['id_dana','LIKE','%'.$jenisDana.'%'],
                [DB::raw('DATE_FORMAT(updated_at, "'.$formatW.'")'),'=',$tgl],
            ])
            ->whereBetween('transaksi.updated_at', [$limitW, Carbon::now()])
            ->groupBy('tgl')
            ->first();
        }
        
    }
}
