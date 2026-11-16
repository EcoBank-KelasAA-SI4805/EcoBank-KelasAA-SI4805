<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropPoint extends Model
{
    protected $fillable = ['nama', 'alamat', 'jam_buka', 'status_aktif'];
    protected $casts = ['status_aktif' => 'boolean'];
}
