<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class shift extends Model
{
    use HasFactory;
    protected $table = "shift";
    protected $fillable = ["shift","waktu_mulai","waktu_akhir"];

    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class);
    }
}
