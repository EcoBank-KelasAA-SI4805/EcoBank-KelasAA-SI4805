<?php

namespace App\Models;
use App\Models\Nasabah;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['nasabah_id', 'kode_transaksi', 'jenis', 'nominal'];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'nasabah_id');
    }
}
