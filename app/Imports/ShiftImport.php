<?php

namespace App\Imports;

use App\Models\shift;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShiftImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new shift([
            'shift'       => $row['nama_shift'],
            'waktu_mulai'    => $row['waktu_mulai'], 
            'waktu_akhir'    => $row['waktu_akhir'] 
        ]);
    }
}
