<?php

namespace App\Imports;

use App\Models\bagian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BagianImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new bagian([
            'bagian'       => $row['nama_bagian'],
            'deskripsi'    => $row['deskripsi'] 
        ]);
    }
}
