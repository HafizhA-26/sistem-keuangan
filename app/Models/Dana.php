<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dana extends Model
{
    use HasFactory;

    protected $table = 'dana';
    protected  $primaryKey = 'id_dana';
    public $incrementing = false;
    protected $fillable = [
        'jumlah'
    ];
}
