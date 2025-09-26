<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class tunjangan extends Model
{
    use HasFactory;

    protected $table = "tunjangan";
    protected $fillable = ['kehadiran', 'makan','transportasi','lembur','lainnya','total_tunjangan'];

    public function pegawai()
    {
        return $this->belongsToMany(Pegawai::class, 'pegawai_tunjangan', 'tunjangan_id', 'pegawai_id');
    }
}
