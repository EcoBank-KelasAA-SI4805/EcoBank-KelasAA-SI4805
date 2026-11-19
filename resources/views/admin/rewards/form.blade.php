@extends('layouts.admin')
@section('title', $isEdit ? 'Edit Reward' : 'Tambah Reward')
@section('breadcrumb', 'Katalog Reward')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/gracia_p11_p12.css') }}">
@endpush

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-11 • REWARD DAN POIN</div>
        <h1>{{ $isEdit ? 'Edit reward' : 'Tambah reward baru' }}</h1>
        <p>{{ $isEdit ? 'Perbarui informasi produk reward, poin penukaran, atau stok.' : 'Masukkan item reward baru ke dalam katalog penukaran poin.' }}</p>
    </div>
    <a class="btn btn-outline" href="{{ $isEdit ? route('admin.rewards.show', $reward) : route('admin.rewards.index') }}">← Kembali</a>
</div>

<div class="panel" style="padding:22px;max-width:850px">
    <form method="POST" action="{{ $isEdit ? route('admin.rewards.update', $reward) : route('admin.rewards.store') }}">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="form-grid">
            <label class="form-field full">
                Nama reward <span style="color:#dc2626">*</span>
                <input name="nama_reward" value="{{ old('nama_reward', $reward->nama_reward) }}" required maxlength="100" placeholder="Contoh: Totebag Daur Ulang Kanvas">
                @error('nama_reward')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                Poin dibutuhkan <span style="color:#dc2626">*</span>
                <input type="number" name="poin_harga" value="{{ old('poin_harga', $reward->poin_harga) }}" required min="1" placeholder="Contoh: 150">
                @error('poin_harga')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                Jumlah stok <span style="color:#dc2626">*</span>
                <input type="number" name="stok" value="{{ old('stok', $reward->stok ?? 0) }}" required min="0" placeholder="Contoh: 25">
                @error('stok')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field full">
                Deskripsi reward
                <textarea name="deskripsi" maxlength="500" placeholder="Keterangan bahan, manfaat, atau syarat penukaran reward...">{{ old('deskripsi', $reward->deskripsi) }}</textarea>
                @error('deskripsi')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </label>

            @if($isEdit)
                <label class="form-field">
                    Status reward
                    <select name="status_aktif">
                        <option value="1" @selected(old('status_aktif', (int)$reward->status_aktif) == 1)>Aktif (Dapat ditukar)</option>
                        <option value="0" @selected(old('status_aktif', (int)$reward->status_aktif) == 0)>Nonaktif (Disembunyikan)</option>
                    </select>
                </label>
            @endif
        </div>

        <div class="modal-actions">
            <a class="btn btn-outline" href="{{ $isEdit ? route('admin.rewards.show', $reward) : route('admin.rewards.index') }}">Batal</a>
            <button class="btn btn-primary" type="submit">{{ $isEdit ? 'Simpan perubahan' : 'Simpan reward' }}</button>
        </div>
    </form>
</div>
@endsection
