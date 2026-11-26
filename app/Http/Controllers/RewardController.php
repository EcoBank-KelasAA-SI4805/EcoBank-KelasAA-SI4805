<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->trim()->toString();
        $rewards = Reward::query()
            ->when($q, fn ($query) => $query->where('nama_reward', 'like', "%{$q}%")->orWhere('deskripsi', 'like', "%{$q}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.rewards.index', compact('rewards', 'q'));
    }

    public function create()
    {
        return view('admin.rewards.form', [
            'reward' => new Reward(),
            'isEdit' => false
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_reward' => ['required', 'string', 'max:100'],
            'poin_harga' => ['required', 'integer', 'min:1'],
            'stok' => ['required', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ]);

        $data['status_aktif'] = $request->boolean('status_aktif', true);

        Reward::create($data);

        return redirect()->route('admin.rewards.index')
            ->with('success', 'Reward baru berhasil ditambahkan ke katalog.');
    }

    public function show(Reward $reward)
    {
        return view('admin.rewards.show', compact('reward'));
    }

    public function edit(Reward $reward)
    {
        return view('admin.rewards.form', [
            'reward' => $reward,
            'isEdit' => true
        ]);
    }

    public function update(Request $request, Reward $reward)
    {
        $data = $request->validate([
            'nama_reward' => ['required', 'string', 'max:100'],
            'poin_harga' => ['required', 'integer', 'min:1'],
            'stok' => ['required', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ]);

        $data['status_aktif'] = $request->boolean('status_aktif');

        $reward->update($data);

        return redirect()->route('admin.rewards.show', $reward)
            ->with('success', 'Data reward berhasil diperbarui.');
    }

    public function destroy(Reward $reward)
    {
        $reward->delete();

        return redirect()->route('admin.rewards.index')
            ->with('success', 'Reward berhasil dihapus dari katalog.');
    }
}
