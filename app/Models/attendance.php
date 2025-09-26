<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class attendance extends Model
{
    use HasFactory;
    use HasTimestamps;
    protected $table = "attendances";
    protected $fillable = [
        'pegawai_id',
        'date',
        'waktu_masuk',
        'waktu_keluar',
        // 'shift_id',
        'status',
        'note',
        'attachment',
    ];

    // Menambahkan method untuk menerjemahkan status ke Bahasa Indonesia
    public function getStatusInIndonesian()
    {
        $translations = [
            'present' => 'Hadir',
            'late' => 'Terlambat',
            'excused' => 'Izin',
            'sick' => 'Sakit',
            'absent' => 'Tidak Hadir'
        ];

        return $translations[$this->status] ?? $this->status;
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    

    // public function shift(): BelongsTo
    // {
    //     return $this->belongsTo(Shift::class);
    // }
}
