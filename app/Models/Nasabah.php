<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Nasabah extends Authenticatable
{
    protected $table = 'nasabah';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'status',
        'nik',
        'alamat',
        'no_hp',
        'rw',
        'saldo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'saldo' => 'decimal:2',
    ];

    public function isAdmin(): bool
    {
        return strcasecmp($this->role ?? '', 'Admin') === 0;
    }

    public function isPetugas(): bool
    {
        return strcasecmp($this->role ?? '', 'Petugas') === 0;
    }

    public function isNasabah(): bool
    {
        return strcasecmp($this->role ?? '', 'Nasabah') === 0;
    }

    public function isActive(): bool
    {
        return strcasecmp($this->status ?? '', 'Aktif') === 0;
    }

    /**
     * Alias accessor untuk $nasabah->name <-> $nasabah->nama
     */
    public function getNameAttribute(): ?string
    {
        return $this->attributes['nama'] ?? null;
    }

    public function setNameAttribute($value): void
    {
        $this->attributes['nama'] = $value;
    }
}
