<?php

namespace App\Imports;

use App\Models\jabatan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JabatanImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new jabatan([
            'jabatan'       => $row['nama_jabatan'],
            'deskripsi'    => $row['deskripsi'] 
        ]);
    }
}
