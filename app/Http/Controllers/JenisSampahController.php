<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use App\Models\RiwayatHarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * P-03 (bagian 1) — Katalog Jenis Sampah (FR-07, UC-11).
 * Harga diubah lewat HargaSampahController, bukan di form edit.
 */
class JenisSampahController extends Controller
{
    private const MESSAGES = [
        'nama_jenis.required' => 'Nama jenis sampah wajib diisi.',
        'nama_jenis.unique' => 'Nama jenis sampah sudah ada di katalog.',
        'nama_jenis.max' => 'Nama jenis sampah maksimal 100 karakter.',
        'kategori.required' => 'Kategori wajib dipilih.',
        'kategori.in' => 'Kategori tidak valid.',
        'harga_awal.required' => 'Harga awal wajib diisi.',
        'harga_awal.numeric' => 'Harga awal harus berupa angka.',
        'harga_awal.gt' => 'Harga awal harus lebih dari 0.',
        'harga_awal.max' => 'Harga awal terlalu besar.',
    ];

    public function index(Request $request)
    {
        $q = $request->string('q')->trim()->toString();
        $status = $request->string('status')->toString(); // '', 'aktif', 'nonaktif'

        $jenis = JenisSampah::query()
            ->when($q, fn ($query) => $query->where(fn ($w) => $w
                ->where('nama_jenis', 'like', "%{$q}%")
                ->orWhere('kategori', 'like', "%{$q}%")))
            ->when($status === 'aktif', fn ($query) => $query->where('status_aktif', true))
            ->when($status === 'nonaktif', fn ($query) => $query->where('status_aktif', false))
            ->orderBy('nama_jenis')
            ->paginate(10)
            ->withQueryString();

        return view('admin.jenis-sampah.index', compact('jenis', 'q', 'status'));
    }

    public function create()
    {
        return view('admin.jenis-sampah.form', ['jenis' => new JenisSampah(['status_aktif' => true]), 'isEdit' => false]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_jenis' => ['required', 'string', 'max:100', 'unique:jenis_sampah,nama_jenis'],
            'kategori' => ['required', Rule::in(JenisSampah::KATEGORI)],
            'harga_awal' => ['required', 'numeric', 'gt:0', 'max:9999999999'],
        ], self::MESSAGES);

        DB::transaction(function () use ($data, $request) {
            $jenis = JenisSampah::create([
                'nama_jenis' => trim($data['nama_jenis']),
                'kategori' => $data['kategori'],
                'satuan' => 'kg',
                'harga_per_kg' => $data['harga_awal'],
                'status_aktif' => $request->boolean('status_aktif', true),
            ]);

            // Harga awal ikut dicatat supaya riwayat harga lengkap dari awal.
            RiwayatHarga::create([
                'jenis_sampah_id' => $jenis->id,
                'harga_lama' => null,
                'harga_baru' => $data['harga_awal'],
                'diubah_oleh' => Auth::id(),
            ]);
        });

        return redirect()->route('admin.jenis-sampah.index')->with('success', 'Jenis sampah berhasil ditambahkan.');
    }

    public function show(JenisSampah $jenisSampah)
    {
        $riwayat = $jenisSampah->riwayatHarga()->orderByDesc('diubah_pada')->orderByDesc('id')->get();
        return view('admin.jenis-sampah.show', ['jenis' => $jenisSampah, 'riwayat' => $riwayat]);
    }

    public function edit(JenisSampah $jenisSampah)
    {
        return view('admin.jenis-sampah.form', ['jenis' => $jenisSampah, 'isEdit' => true]);
    }

    public function update(Request $request, JenisSampah $jenisSampah)
    {
        // Form edit tidak memuat harga (UC-11 langkah 4); harga lewat "Ubah Harga".
        $data = $request->validate([
            'nama_jenis' => ['required', 'string', 'max:100', Rule::unique('jenis_sampah', 'nama_jenis')->ignore($jenisSampah->id)],
            'kategori' => ['required', Rule::in(JenisSampah::KATEGORI)],
        ], self::MESSAGES);

        $jenisSampah->update([
            'nama_jenis' => trim($data['nama_jenis']),
            'kategori' => $data['kategori'],
            'status_aktif' => $request->boolean('status_aktif'),
        ]);

        return redirect()->route('admin.jenis-sampah.show', $jenisSampah)->with('success', 'Data jenis sampah berhasil diperbarui.');
    }

    /** Nonaktifkan / aktifkan kembali (F-03.4). Riwayat setoran tetap utuh. */
    public function toggleStatus(JenisSampah $jenisSampah)
    {
        $jenisSampah->update(['status_aktif' => ! $jenisSampah->status_aktif]);

        $pesan = $jenisSampah->status_aktif
            ? "Jenis \"{$jenisSampah->nama_jenis}\" diaktifkan kembali."
            : "Jenis \"{$jenisSampah->nama_jenis}\" dinonaktifkan dan tidak muncul di pilihan setoran.";

        return back()->with('success', $pesan);
    }

    public function destroy(JenisSampah $jenisSampah)
    {
        if ($jenisSampah->sudahDipakai()) {
            return back()->with('error', 'Jenis sampah tidak dapat dihapus karena sudah dipakai pada setoran. Nonaktifkan saja.');
        }

        $jenisSampah->delete(); // riwayat_harga ikut terhapus (cascade)
        return redirect()->route('admin.jenis-sampah.index')->with('success', 'Jenis sampah berhasil dihapus.');
    }
}
