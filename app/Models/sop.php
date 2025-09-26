<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class sop extends Model
{
    use HasFactory;
    protected $table = "sop";
    protected $fillable = ["title","desc","bagian_id","content"];

    public function bagian(): BelongsTo
    {
        return $this->belongsTo(Bagian::class);
    }

    public function task()
    {
        return $this->hasMany(task::class);
    }
}
