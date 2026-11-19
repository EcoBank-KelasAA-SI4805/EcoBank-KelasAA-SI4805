<?php

namespace App\Models;
use App\Models\Nasabah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nasabah extends Model
{
    protected $table = 'nasabah';
    protected $fillable = ['nama', 'nik', 'alamat', 'no_hp', 'rw', 'saldo'];
    protected $casts = ['saldo' => 'decimal:2'];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'nasabah_id');
    }

    public function penarikanSaldo(): HasMany
    {
        return $this->hasMany(PenarikanSaldo::class, 'nasabah_id');
    }
}