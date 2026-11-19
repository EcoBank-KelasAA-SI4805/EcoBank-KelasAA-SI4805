<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePenarikan extends Model
{
    protected $table = 'metode_penarikans';

    protected $fillable = [
        'nama_metode',
        'kategori',
        'minimal_tarik',
        'deskripsi',
        'status_aktif',
    ];

    protected $casts = [
        'minimal_tarik' => 'decimal:2',
        'status_aktif' => 'boolean',
    ];
}
