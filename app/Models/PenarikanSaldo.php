<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenarikanSaldo extends Model
{
    protected $table = 'penarikan_saldo';

    protected $fillable = [
        'nasabah_id',
        'metode_penarikan_id',
        'jumlah',
        'status',
        'catatan',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class);
    }

    public function metodePenarikan(): BelongsTo
    {
        return $this->belongsTo(MetodePenarikan::class, 'metode_penarikan_id');
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'diajukan'  => 'Diajukan',
            'disetujui' => 'Disetujui',
            'ditolak'   => 'Ditolak',
            'selesai'   => 'Selesai',
            default     => ucfirst($this->status),
        };
    }

    public function statusClass(): string
    {
        return match($this->status) {
            'diajukan'  => 'pending',
            'disetujui' => 'info',
            'ditolak'   => 'danger',
            'selesai'   => 'success',
            default     => '',
        };
    }

    public function bisaDibatalkan(): bool
    {
        return $this->status === 'diajukan';
    }
}
