<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSub extends Model
{
    use HasFactory;

    protected $table = 'detail_submissions';
    protected $fillable = [
        'id_pengajuan',
        'deskripsi',
        'file_lampiran',
    ];
}
