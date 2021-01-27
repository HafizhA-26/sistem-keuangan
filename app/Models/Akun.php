<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Akun extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'accounts';
    protected  $primaryKey = 'nip';
    public $incrementing = false;
    protected $fillable = [
        'nip',
        'password',
        'status',
        'remember_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function countAll(){
        return DB::table('accounts')
            ->count();
    }
    public function allData(){
        return DB::table('accounts')
            ->join('detail_accounts', 'detail_accounts.nip', 'accounts.nip')
            ->get();
    }
    public function akunOnline(){
        return DB::table('accounts')
            ->join('detail_accounts', 'detail_accounts.nip', 'accounts.nip')
            ->join('jabatan', 'jabatan.id_jabatan', 'detail_accounts.id_jabatan')
            ->select('detail_accounts.nama', 'jabatan.nama_jabatan')
            ->where('accounts.status', '=', 'online')
            ->get();
    }
    public function countOnline(){
        return DB::table('accounts')
        ->select('accounts.status')
        ->where('accounts.status', '=', 'online')
        ->count();
    }
    public function akunOffline(){
        return DB::table('accounts')
            ->join('detail_accounts', 'detail_accounts.nip', 'accounts.nip')
            ->join('jabatan', 'jabatan.id_jabatan', 'detail_accounts.id_jabatan')
            ->select('detail_accounts.nama', 'jabatan.nama_jabatan')
            ->where('accounts.status', '=', 'offline')
            ->get();
    }
    public function countOffline(){
        return DB::table('accounts')
        ->select('accounts.status')
        ->where('accounts.status', '=', 'offline')
        ->count();
    }
}
