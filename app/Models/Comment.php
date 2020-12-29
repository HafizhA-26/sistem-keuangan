<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected  $primaryKey = 'id';
    protected $fillable = [
        'id',
        'komentar',
        'comment_date',
        'nip'
    ];
}
