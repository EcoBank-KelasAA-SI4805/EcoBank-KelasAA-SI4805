<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KegiatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kegiatan = $this->route('kegiatan');

        $kuotaMin = 1;
        if ($kegiatan) {
            // Kuota tidak boleh lebih kecil dari jumlah peserta terdaftar
            $jumlahPeserta = $kegiatan->peserta()->count();
            $kuotaMin = max(1, $jumlahPeserta);
        }

        return [
            'judul'   => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'lokasi'  => ['required', 'string', 'max:255'],
            'kuota'   => ['required', 'integer', "min:{$kuotaMin}"],
            'status'  => ['sometimes', Rule::in(['dijadwalkan', 'selesai', 'dibatalkan'])],
        ];
    }

    public function messages(): array
    {
        $kegiatan = $this->route('kegiatan');
        $jumlahPeserta = $kegiatan ? $kegiatan->peserta()->count() : 0;

        return [
            'judul.required'   => 'Judul kegiatan wajib diisi.',
            'tanggal.required' => 'Tanggal kegiatan wajib diisi.',
            'tanggal.date'     => 'Format tanggal tidak valid.',
            'lokasi.required'  => 'Lokasi kegiatan wajib diisi.',
            'kuota.required'   => 'Kuota wajib diisi.',
            'kuota.integer'    => 'Kuota harus berupa bilangan bulat.',
            'kuota.min'        => $jumlahPeserta > 1
                ? "Kuota tidak boleh lebih kecil dari jumlah peserta terdaftar ({$jumlahPeserta} peserta)."
                : 'Kuota minimal 1.',
            'status.in'        => 'Status tidak valid.',
        ];
    }
}
