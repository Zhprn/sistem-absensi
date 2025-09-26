<?php

namespace App\Exports;

use App\Models\pegawai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PegawaiExport implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function query()
    {
        // return pegawai::query()->select('nip','nama_pegawai','alamat','gender','tgl_lahir','jabatan_id','bagian_id','shift_id','foto','telepon','gaji_pokok');
        return pegawai::query();
    }

    public function map($pegawai): array{
        return [
            $pegawai->nip,
            $pegawai->nama_pegawai,
            $pegawai->alamat,
            $pegawai->gender,
            $pegawai->tgl_lahir,
            $pegawai->jabatan->jabatan,
            $pegawai->bagian->bagian,
            $pegawai->shift->shift,
            $pegawai->foto,
            $pegawai->telepon,
            $pegawai->gaji_pokok,
        ];
    }

    public function headings(): array
    {
        return ["Nip", "Nama Pegawai","Alamat","Gender","Tanggal Lahir", "Jabatan", "Bagian", "Shift", "Foto", "Telepon", "Gaji Pokok"]; // Menentukan judul kolom dalam file Excel
    }
}
