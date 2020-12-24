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

    public function countIn()
    {
        return DB::table('transaksi')
            ->where('jenis','=','Masuk')
            ->count();
    }
    public function countOut()
    {
        return DB::table('transaksi')
            ->where('jenis','=','Keluar')
            ->count();
    }
    public function reportA()
    {
        return DB::table('transaksi')
            ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->select('transaksi.*','submissions.id_pengaju')
            ->where('transaksi.jenis','!=','Pending')
            ->get();
    }
    public function reportBOS()
    {
        return DB::table('transaksi')
            ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->select('transaksi.*','submissions.id_pengaju')
            ->where([
                'transaksi.jenis','!=','Pending',
                'id_dana','=','BOS',
            ])
            ->get();
    }
    public function reportAPBD()
    {
        return DB::table('transaksi')
            ->join('submissions','submissions.id_transaksi','=','transaksi.id_transaksi')
            ->select('transaksi.*','submissions.id_pengaju')
            ->where([
                'transaksi.jenis','!=','Pending',
                'id_dana','=','APBD',
            ])
            ->get();
    }

}
