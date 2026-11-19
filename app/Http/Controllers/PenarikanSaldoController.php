<?php

namespace App\Http\Controllers;

use App\Models\MetodePenarikan;
use App\Models\Nasabah;
use App\Models\PenarikanSaldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * P-16: CRUD Penarikan Saldo
 * Gracia Gebriella Sianturi – 102022400331
 */
class PenarikanSaldoController extends Controller
{
    // R: Daftar penarikan + filter status
    public function index(Request $request)
    {
        $status = $request->input('status', '');
        $q      = $request->input('q', '');

        $penarikan = PenarikanSaldo::with(['nasabah', 'metodePenarikan'])
            ->when($status, fn($query) => $query->where('status', $status))
            ->when($q, fn($query) => $query->whereHas('nasabah', fn($q2) =>
                $q2->where('nama', 'like', "%{$q}%")->orWhere('nik', 'like', "%{$q}%")
            ))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.penarikan-saldo.index', compact('penarikan', 'status', 'q'));
    }

    // C: Form ajukan penarikan
    public function create()
    {
        $nasabahList = Nasabah::orderBy('nama')->get();
        $metodeList  = MetodePenarikan::where('status_aktif', true)->orderBy('nama_metode')->get();
        return view('admin.penarikan-saldo.form', [
            'isEdit'      => false,
            'penarikan'   => new PenarikanSaldo(),
            'nasabahList' => $nasabahList,
            'metodeList'  => $metodeList,
        ]);
    }

    // C: Simpan pengajuan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nasabah_id'          => 'required|exists:nasabah,id',
            'metode_penarikan_id' => 'required|exists:metode_penarikans,id',
            'jumlah'              => 'required|numeric|min:1',
            'catatan'             => 'nullable|string|max:500',
        ]);

        $nasabah = Nasabah::findOrFail($validated['nasabah_id']);
        $metode  = MetodePenarikan::findOrFail($validated['metode_penarikan_id']);

        // Validasi saldo cukup
        if ($nasabah->saldo < $validated['jumlah']) {
            return back()->withInput()
                ->withErrors(['jumlah' => 'Saldo nasabah tidak mencukupi (saldo: Rp ' . number_format($nasabah->saldo, 0, ',', '.') . ').']);
        }

        // Validasi minimal penarikan
        if ($validated['jumlah'] < $metode->minimal_tarik) {
            return back()->withInput()
                ->withErrors(['jumlah' => 'Jumlah penarikan kurang dari minimal Rp ' . number_format($metode->minimal_tarik, 0, ',', '.') . '.']);
        }

        PenarikanSaldo::create($validated + ['status' => 'diajukan']);

        return redirect()->route('admin.penarikan-saldo.index')
            ->with('success', 'Pengajuan penarikan berhasil dibuat.');
    }

    // R: Detail penarikan
    public function show(PenarikanSaldo $penarikanSaldo)
    {
        $penarikanSaldo->load(['nasabah', 'metodePenarikan']);
        return view('admin.penarikan-saldo.show', compact('penarikanSaldo'));
    }

    // U: Form ubah status (petugas)
    public function edit(PenarikanSaldo $penarikanSaldo)
    {
        $penarikanSaldo->load(['nasabah', 'metodePenarikan']);
        return view('admin.penarikan-saldo.update-status', compact('penarikanSaldo'));
    }

    // U: Simpan perubahan status
    public function update(Request $request, PenarikanSaldo $penarikanSaldo)
    {
        $validated = $request->validate([
            'status'  => 'required|in:diajukan,disetujui,ditolak,selesai',
            'catatan' => 'nullable|string|max:500',
        ]);

        // Jika status selesai → kurangi saldo nasabah
        if ($validated['status'] === 'selesai' && $penarikanSaldo->status !== 'selesai') {
            DB::transaction(function () use ($penarikanSaldo, $validated) {
                $nasabah = $penarikanSaldo->nasabah;
                if ($nasabah->saldo < $penarikanSaldo->jumlah) {
                    throw new \Exception('Saldo nasabah tidak mencukupi.');
                }
                $nasabah->decrement('saldo', $penarikanSaldo->jumlah);
                $penarikanSaldo->update($validated);
            });
        } else {
            $penarikanSaldo->update($validated);
        }

        return redirect()->route('admin.penarikan-saldo.show', $penarikanSaldo)
            ->with('success', 'Status penarikan berhasil diperbarui.');
    }

    // D: Batalkan pengajuan (hanya jika status = diajukan)
    public function destroy(PenarikanSaldo $penarikanSaldo)
    {
        if (!$penarikanSaldo->bisaDibatalkan()) {
            return back()->with('error', 'Hanya pengajuan dengan status "Diajukan" yang dapat dibatalkan.');
        }

        $penarikanSaldo->delete();

        return redirect()->route('admin.penarikan-saldo.index')
            ->with('success', 'Pengajuan penarikan berhasil dibatalkan.');
    }
}
