<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class task extends Model
{
    use HasFactory;
    protected $table = "task";
    protected $fillable = ["tugas","desc","sop_id","bagian_id","waktu_mulai","waktu_deadline"];

    public function bagian(): BelongsTo
    {
        return $this->belongsTo(Bagian::class);
    }

    public function pegawai()
    {
        return $this->belongsToMany(Pegawai::class, 'pegawai_task')->withPivot('id','status','bukti');
    }

    // $table->foreignId('pegawai_id')->constrained(
    //     table: 'pegawai',
    //     indexName: 'pegawai_task_pegawai_id'
    // );
    // $table->foreignId('task_id')->constrained(
    //     table: 'task',
    //     indexName: 'pegawai_task_task_id'
    // );
    // $table->string('status');
}
