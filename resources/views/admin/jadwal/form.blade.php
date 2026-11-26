@extends('layouts.admin')
@section('title', $isEdit ? 'Edit Jadwal Pengumpulan' : 'Buat Jadwal Pengumpulan')
@section('breadcrumb', 'Jadwal Pengumpulan / ' . ($isEdit ? 'Edit' : 'Tambah'))

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            P-09 · MASTER DATA
        </div>
        <h1>{{ $isEdit ? 'Edit Jadwal Pengumpulan' : 'Buat Jadwal Pengumpulan Baru' }}</h1>
        <p>{{ $isEdit ? 'Perbarui tanggal, jam, wilayah sasaran, atau petugas penanggung jawab.' : 'Tentukan tanggal, jam operasional, wilayah target penjemputan sampah, dan petugas terkait.' }}</p>
    </div>
    <a class="btn btn-outline" href="{{ $isEdit ? route('admin.jadwal.show', $jadwal) : route('admin.jadwal.index') }}">← Kembali</a>
</div>

<div class="panel" style="padding: 28px; max-width: 820px;">
    <form method="POST" action="{{ $isEdit ? route('admin.jadwal.update', $jadwal) : route('admin.jadwal.store') }}">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="form-grid">
            <label class="form-field">
                Tanggal Operasional <span style="color:#ef4444;">*</span>
                <input type="date" name="tanggal" value="{{ old('tanggal', $jadwal->tanggal?->format('Y-m-d')) }}" required>
                @error('tanggal')
                    <small style="color:#ef4444; font-size:11px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                Jam Pelaksanaan <span style="color:#ef4444;">*</span>
                <input type="time" name="jam" value="{{ old('jam', $jadwal->jam_hm ?: '') }}" required>
                @error('jam')
                    <small style="color:#ef4444; font-size:11px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                Wilayah Sasaran / RW <span style="color:#ef4444;">*</span>
                <select name="wilayah_id" required>
                    <option value="">— Pilih Wilayah RW —</option>
                    @foreach($wilayahList as $w)
                        <option value="{{ $w->id }}" @selected(old('wilayah_id', $jadwal->wilayah_id) == $w->id)>
                            RW {{ $w->nama_rw }} — Kel. {{ $w->kelurahan }}
                        </option>
                    @endforeach
                </select>
                @error('wilayah_id')
                    <small style="color:#ef4444; font-size:11px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                Petugas Lapangan <span style="color:#ef4444;">*</span>
                <select name="petugas_id" required>
                    <option value="">— Pilih Petugas —</option>
                    @foreach($petugasList as $p)
                        <option value="{{ $p->id }}" @selected(old('petugas_id', $jadwal->petugas_id) == $p->id)>
                            {{ $p->nama ?? $p->name }} ({{ $p->role }})
                        </option>
                    @endforeach
                </select>
                @error('petugas_id')
                    <small style="color:#ef4444; font-size:11px;">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="modal-actions">
            <a class="btn btn-outline" href="{{ $isEdit ? route('admin.jadwal.show', $jadwal) : route('admin.jadwal.index') }}">Batal</a>
            <button class="btn btn-primary" type="submit">{{ $isEdit ? 'Perbarui Jadwal' : 'Simpan Jadwal Baru' }}</button>
        </div>
    </form>
</div>
@endsection
