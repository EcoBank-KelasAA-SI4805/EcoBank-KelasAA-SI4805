<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// P-10 CRUD Wilayah/RW
class WilayahController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->trim()->toString();
        $wilayah = Wilayah::query()->withCount('nasabah')
            ->when($q, fn ($query) => $query->where(fn ($w) => $w->where('nama_rw', 'like', "%{$q}%")->orWhere('kelurahan', 'like', "%{$q}%")))
            ->orderBy('nama_rw')->paginate(10)->withQueryString();
        return view('admin.wilayah.index', compact('wilayah', 'q'));
    }

    public function create()
    {
        return view('admin.wilayah.form', ['wilayah' => new Wilayah(), 'isEdit' => false]);
    }

    public function store(Request $request)
    {
        Wilayah::create($this->validated($request));
        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah berhasil ditambahkan.');
    }

    public function show(Wilayah $wilayah)
    {
        $wilayah->loadCount(['nasabah', 'jadwal']);
        return view('admin.wilayah.show', compact('wilayah'));
    }

    public function edit(Wilayah $wilayah)
    {
        return view('admin.wilayah.form', ['wilayah' => $wilayah, 'isEdit' => true]);
    }

    public function update(Request $request, Wilayah $wilayah)
    {
        $wilayah->update($this->validated($request, $wilayah));
        return redirect()->route('admin.wilayah.show', $wilayah)->with('success', 'Data wilayah berhasil diperbarui.');
    }

    public function destroy(Wilayah $wilayah)
    {
        if ($wilayah->nasabah()->exists()) {
            return back()->with('error', 'Wilayah tidak dapat dihapus karena masih memiliki nasabah.');
        }
        if ($wilayah->jadwal()->exists()) {
            return back()->with('error', 'Wilayah tidak dapat dihapus karena masih dipakai pada jadwal pengumpulan.');
        }
        $wilayah->delete();
        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah berhasil dihapus.');
    }

    private function validated(Request $request, ?Wilayah $wilayah = null): array
    {
        return $request->validate([
            'nama_rw' => ['required', 'string', 'max:100', Rule::unique('wilayah', 'nama_rw')->ignore($wilayah?->id)],
            'kelurahan' => ['required', 'string', 'max:100'],
        ]);
    }
}
