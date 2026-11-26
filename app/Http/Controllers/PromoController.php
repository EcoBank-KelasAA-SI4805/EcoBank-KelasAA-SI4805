<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\JenisSampah;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    // Menampilkan daftar promo
    public function index()
    {
        $promos = Promo::with('jenisSampah')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.promo.index', compact('promos'));
    }

    // Menampilkan form tambah promo
    public function create()
    {
        $jenisSampah = JenisSampah::orderBy('nama_jenis')->get();

        return view('admin.promo.create', compact('jenisSampah'));
    }

    // Menyimpan promo baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'id_jenis' => 'required|exists:jenis_sampah,id',
            'tipe_bonus' => 'required|in:persen,rupiah',
            'nilai_bonus' => 'required|numeric|min:0.01',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ], [
            'nama.required' => 'Nama promo wajib diisi.',
            'id_jenis.required' => 'Jenis sampah wajib dipilih.',
            'id_jenis.exists' => 'Jenis sampah tidak ditemukan.',
            'tipe_bonus.required' => 'Tipe bonus wajib dipilih.',
            'tipe_bonus.in' => 'Tipe bonus harus persen atau rupiah.',
            'nilai_bonus.required' => 'Nilai bonus wajib diisi.',
            'nilai_bonus.numeric' => 'Nilai bonus harus berupa angka.',
            'nilai_bonus.min' => 'Nilai bonus harus lebih dari 0.',
            'tgl_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tgl_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tgl_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        ]);

        Promo::create($validated);

        return redirect()->route('admin.promo.index')
            ->with('success', 'Promo berhasil ditambahkan.');
    }

    // Menampilkan detail promo
    public function show(Promo $promo)
    {
        $promo->load('jenisSampah');

        return view('admin.promo.show', compact('promo'));
    }

    // Menampilkan form edit promo
    public function edit(Promo $promo)
    {
        $jenisSampah = JenisSampah::orderBy('nama_jenis')->get();

        return view('admin.promo.edit', compact('promo', 'jenisSampah'));
    }

    // Memperbarui promo
    public function update(Request $request, Promo $promo)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'id_jenis' => 'required|exists:jenis_sampah,id',
            'tipe_bonus' => 'required|in:persen,rupiah',
            'nilai_bonus' => 'required|numeric|min:0.01',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        $promo->update($validated);

        return redirect()->route('admin.promo.index')
            ->with('success', 'Promo berhasil diperbarui.');
    }

    // Menghapus promo
    public function destroy(Promo $promo)
    {
        $promo->delete();

        return redirect()->route('admin.promo.index')
            ->with('success', 'Promo berhasil dihapus.');
    }
}
