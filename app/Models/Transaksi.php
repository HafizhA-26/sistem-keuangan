<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
