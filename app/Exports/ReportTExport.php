<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class ReportTExport implements FromCollection, WithHeadings,ShouldAutoSize, WithMapping, WithColumnFormatting
{
    protected $data;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
    public function map($data): array
    {
        return [
            $data->id_transaksi,
            $data->id_dana,
            $data->nama,
            ("Rp. ".number_format($data->jumlah,2,",",".")),
            $data->jenis,
            Date::dateTimeToExcel(Carbon::parse($data->created_at)),
            Date::dateTimeToExcel(Carbon::parse($data->updated_at)),
        ];
    }
    public function collection()
    {
        return $this->data;
    }
    public function headings():array
    {
        return ['ID Transaksi','Jenis Dana','Pengaju','Jumlah','Jenis Transaksi','Tanggal dibuat','Tanggal selesai'];
    }
}
