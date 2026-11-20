<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\Request;

// P-09 CRUD Jadwal Pengumpulan
class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->input('dari');
        $sampai = $request->input('sampai');
        $jadwal = Jadwal::query()->with(['wilayah', 'petugas'])
            ->when($dari, fn ($q) => $q->whereDate('tanggal', '>=', $dari))
            ->when($sampai, fn ($q) => $q->whereDate('tanggal', '<=', $sampai))
            ->orderByDesc('tanggal')->orderBy('jam')->paginate(10)->withQueryString();
        return view('admin.jadwal.index', compact('jadwal', 'dari', 'sampai'));
    }

    public function create()
    {
        return view('admin.jadwal.form', $this->formData(new Jadwal(), false));
    }

    public function store(Request $request)
    {
        Jadwal::create($this->validated($request));
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal pengumpulan berhasil dibuat.');
    }

    public function show(Jadwal $jadwal)
    {
        $jadwal->load(['wilayah', 'petugas']);
        return view('admin.jadwal.show', compact('jadwal'));
    }

    public function edit(Jadwal $jadwal)
    {
        return view('admin.jadwal.form', $this->formData($jadwal, true));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $jadwal->update($this->validated($request));
        return redirect()->route('admin.jadwal.show', $jadwal)->with('success', 'Jadwal pengumpulan berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal pengumpulan berhasil dibatalkan/dihapus.');
    }

    private function formData(Jadwal $jadwal, bool $isEdit): array
    {
        return [
            'jadwal' => $jadwal,
            'isEdit' => $isEdit,
            'wilayahList' => Wilayah::orderBy('nama_rw')->get(),
            // Petugas = pengguna berperan Petugas/Admin yang akunnya aktif.
            'petugasList' => User::whereRaw('LOWER(role) IN (?, ?)', ['petugas', 'admin'])
                ->whereRaw('LOWER(status) = ?', ['aktif'])->orderBy('name')->get(),
        ];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'tanggal' => ['required', 'date'],
            'jam' => ['required', 'date_format:H:i'],
            'wilayah_id' => ['required', 'exists:wilayah,id'],
            'petugas_id' => ['required', 'exists:users,id'],
        ], [
            'wilayah_id.required' => 'Wilayah wajib dipilih.',
            'petugas_id.required' => 'Petugas wajib dipilih.',
        ]);
    }
}
