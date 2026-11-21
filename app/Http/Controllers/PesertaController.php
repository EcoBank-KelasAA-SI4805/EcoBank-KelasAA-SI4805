<?php

namespace App\Http\Controllers;

use App\Http\Requests\PesertaRequest;
use App\Models\Kegiatan;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesertaController extends Controller
{
    public function store(PesertaRequest $request, Kegiatan $kegiatan)
    {
        // Cek status kegiatan
        if (! $kegiatan->isDijadwalkan()) {
            return back()->with('error', 'Pendaftaran peserta hanya bisa dilakukan untuk kegiatan berstatus "dijadwalkan".');
        }

        $idNasabah = $request->validated()['id_nasabah'];

        try {
            DB::transaction(function () use ($kegiatan, $idNasabah) {
                // Lock baris kegiatan untuk cek kuota aman dari race condition
                $kegiatan = Kegiatan::lockForUpdate()->findOrFail($kegiatan->id);

                $jumlahPeserta = $kegiatan->peserta()->count();

                if ($jumlahPeserta >= $kegiatan->kuota) {
                    throw new \RuntimeException('kuota_penuh');
                }

                // Cek duplikat
                $sudahAda = $kegiatan->peserta()
                    ->where('id_nasabah', $idNasabah)
                    ->exists();

                if ($sudahAda) {
                    throw new \RuntimeException('sudah_terdaftar');
                }

                Peserta::create([
                    'id_kegiatan' => $kegiatan->id,
                    'id_nasabah'  => $idNasabah,
                    'hadir'       => false,
                ]);
            });
        } catch (\RuntimeException $e) {
            $pesan = match ($e->getMessage()) {
                'kuota_penuh'      => 'Pendaftaran gagal: kuota penuh.',
                'sudah_terdaftar'  => 'Nasabah ini sudah terdaftar di kegiatan yang sama.',
                default            => 'Terjadi kesalahan saat mendaftarkan peserta.',
            };

            return back()->with('error', $pesan);
        }

        return back()->with('success', 'Peserta berhasil didaftarkan.');
    }

    public function updateHadir(Peserta $peserta)
    {
        if ($peserta->kegiatan->isBatalkan()) {
            return back()->with('error', 'Kehadiran tidak dapat diubah karena kegiatan sudah dibatalkan.');
        }

        $peserta->update(['hadir' => ! $peserta->hadir]);

        $status = $peserta->hadir ? 'hadir' : 'tidak hadir';

        return back()->with('success', "Status kehadiran peserta diubah menjadi \"{$status}\".");
    }

    public function destroy(Peserta $peserta)
    {
        $peserta->delete();

        return back()->with('success', 'Peserta berhasil dikeluarkan dari kegiatan.');
    }
}
