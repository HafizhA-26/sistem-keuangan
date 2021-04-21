<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class AllTransactionChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public $data=['A','B','C'];
    function getData(){
        $data = DB::table('transaksi')
        ->select('transaksi.*','detail_accounts.nama','detail_accounts.id_jurusan')
        ->where([
            ['transaksi.jenis','!=','Pending'],
            ['transaksi.jenis','!=','rejected'],
        ])
        ->orderBy('submissions.updated_at', 'asc')
        ->groupby('')
        ->get();
        $data =['A','B','C'];
    }
    public function handler(Request $request): Chartisan
    {
        
        return Chartisan::build()
            ->labels(['a','b','c'])
            ->dataset('Pemasukkan', [1,2, 3])
            ->dataset('Pengeluaran', [3, 2, 1]);
    }
}