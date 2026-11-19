@extends('layouts.admin')
@section('title', $isEdit ? 'Edit Lokasi Drop Point' : 'Tambah Lokasi Drop Point')
@section('breadcrumb', 'Drop Points / ' . ($isEdit ? 'Edit' : 'Tambah'))

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
            P-02 · MANAJEMEN LOKASI SETOR
        </div>
        <h1>{{ $isEdit ? 'Edit Lokasi Drop Point' : 'Tambah Drop Point Baru' }}</h1>
        <p>{{ $isEdit ? 'Perbarui jadwal operasional, alamat pos, atau status keaktifan layanan.' : 'Daftarkan pos atau titik kumpul baru untuk pelayanan setor sampah warga.' }}</p>
    </div>
    <a class="btn btn-outline" href="{{ $isEdit ? route('admin.drop-points.show', $dropPoint) : route('admin.drop-points.index') }}">← Kembali</a>
</div>

<div class="panel" style="padding: 28px; max-width: 820px;">
    <form method="POST" action="{{ $isEdit ? route('admin.drop-points.update', $dropPoint) : route('admin.drop-points.store') }}">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="form-grid">
            <label class="form-field full">
                Nama Titik / Pos Drop Point <span style="color:#ef4444;">*</span>
                <input type="text" name="nama" value="{{ old('nama', $dropPoint->nama) }}" required maxlength="100" placeholder="Contoh: Drop Point Balai RW 05">
                @error('nama')
                    <small style="color:#ef4444; font-size:11px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field full">
                Alamat Lengkap Lokasi Pos <span style="color:#ef4444;">*</span>
                <textarea name="alamat" required maxlength="500" placeholder="Contoh: Balai Warga RW 05, Kelurahan Sukamaju">{{ old('alamat', $dropPoint->alamat) }}</textarea>
                @error('alamat')
                    <small style="color:#ef4444; font-size:11px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                Jadwal & Jam Buka Operasional <span style="color:#ef4444;">*</span>
                <input type="text" name="jam_buka" value="{{ old('jam_buka', $dropPoint->jam_buka) }}" required maxlength="100" placeholder="Contoh: Sabtu & Minggu: 08.00 - 12.00 WIB">
                @error('jam_buka')
                    <small style="color:#ef4444; font-size:11px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                Status Keaktifan Pos <span style="color:#ef4444;">*</span>
                <select name="status_aktif" required>
                    <option value="1" @selected(old('status_aktif', (int)$dropPoint->status_aktif ?? 1) == 1)>Aktif Melayani Warga</option>
                    <option value="0" @selected(old('status_aktif', (int)$dropPoint->status_aktif ?? 1) == 0)>Nonaktif Sementara</option>
                </select>
                @error('status_aktif')
                    <small style="color:#ef4444; font-size:11px;">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="modal-actions">
            <a class="btn btn-outline" href="{{ $isEdit ? route('admin.drop-points.show', $dropPoint) : route('admin.drop-points.index') }}">Batal</a>
            <button class="btn btn-primary" type="submit">{{ $isEdit ? 'Perbarui Lokasi Drop Point' : 'Simpan Drop Point Baru' }}</button>
        </div>
    </form>
</div>
@endsection
