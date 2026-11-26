<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisResidu extends Model
{
    protected $table = 'jenis_residu';

    protected $fillable = [
        'nama',
        'alasan',
        'cara_penanganan',
        'biaya_per_kg',
    ];

    protected $casts = [
        'biaya_per_kg' => 'decimal:2',
    ];

    public function residu()
    {
        return $this->hasMany(Residu::class, 'id_jenis_residu');
    }

    public function isUsed(): bool
    {
        return $this->residu()->exists();
    }
}
