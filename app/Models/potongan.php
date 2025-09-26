<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class potongan extends Model
{
    use HasFactory;

    protected $table = "potongan";
    protected $fillable = ['asuransi', 'bpjs','absen','lainnya','total_potongan'];

    public function pegawai()
    {
        return $this->belongsToMany(Pegawai::class, 'pegawai_potongan', 'potongan_id', 'pegawai_id');
    }
}
