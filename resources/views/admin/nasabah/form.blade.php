@extends('layouts.admin')
@section('title', $isEdit ? 'Edit Nasabah' : 'Tambah Nasabah')
@section('breadcrumb', 'Data Nasabah / ' . ($isEdit ? 'Edit' : 'Tambah'))

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            P-01 · MANAJEMEN DATA NASABAH
        </div>
        <h1>{{ $isEdit ? 'Edit Data Nasabah' : 'Tambah Nasabah Baru' }}</h1>
        <p>{{ $isEdit ? 'Perbarui informasi identitas, nomor telepon, atau domisili nasabah.' : 'Daftarkan warga baru sebagai nasabah bank sampah EcoBank.' }}</p>
    </div>
    <a class="btn btn-outline" href="{{ $isEdit ? route('admin.nasabah.show', $nasabah) : route('admin.nasabah.index') }}">← Kembali</a>
</div>

<div class="panel" style="padding: 28px; max-width: 820px;">
    <form method="POST" action="{{ $isEdit ? route('admin.nasabah.update', $nasabah) : route('admin.nasabah.store') }}">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="form-grid">
            <label class="form-field">
                Nama Lengkap Sesuai KTP <span style="color:#ef4444;">*</span>
                <input type="text" name="nama" value="{{ old('nama', $nasabah->nama) }}" required maxlength="100" placeholder="Contoh: Andi Pratama">
                @error('nama')
                    <small style="color:#ef4444; font-size:11px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                NIK (16 Digit Angka) <span style="color:#ef4444;">*</span>
                <input type="text" name="nik" value="{{ old('nik', $nasabah->nik) }}" required minlength="16" maxlength="16" inputmode="numeric" placeholder="Contoh: 3201011204950001">
                @error('nik')
                    <small style="color:#ef4444; font-size:11px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                Nomor WhatsApp / HP <span style="color:#ef4444;">*</span>
                <input type="text" name="no_hp" value="{{ old('no_hp', $nasabah->no_hp) }}" required maxlength="20" placeholder="Contoh: 081234567890">
                @error('no_hp')
                    <small style="color:#ef4444; font-size:11px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                RW Domisili <span style="color:#ef4444;">*</span>
                <input type="text" name="rw" value="{{ old('rw', $nasabah->rw) }}" required maxlength="10" placeholder="Contoh: 05">
                @error('rw')
                    <small style="color:#ef4444; font-size:11px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field full">
                Alamat Domisili Lengkap <span style="color:#ef4444;">*</span>
                <textarea name="alamat" required maxlength="500" placeholder="Contoh: Jl. Kenanga No. 14, RT 02 / RW 05">{{ old('alamat', $nasabah->alamat) }}</textarea>
                @error('alamat')
                    <small style="color:#ef4444; font-size:11px;">{{ $message }}</small>
                @enderror
            </label>
        </div>

        @if($isEdit)
            <div class="form-note">
                <strong>Catatan Saldo:</strong> Saldo simpanan nasabah dikelola secara otomatis melalui transaksi setoran dan penarikan sampah, tidak dapat diubah manual lewat form ini.
            </div>
        @else
            <div class="form-note">
                <strong>Informasi Saldo Awal:</strong> Rekening tabungan nasabah baru otomatis diaktifkan dengan saldo awal Rp 0.
            </div>
        @endif

        <div class="modal-actions">
            <a class="btn btn-outline" href="{{ $isEdit ? route('admin.nasabah.show', $nasabah) : route('admin.nasabah.index') }}">Batal</a>
            <button class="btn btn-primary" type="submit">{{ $isEdit ? 'Perbarui Data Nasabah' : 'Simpan Nasabah Baru' }}</button>
        </div>
    </form>
</div>
@endsection
