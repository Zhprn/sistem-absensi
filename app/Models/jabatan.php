<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class jabatan extends Model
{
    use HasFactory;
    protected $table = "jabatan";
    protected $fillable = ["jabatan","deskripsi"];


    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class);
    }
}
