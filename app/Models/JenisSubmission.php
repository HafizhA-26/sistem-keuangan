<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSubmission extends Model
{
    use HasFactory;
    protected $table = 'jenis_submissions';
    protected  $primaryKey = 'id_jenis';
    public $incrementing = false;
}
