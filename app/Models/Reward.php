<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
        'nama_reward',
        'poin_harga',
        'stok',
        'deskripsi',
        'status_aktif',
    ];

    protected $casts = [
        'poin_harga' => 'integer',
        'stok' => 'integer',
        'status_aktif' => 'boolean',
    ];
}
