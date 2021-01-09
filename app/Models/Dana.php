<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dana extends Model
{
    use HasFactory;

    protected $table = 'dana';
    protected  $primaryKey = 'id_dana';
    public $incrementing = false;
    protected $fillable = [
        'jumlah'
    ];

    public function danaBOS(){
        return DB::table('dana')
        ->select('jumlah')
        ->where('id_dana', '=', 'BOS')
        ->value('jumlah');
    }
    
    public function danaAPBD(){
        return DB::table('dana')
        ->select('jumlah')
        ->where('id_dana', '=', 'APBD')
        ->value('jumlah');
    }
}
