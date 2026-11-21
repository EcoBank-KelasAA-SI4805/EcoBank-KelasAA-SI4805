<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';

    protected $fillable = [
        'judul',
        'tanggal',
        'lokasi',
        'kuota',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'kuota'   => 'integer',
    ];

    public function peserta(): HasMany
    {
        return $this->hasMany(Peserta::class, 'id_kegiatan');
    }

    public function isDijadwalkan(): bool
    {
        return $this->status === 'dijadwalkan';
    }

    public function isBatalkan(): bool
    {
        return $this->status === 'dibatalkan';
    }
}
