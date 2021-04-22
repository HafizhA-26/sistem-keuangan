<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class BosChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $a = array('Jan','Feb','March');
        $chart = Chartisan::build()
            ->labels($a)
            ->dataset('Pemasukkan', [100000, 20000, 300000])
            ->dataset('Pengeluaran', [100000, 500000, 40000])
            ->toJSON();
        return $chart;
    }
}