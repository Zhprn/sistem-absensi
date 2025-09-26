<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pegawaiTask extends Model
{
    protected $table = 'pegawai_task'; // Nama tabel
    protected $fillable = ['pegawai_id', 'task_id', 'status','bukti'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
