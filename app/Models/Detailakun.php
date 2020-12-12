<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailakun extends Model
{
    use HasFactory;

    protected $table = 'detail_accounts';
    protected  $primaryKey = 'nip';
    protected $fillable = [
        'nip',
        'nuptk',
        'nama',
        'jk',
        'noHP',
        'id_jabatan',
        'alamat',
        'picture',
        'id_jurusan'
    ];
}
