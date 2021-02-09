<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportTExport implements FromCollection, WithHeadings,ShouldAutoSize
{
    protected $data;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        return $this->data;
    }
    public function headings():array
    {
        return ['ID Transaksi','Jenis Dana','Jumlah','Status','Tanggal dibuat','Tanggal selesai','Pengaju'];
    }
}
