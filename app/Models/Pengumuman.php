<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'isi',
        'tanggal_tayang',
    ];

    protected $casts = [
        'tanggal_tayang' => 'date',
    ];

    /**
     * Cek apakah pengumuman sudah mulai tayang hari ini atau sebelumnya
     */
    public function getIsTayangAttribute(): bool
    {
        return $this->tanggal_tayang ? $this->tanggal_tayang->lte(now()->startOfDay()) : false;
    }
}
