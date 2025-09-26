<?php

namespace App\Exports;

use App\Models\jabatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JabatanExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public function query()
    {
        return jabatan::query()->select('jabatan', 'deskripsi');
    }

    public function headings(): array
    {
        return ["Nama Jabatan", "Deskripsi"]; // Menentukan judul kolom dalam file Excel
    }
}
