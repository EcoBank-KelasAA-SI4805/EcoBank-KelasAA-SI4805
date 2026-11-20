<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $fillable = ['wilayah_id', 'petugas_id', 'tanggal', 'jam'];
    protected $casts = ['tanggal' => 'date'];

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class, 'petugas_id');
    }

    public function getJamHmAttribute(): string
    {
        return substr((string) $this->jam, 0, 5);
    }
}
