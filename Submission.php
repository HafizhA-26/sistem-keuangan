<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Submission extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'submissions';
    protected  $primaryKey = 'id_pengajuan';
    public $incrementing = false;
    protected $fillable = [
        'id_pengajuan',
        'judul',
        'tgl_pengajuan',
        'status'
    ];
    public function allData(){
        return DB::table('submissions')
            ->join('detail_submissions', 'detail_submissions.id_pengajuan', '=', 'submissions.id_pengajuan')
            ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
            ->join('detail_accounts', 'detail_accounts.nip', '=', 'accounts.nip')
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'submissions.id_transaksi')
            ->select('submissions.*','detail_submissions.*', 'detail_accounts.*', 'accounts.nip', 'transaksi.jumlah', 'transaksi.id_dana', 'transaksi.jenis', 'submissions.created_at')
            ->where('submissions.status', 'LIKE', 'ACC-2%')
            ->get();
    }

    
}
