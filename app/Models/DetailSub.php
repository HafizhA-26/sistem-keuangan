<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSub extends Model
{
    use HasFactory;

    protected $table = 'detail_submissions';
    protected $fillable = [
        'id_pengajuan',
        'deskripsi',
        'id_transaksi',
        'file_lampiran',
        'id_komentar'
    ];
}
