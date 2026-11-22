<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promo extends Model
{
    protected $table = 'promo';

    protected $fillable = [
        'nama',
        'id_jenis',
        'tipe_bonus',
        'nilai_bonus',
        'tgl_mulai',
        'tgl_selesai',
    ];

    protected $casts = [
        'nilai_bonus' => 'decimal:2',
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
    ];

    public function jenisSampah(): BelongsTo
    {
        return $this->belongsTo(JenisSampah::class, 'id_jenis');
    }
}
