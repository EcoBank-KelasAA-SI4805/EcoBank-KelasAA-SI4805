<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class KendaraanPengangkut extends Model
{
    protected $table = 'kendaraan_pengangkut';
    protected $fillable = ['nama','nomor_polisi','jenis','status'];
}
