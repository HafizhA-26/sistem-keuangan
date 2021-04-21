<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class JenisSubmission extends Model
{
    use HasFactory;
    protected $table = 'jenis_submissions';
    protected  $primaryKey = 'id_jenis';
    public $incrementing = false;

    public static function getMasukBOS(){
        return DB::table('jenis_submissions')
                ->select('nama_jenis')
                ->where([
                    'tipe' => 'masuk',
                    'id_dana' => 'BOS',
                ])
                ->get();
    }
    public static function getKeluarBOS(){
        return DB::table('jenis_submissions')
                ->select('nama_jenis')
                ->where([
                    'tipe' => 'keluar',
                    'id_dana' => 'BOS',
                ])
                ->get();
    }
    public static function getMasukAPBD(){
        return DB::table('jenis_submissions')
                ->select('nama_jenis')
                ->where([
                    'tipe' => 'masuk',
                    'id_dana' => 'APBD',
                ])
                ->get();
    }
    public static function getKeluarAPBD(){
        return DB::table('jenis_submissions')
                ->select('nama_jenis')
                ->where([
                    'tipe' => 'keluar',
                    'id_dana' => 'APBD',
                ])
                ->get();
    }
}
