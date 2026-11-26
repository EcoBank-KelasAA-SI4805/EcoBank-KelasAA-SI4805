<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatHarga extends Model
{
    protected $table = 'riwayat_harga';
    public $timestamps = false;
    protected $fillable = ['jenis_sampah_id', 'harga_lama', 'harga_baru', 'diubah_oleh', 'diubah_pada'];
    protected $casts = ['harga_lama' => 'decimal:2', 'harga_baru' => 'decimal:2', 'diubah_pada' => 'datetime'];

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class, 'jenis_sampah_id');
    }
}
