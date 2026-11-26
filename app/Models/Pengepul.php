<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengepul extends Model
{
    protected $table = 'pengepul';

    protected $fillable = [
        'nama',
        'kontak',
        'alamat',
        'jenis_dibeli'
    ];
}
