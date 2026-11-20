<?php

namespace App\Http\Controllers;

use App\Models\MetodePenarikan;
use Illuminate\Http\Request;

class MetodePenarikanController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->trim()->toString();
        $metodeList = MetodePenarikan::query()
            ->when($q, fn ($query) => $query->where('nama_metode', 'like', "%{$q}%")->orWhere('kategori', 'like', "%{$q}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.metode-penarikan.index', compact('metodeList', 'q'));
    }

    public function create()
    {
        return view('admin.metode-penarikan.form', [
            'metode' => new MetodePenarikan(),
            'isEdit' => false
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_metode' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'in:transfer,ewallet,tunai'],
            'minimal_tarik' => ['required', 'numeric', 'min:0'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ]);

        $data['status_aktif'] = $request->boolean('status_aktif', true);

        MetodePenarikan::create($data);

        return redirect()->route('admin.metode-penarikan.index')
            ->with('success', 'Metode penarikan berhasil ditambahkan.');
    }

    public function show(MetodePenarikan $metodePenarikan)
    {
        return view('admin.metode-penarikan.show', ['metode' => $metodePenarikan]);
    }

    public function edit(MetodePenarikan $metodePenarikan)
    {
        return view('admin.metode-penarikan.form', [
            'metode' => $metodePenarikan,
            'isEdit' => true
        ]);
    }

    public function update(Request $request, MetodePenarikan $metodePenarikan)
    {
        $data = $request->validate([
            'nama_metode' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'in:transfer,ewallet,tunai'],
            'minimal_tarik' => ['required', 'numeric', 'min:0'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ]);

        $data['status_aktif'] = $request->boolean('status_aktif');

        $metodePenarikan->update($data);

        return redirect()->route('admin.metode-penarikan.show', $metodePenarikan)
            ->with('success', 'Data metode penarikan berhasil diperbarui.');
    }

    public function destroy(MetodePenarikan $metodePenarikan)
    {
        $metodePenarikan->delete();

        return redirect()->route('admin.metode-penarikan.index')
            ->with('success', 'Metode penarikan berhasil dihapus.');
    }
}
