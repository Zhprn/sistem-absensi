<?php

namespace App\Exports;

use App\Models\bagian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BagianExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function query()
    {
        return bagian::query()->select('bagian', 'deskripsi');
    }

    public function headings(): array
    {
        return ["Nama Bagian", "Deskripsi"]; // Menentukan judul kolom dalam file Excel
    }
}
