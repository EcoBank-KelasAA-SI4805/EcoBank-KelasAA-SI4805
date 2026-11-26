<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResiduRequest;
use App\Models\JenisResidu;
use App\Models\Residu;
use Illuminate\Http\Request;

class ResiduController extends Controller
{
    public function index(Request $request)
    {
        $query = Residu::with('jenisResidu');

        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }
        if ($request->filled('id_jenis_residu')) {
            $query->where('id_jenis_residu', $request->id_jenis_residu);
        }

        $totalBerat = $query->sum('berat_kg');

        $residu = $query->latest('tanggal')->paginate(10)->withQueryString();
        $jenisResiduList = JenisResidu::orderBy('nama')->get();

        return view('residu.index', compact('residu', 'totalBerat', 'jenisResiduList'));
    }

    public function create()
    {
        $jenisResiduList = JenisResidu::orderBy('nama')->get();
        return view('residu.create', compact('jenisResiduList'));
    }

    public function store(ResiduRequest $request)
    {
        $jenis = JenisResidu::findOrFail($request->id_jenis_residu);
        $biayaPerKg = $jenis->biaya_per_kg;
        $totalBiaya = Residu::hitungTotalBiaya((float) $request->berat_kg, (float) $biayaPerKg);

        Residu::create(array_merge($request->validated(), [
            'biaya_per_kg' => $biayaPerKg,
            'total_biaya'  => $totalBiaya,
            'status'       => 'ditampung',
        ]));

        return redirect()->route('residu.index')
            ->with('success', 'Data residu berhasil dicatat.');
    }

    public function show(Residu $residu)
    {
        $residu->load('jenisResidu');
        return view('residu.show', compact('residu'));
    }

    public function edit(Residu $residu)
    {
        $jenisResiduList = JenisResidu::orderBy('nama')->get();
        return view('residu.edit', compact('residu', 'jenisResiduList'));
    }

    public function update(ResiduRequest $request, Residu $residu)
    {
        $jenis = JenisResidu::findOrFail($request->id_jenis_residu);
        $biayaPerKg = $jenis->biaya_per_kg;
        $totalBiaya = Residu::hitungTotalBiaya((float) $request->berat_kg, (float) $biayaPerKg);

        $residu->update(array_merge($request->validated(), [
            'biaya_per_kg' => $biayaPerKg,
            'total_biaya'  => $totalBiaya,
        ]));

        return redirect()->route('residu.index')
            ->with('success', 'Data residu berhasil diperbarui.');
    }

    public function destroy(Residu $residu)
    {
        if (!$residu->isDeletable()) {
            return redirect()->route('residu.index')
                ->with('error', 'Residu tidak dapat dihapus karena status sudah "' . $residu->status . '". Hanya residu berstatus "ditampung" yang dapat dihapus.');
        }

        $residu->delete();

        return redirect()->route('residu.index')
            ->with('success', 'Data residu berhasil dihapus.');
    }
}
