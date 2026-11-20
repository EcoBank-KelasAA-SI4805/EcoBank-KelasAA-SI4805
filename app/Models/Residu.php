<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Residu extends Model
{
    protected $table = 'residu';

    protected $fillable = [
        'tanggal',
        'id_jenis_residu',
        'berat_kg',
        'asal',
        'biaya_per_kg',
        'total_biaya',
        'status',
    ];

    protected $casts = [
        'tanggal'     => 'date',
        'berat_kg'    => 'decimal:2',
        'biaya_per_kg'=> 'decimal:2',
        'total_biaya' => 'decimal:2',
    ];

    public function jenisResidu()
    {
        return $this->belongsTo(JenisResidu::class, 'id_jenis_residu');
    }

    public static function hitungTotalBiaya(float $berat, float $biayaPerKg): float
    {
        return round($berat * $biayaPerKg, 2);
    }

    public function isDeletable(): bool
    {
        return $this->status === 'ditampung';
    }
}
