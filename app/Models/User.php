<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'role', 'status'];
    protected $hidden = ['password', 'remember_token'];

    public function isAdmin(): bool
    {
        return strcasecmp($this->role, 'Admin') === 0;
    }

    public function isPetugas(): bool
    {
        return strcasecmp($this->role, 'Petugas') === 0;
    }

    public function isNasabah(): bool
    {
        return strcasecmp($this->role, 'Nasabah') === 0;
    }

    public function isActive(): bool
    {
        return strcasecmp($this->status, 'Aktif') === 0;
    }
}
