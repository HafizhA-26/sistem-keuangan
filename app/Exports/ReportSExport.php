<?php

namespace App\Exports;

use App\Models\Submission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class ReportSExport implements FromCollection, WithHeadings,ShouldAutoSize
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
        return [];
    }
}
