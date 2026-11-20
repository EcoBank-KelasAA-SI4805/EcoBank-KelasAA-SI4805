@extends('layouts.admin')
@section('title', $isEdit ? 'Edit Wilayah/RW' : 'Tambah Wilayah/RW')
@section('breadcrumb', 'Wilayah/RW / ' . ($isEdit ? 'Edit' : 'Tambah'))

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
            P-10 · MASTER DATA
        </div>
        <h1>{{ $isEdit ? 'Edit Wilayah/RW' : 'Tambah Wilayah RW Baru' }}</h1>
        <p>{{ $isEdit ? 'Perbarui nomor RW atau data kelurahan.' : 'Daftarkan wilayah RW baru yang tercakup dalam layanan bank sampah.' }}</p>
    </div>
    <a class="btn btn-outline" href="{{ $isEdit ? route('admin.wilayah.show', $wilayah) : route('admin.wilayah.index') }}">← Kembali</a>
</div>

<div class="panel" style="padding: 28px; max-width: 820px;">
    <form method="POST" action="{{ $isEdit ? route('admin.wilayah.update', $wilayah) : route('admin.wilayah.store') }}">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="form-grid">
            <label class="form-field">
                Nomor RW <span style="color:#ef4444;">*</span>
                <input type="text" name="nama_rw" value="{{ old('nama_rw', $wilayah->nama_rw) }}" required maxlength="100" placeholder="Contoh: 05">
                @error('nama_rw')
                    <small style="color:#ef4444; font-size:11px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                Kelurahan <span style="color:#ef4444;">*</span>
                <input type="text" name="kelurahan" value="{{ old('kelurahan', $wilayah->kelurahan) }}" required maxlength="100" placeholder="Contoh: Sukamaju">
                @error('kelurahan')
                    <small style="color:#ef4444; font-size:11px;">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="modal-actions">
            <a class="btn btn-outline" href="{{ $isEdit ? route('admin.wilayah.show', $wilayah) : route('admin.wilayah.index') }}">Batal</a>
            <button class="btn btn-primary" type="submit">{{ $isEdit ? 'Perbarui Wilayah' : 'Simpan Wilayah Baru' }}</button>
        </div>
    </form>
</div>
@endsection
