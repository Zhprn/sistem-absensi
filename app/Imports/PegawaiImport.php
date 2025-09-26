<?php

namespace App\Imports;

use App\Models\shift;
use App\Models\bagian;
use App\Models\jabatan;
use App\Models\pegawai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PegawaiImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $jabatan = jabatan::where('jabatan', $row['jabatan'])->first();
            $bagian = bagian::where('bagian', $row['bagian'])->first();
            $shift = shift::where('shift', $row['shift'])->first();

            pegawai::create([
                'nip' => $row['nip'],
                'nama_pegawai' => $row['nama_pegawai'],
                'alamat' => $row['alamat'],
                'gender' => $row['gender'],
                'tgl_lahir' => $row['tanggal_lahir'],
                'jabatan_id' => $jabatan['id'],
                'bagian_id' => $bagian['id'],
                'shift_id' => $shift['id'],
                'foto' => $row['foto'],
                'telepon' => $row['telepon'],
                'gaji_pokok' => $row['gaji_pokok'],
            ]);
        }
    }
}
