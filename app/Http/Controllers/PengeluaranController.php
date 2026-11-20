<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    /**
     * Daftar pengeluaran operasional (P-13 - Read)
     */
    public function index(Request $request)
    {
        $q = $request->string('q')->trim()->toString();
        $kategori = $request->string('kategori')->trim()->toString();
        $startDate = $request->string('start_date')->trim()->toString();
        $endDate = $request->string('end_date')->trim()->toString();

        $query = Pengeluaran::query();

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('keterangan', 'like', "%{$q}%")
                    ->orWhere('kategori', 'like', "%{$q}%");
            });
        }

        if ($kategori !== '' && $kategori !== 'Semua') {
            $query->where('kategori', $kategori);
        }

        if ($startDate !== '') {
            $query->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate !== '') {
            $query->whereDate('tanggal', '<=', $endDate);
        }

        $pengeluaran = $query->orderBy('tanggal', 'desc')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        // Hitung total pengeluaran ringkas untuk kartu statistik
        $totalNominal = Pengeluaran::sum('nominal');
        $totalTransaksi = Pengeluaran::count();

        $daftarKategori = [
            'Operasional Kantor',
            'BBM & Transportasi',
            'Pemeliharaan & Servis',
            'Konsumsi Kegiatan',
            'Peralatan & ATK',
            'Lainnya'
        ];

        return view('admin.pengeluaran.index', compact(
            'pengeluaran',
            'q',
            'kategori',
            'startDate',
            'endDate',
            'totalNominal',
            'totalTransaksi',
            'daftarKategori'
        ));
    }

    /**
     * Form tambah pengeluaran (P-13 - Create)
     */
    public function create()
    {
        $daftarKategori = [
            'Operasional Kantor',
            'BBM & Transportasi',
            'Pemeliharaan & Servis',
            'Konsumsi Kegiatan',
            'Peralatan & ATK',
            'Lainnya'
        ];

        $pengeluaran = new Pengeluaran([
            'tanggal' => now()->format('Y-m-d')
        ]);

        return view('admin.pengeluaran.form', [
            'pengeluaran' => $pengeluaran,
            'isEdit' => false,
            'daftarKategori' => $daftarKategori
        ]);
    }

    /**
     * Simpan data pengeluaran baru (P-13 - Create)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'kategori' => ['required', 'string', 'max:100'],
            'nominal' => ['required', 'numeric', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        Pengeluaran::create($data);

        return redirect()
            ->route('admin.pengeluaran.index')
            ->with('success', 'Data pengeluaran operasional berhasil dicatat.');
    }

    /**
     * Tampilkan detail pengeluaran (P-13 - Read detail)
     */
    public function show(Pengeluaran $pengeluaran)
    {
        return view('admin.pengeluaran.show', compact('pengeluaran'));
    }

    /**
     * Form ubah data pengeluaran (P-13 - Update)
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        $daftarKategori = [
            'Operasional Kantor',
            'BBM & Transportasi',
            'Pemeliharaan & Servis',
            'Konsumsi Kegiatan',
            'Peralatan & ATK',
            'Lainnya'
        ];

        return view('admin.pengeluaran.form', [
            'pengeluaran' => $pengeluaran,
            'isEdit' => true,
            'daftarKategori' => $daftarKategori
        ]);
    }

    /**
     * Perbarui data pengeluaran (P-13 - Update)
     */
    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'kategori' => ['required', 'string', 'max:100'],
            'nominal' => ['required', 'numeric', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        $pengeluaran->update($data);

        return redirect()
            ->route('admin.pengeluaran.show', $pengeluaran)
            ->with('success', 'Data pengeluaran operasional berhasil diperbarui.');
    }

    /**
     * Hapus data pengeluaran (P-13 - Delete)
     */
    public function destroy(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();

        return redirect()
            ->route('admin.pengeluaran.index')
            ->with('success', 'Data pengeluaran operasional berhasil dihapus.');
    }
}
