<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wilayah extends Model
{
    protected $table = 'wilayah';
    protected $fillable = ['nama_rw', 'kelurahan'];

    // Nasabah menyimpan RW sebagai teks (nasabah.rw) yang dicocokkan dengan wilayah.nama_rw.
    public function nasabah(): HasMany
    {
        return $this->hasMany(Nasabah::class, 'rw', 'nama_rw');
    }

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'wilayah_id');
    }
}
