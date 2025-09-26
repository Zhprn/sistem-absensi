<?php

namespace App\Exports;

use App\Models\shift;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShiftExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public function query()
    {
        return shift::query()->select('shift', 'waktu_mulai','waktu_akhir');
    }
    
    public function headings(): array
    {
        return ["Nama Shift", "Waktu Mulai","Waktu Akhir"]; // Menentukan judul kolom dalam file Excel
    }
}
