<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use App\Models\RiwayatHarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * P-03 (bagian 2) — Harga Sampah (FR-08, FR-09, UC-04, UC-11 langkah 7-10).
 */
class HargaSampahController extends Controller
{
    /** Daftar harga terbaru, read-only untuk semua peran (FR-09). */
    public function index(Request $request)
    {
        $q = $request->string('q')->trim()->toString();

        $jenis = JenisSampah::query()
            ->aktif()
            ->withMax('riwayatHarga as harga_diperbarui_pada', 'diubah_pada')
            ->when($q, fn ($query) => $query->where('nama_jenis', 'like', "%{$q}%"))
            ->orderBy('nama_jenis')
            ->get();

        return view('admin.harga.index', compact('jenis', 'q'));
    }

    public function edit(JenisSampah $jenisSampah)
    {
        return view('admin.harga.edit', ['jenis' => $jenisSampah]);
    }

    public function update(Request $request, JenisSampah $jenisSampah)
    {
        $data = $request->validate([
            'harga_baru' => ['required', 'numeric', 'gt:0', 'max:9999999999'],
        ], [
            'harga_baru.required' => 'Harga baru wajib diisi.',
            'harga_baru.numeric' => 'Harga baru harus berupa angka.',
            'harga_baru.gt' => 'Harga baru harus lebih dari 0.',
            'harga_baru.max' => 'Harga baru terlalu besar.',
        ]);

        $hargaLama = $jenisSampah->harga_per_kg;

        if ((float) $hargaLama === (float) $data['harga_baru']) {
            return back()->withInput()->withErrors(['harga_baru' => 'Harga baru sama dengan harga saat ini.']);
        }

        DB::transaction(function () use ($jenisSampah, $data, $hargaLama) {
            $jenisSampah->update(['harga_per_kg' => $data['harga_baru']]);

            RiwayatHarga::create([
                'jenis_sampah_id' => $jenisSampah->id,
                'harga_lama' => $hargaLama,
                'harga_baru' => $data['harga_baru'],
                'diubah_oleh' => Auth::id(),
            ]);
        });

        // Setoran lama tidak berubah: nanti detail_setoran menyalin harga saat transaksi.
        return redirect()->route('admin.jenis-sampah.show', $jenisSampah)
            ->with('success', 'Harga berhasil diperbarui dan berlaku untuk setoran berikutnya.');
    }
}
