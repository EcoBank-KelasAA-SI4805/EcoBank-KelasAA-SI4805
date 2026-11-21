<?php

namespace App\Http\Controllers;

use App\Http\Requests\JenisResiduRequest;
use App\Models\JenisResidu;
use Illuminate\Http\Request;

class JenisResiduController extends Controller
{
    public function index(Request $request)
    {
        $query = JenisResidu::query();

        if ($request->filled('cara_penanganan')) {
            $query->where('cara_penanganan', $request->cara_penanganan);
        }

        $jenisResidu = $query->paginate(10)->withQueryString();

        return view('jenis_residu.index', compact('jenisResidu'));
    }

    public function create()
    {
        return view('jenis_residu.create');
    }

    public function store(JenisResiduRequest $request)
    {
        JenisResidu::create($request->validated());

        return redirect()->route('jenis-residu.index')
            ->with('success', 'Jenis residu berhasil ditambahkan.');
    }

    public function show(JenisResidu $jenisResidu)
    {
        return view('jenis_residu.show', compact('jenisResidu'));
    }

    public function edit(JenisResidu $jenisResidu)
    {
        return view('jenis_residu.edit', compact('jenisResidu'));
    }

    public function update(JenisResiduRequest $request, JenisResidu $jenisResidu)
    {
        $jenisResidu->update($request->validated());

        return redirect()->route('jenis-residu.index')
            ->with('success', 'Jenis residu berhasil diperbarui.');
    }

    public function destroy(JenisResidu $jenisResidu)
    {
        if ($jenisResidu->isUsed()) {
            return redirect()->route('jenis-residu.index')
                ->with('error', 'Jenis residu tidak dapat dihapus karena sudah digunakan pada data residu.');
        }

        $jenisResidu->delete();

        return redirect()->route('jenis-residu.index')
            ->with('success', 'Jenis residu berhasil dihapus.');
    }
}
