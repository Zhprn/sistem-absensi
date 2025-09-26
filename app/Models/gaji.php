<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class gaji extends Model
{
    use HasFactory;

    protected $table = "gaji";
    protected $fillable = ['pegawai_id','periode', 'pph','total_gaji'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
