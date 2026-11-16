<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NasabahController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->trim()->toString();
        $nasabah = Nasabah::query()->when($q, fn ($query) => $query->where('nama', 'like', "%{$q}%")
            ->orWhere('nik', 'like', "%{$q}%")
            ->orWhere('no_hp', 'like', "%{$q}%"))
            ->latest()->paginate(10)->withQueryString();
        return view('admin.nasabah.index', compact('nasabah', 'q'));
    }

    public function create() { return view('admin.nasabah.form', ['nasabah' => new Nasabah(), 'isEdit' => false]); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required','string','max:100'], 'nik' => ['required','digits:16','unique:nasabah,nik'],
            'alamat' => ['required','string','max:500'], 'no_hp' => ['required','string','max:20'],
            'rw' => ['required','string','max:10'],
        ]);
        $data['saldo'] = 0;
        Nasabah::create($data);
        return redirect()->route('admin.nasabah.index')->with('success', 'Data nasabah berhasil ditambahkan.');
    }

    public function show(Nasabah $nasabah) { return view('admin.nasabah.show', compact('nasabah')); }
    public function edit(Nasabah $nasabah) { return view('admin.nasabah.form', ['nasabah' => $nasabah, 'isEdit' => true]); }

    public function update(Request $request, Nasabah $nasabah)
    {
        $data = $request->validate([
            'nama' => ['required','string','max:100'], 'nik' => ['required','digits:16',Rule::unique('nasabah','nik')->ignore($nasabah->id)],
            'alamat' => ['required','string','max:500'], 'no_hp' => ['required','string','max:20'], 'rw' => ['required','string','max:10'],
        ]);
        $nasabah->update($data);
        return redirect()->route('admin.nasabah.show', $nasabah)->with('success', 'Data nasabah berhasil diperbarui.');
    }

    public function destroy(Nasabah $nasabah)
    {
        if ($nasabah->transactions()->exists()) {
            return back()->with('error', 'Nasabah tidak dapat dihapus karena sudah memiliki transaksi.');
        }
        $nasabah->delete();
        return redirect()->route('admin.nasabah.index')->with('success', 'Data nasabah berhasil dihapus.');
    }
}
