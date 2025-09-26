<?php

namespace App\Exports;

use App\Models\gaji;
use Maatwebsite\Excel\Concerns\FromCollection;

class GajiExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return gaji::all();
    }
}
