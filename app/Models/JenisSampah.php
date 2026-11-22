<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class JenisSampah extends Model
{
    protected $table = 'jenis_sampah';
    protected $fillable = ['nama_jenis', 'kategori', 'satuan', 'harga_per_kg', 'status_aktif'];
    protected $casts = ['harga_per_kg' => 'decimal:2', 'status_aktif' => 'boolean'];

    public const KATEGORI = ['Plastik', 'Kertas', 'Logam', 'Kaca', 'Lainnya'];

    public function riwayatHarga(): HasMany
    {
        return $this->hasMany(RiwayatHarga::class, 'jenis_sampah_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    /**
     * Jenis dianggap "sudah dipakai" jika ada di detail_setoran.
     * Tabel detail_setoran dibuat PBI Setoran (P-15), jadi dicek dulu agar
     * kode ini tidak error selama tabel itu belum ada.
     */
    public function sudahDipakai(): bool
    {
        return Schema::hasTable('detail_setoran')
            && DB::table('detail_setoran')->where('jenis_sampah_id', $this->id)->exists();
    }
}
