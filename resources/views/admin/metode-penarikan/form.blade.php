@extends('layouts.admin')
@section('title', $isEdit ? 'Edit Metode Penarikan' : 'Tambah Metode Penarikan')
@section('breadcrumb', 'Metode Penarikan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/gracia_p11_p12.css') }}">
@endpush

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-12 • METODE PENARIKAN</div>
        <h1>{{ $isEdit ? 'Edit metode penarikan' : 'Tambah metode penarikan' }}</h1>
        <p>{{ $isEdit ? 'Perbarui informasi jalur penarikan atau status aktif/nonaktif.' : 'Masukkan jalur penarikan baru untuk pencairan saldo tabungan nasabah.' }}</p>
    </div>
    <a class="btn btn-outline" href="{{ $isEdit ? route('admin.metode-penarikan.show', $metode) : route('admin.metode-penarikan.index') }}">← Kembali</a>
</div>

<div class="panel" style="padding:22px;max-width:850px">
    <form method="POST" action="{{ $isEdit ? route('admin.metode-penarikan.update', $metode) : route('admin.metode-penarikan.store') }}">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="form-grid">
            <label class="form-field full">
                Nama metode penarikan <span style="color:#dc2626">*</span>
                <input name="nama_metode" value="{{ old('nama_metode', $metode->nama_metode) }}" required maxlength="100" placeholder="Contoh: Tunai Kasir Drop Point, Transfer Bank BCA, atau GoPay / OVO">
                @error('nama_metode')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                Kategori jalur <span style="color:#dc2626">*</span>
                <select name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="tunai" @selected(old('kategori', $metode->kategori) === 'tunai')>Kasir Tunai (Pencairan di Loket)</option>
                    <option value="transfer" @selected(old('kategori', $metode->kategori) === 'transfer')>Transfer Bank (BCA, Mandiri, BRI, dll)</option>
                    <option value="ewallet" @selected(old('kategori', $metode->kategori) === 'ewallet')>E-Wallet (GoPay, OVO, Dana, dll)</option>
                </select>
                @error('kategori')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                Minimal penarikan (Rp) <span style="color:#dc2626">*</span>
                <input type="number" name="minimal_tarik" value="{{ old('minimal_tarik', $metode->minimal_tarik ? (int)$metode->minimal_tarik : 10000) }}" required min="0" step="1000" placeholder="Contoh: 10000">
                @error('minimal_tarik')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field full">
                Deskripsi / Petunjuk Penarikan
                <textarea name="deskripsi" maxlength="500" placeholder="Contoh: Jam operasional kasir, estimasi transfer 1x24 jam, atau ketentuan penarikan...">{{ old('deskripsi', $metode->deskripsi) }}</textarea>
                @error('deskripsi')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            @if($isEdit)
                <label class="form-field">
                    Status metode
                    <select name="status_aktif">
                        <option value="1" @selected(old('status_aktif', (int)$metode->status_aktif) == 1)>Aktif (Dapat dipilih nasabah)</option>
                        <option value="0" @selected(old('status_aktif', (int)$metode->status_aktif) == 0)>Nonaktif (Tidak dapat dipilih)</option>
                    </select>
                </label>
            @endif
        </div>

        <div class="modal-actions">
            <a class="btn btn-outline" href="{{ $isEdit ? route('admin.metode-penarikan.show', $metode) : route('admin.metode-penarikan.index') }}">Batal</a>
            <button class="btn btn-primary" type="submit">{{ $isEdit ? 'Simpan perubahan' : 'Simpan metode' }}</button>
        </div>
    </form>
</div>
@endsection
