<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Daftar pengumuman (P-14 - Read)
     */
    public function index(Request $request)
    {
        $q = $request->string('q')->trim()->toString();
        $status = $request->string('status')->trim()->toString();

        $query = Pengumuman::query();

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('isi', 'like', "%{$q}%");
            });
        }

        if ($status === 'tayang') {
            $query->whereDate('tanggal_tayang', '<=', now()->toDateString());
        } elseif ($status === 'terjadwal') {
            $query->whereDate('tanggal_tayang', '>', now()->toDateString());
        }

        $pengumuman = $query->orderBy('tanggal_tayang', 'desc')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $totalPengumuman = Pengumuman::count();
        $totalTayang = Pengumuman::whereDate('tanggal_tayang', '<=', now()->toDateString())->count();
        $totalTerjadwal = Pengumuman::whereDate('tanggal_tayang', '>', now()->toDateString())->count();

        return view('admin.pengumuman.index', compact(
            'pengumuman',
            'q',
            'status',
            'totalPengumuman',
            'totalTayang',
            'totalTerjadwal'
        ));
    }

    /**
     * Form buat pengumuman baru (P-14 - Create)
     */
    public function create()
    {
        $pengumuman = new Pengumuman([
            'tanggal_tayang' => now()->format('Y-m-d')
        ]);

        return view('admin.pengumuman.form', [
            'pengumuman' => $pengumuman,
            'isEdit' => false
        ]);
    }

    /**
     * Simpan pengumuman baru (P-14 - Create)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'tanggal_tayang' => ['required', 'date'],
            'isi' => ['required', 'string', 'max:3000'],
        ]);

        Pengumuman::create($data);

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diterbitkan.');
    }

    /**
     * Tampilkan detail pengumuman (P-14 - Read detail)
     */
    public function show(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.show', compact('pengumuman'));
    }

    /**
     * Form edit pengumuman (P-14 - Update)
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.form', [
            'pengumuman' => $pengumuman,
            'isEdit' => true
        ]);
    }

    /**
     * Perbarui pengumuman (P-14 - Update)
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'tanggal_tayang' => ['required', 'date'],
            'isi' => ['required', 'string', 'max:3000'],
        ]);

        $pengumuman->update($data);

        return redirect()
            ->route('admin.pengumuman.show', $pengumuman)
            ->with('success', 'Data pengumuman berhasil diperbarui.');
    }

    /**
     * Hapus pengumuman (P-14 - Delete)
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    /**
     * Tampilan pengumuman untuk Nasabah / Publik (hanya yang sudah tayang)
     */
    public function publicIndex(Request $request)
    {
        $q = $request->string('q')->trim()->toString();

        $query = Pengumuman::query()
            ->whereDate('tanggal_tayang', '<=', now()->toDateString());

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('isi', 'like', "%{$q}%");
            });
        }

        $pengumuman = $query->orderBy('tanggal_tayang', 'desc')
            ->paginate(9)
            ->withQueryString();

        return view('pengumuman.index', compact('pengumuman', 'q'));
    }

    /**
     * Detail pengumuman untuk Nasabah / Publik
     */
    public function publicShow(Pengumuman $pengumuman)
    {
        return view('pengumuman.show', compact('pengumuman'));
    }
}
