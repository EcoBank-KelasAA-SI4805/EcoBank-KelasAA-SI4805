<?php

namespace App\Http\Controllers;

use App\Http\Requests\KegiatanRequest;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $kegiatan = Kegiatan::withCount([
            'peserta',
            'peserta as hadir_count' => fn ($q) => $q->where('hadir', true),
        ])
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        return view('kegiatan.create');
    }

    public function store(KegiatanRequest $request)
    {
        $data = $request->validated();
        $data['status'] = 'dijadwalkan';

        Kegiatan::create($data);

        return redirect()->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function show(Kegiatan $kegiatan)
    {
        $kegiatan->loadCount([
            'peserta',
            'peserta as hadir_count' => fn ($q) => $q->where('hadir', true),
        ]);

        $pesertaList = $kegiatan->peserta()->with('nasabah')->get();

        // Nasabah yang belum terdaftar di kegiatan ini
        $terdaftarIds = $pesertaList->pluck('id_nasabah');
        $nasabahList = \App\Models\Nasabah::whereNotIn('id', $terdaftarIds)
            ->orderBy('nama')
            ->get();

        return view('kegiatan.show', compact('kegiatan', 'pesertaList', 'nasabahList'));
    }

    public function edit(Kegiatan $kegiatan)
    {
        return view('kegiatan.edit', compact('kegiatan'));
    }

    public function update(KegiatanRequest $request, Kegiatan $kegiatan)
    {
        $kegiatan->update($request->validated());

        return redirect()->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $jumlahPeserta = $kegiatan->peserta()->count();

        $kegiatan->delete(); // cascade deletes peserta

        $pesan = $jumlahPeserta > 0
            ? "Kegiatan berhasil dihapus beserta {$jumlahPeserta} peserta."
            : 'Kegiatan berhasil dihapus.';

        return redirect()->route('kegiatan.index')
            ->with('success', $pesan);
    }
}
