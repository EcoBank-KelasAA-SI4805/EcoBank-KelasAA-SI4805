@extends('layouts.admin')
@section('title',$isEdit ? 'Edit Jenis Sampah' : 'Tambah Jenis Sampah')
@section('breadcrumb','Jenis Sampah')
@section('content')
@php $back = $isEdit ? route('admin.jenis-sampah.show',$jenis) : route('admin.jenis-sampah.index'); @endphp
<div class="page-heading"><div><div class="eyebrow">P-03 · KATALOG JENIS SAMPAH</div><h1>{{ $isEdit ? 'Edit jenis sampah' : 'Tambah jenis sampah' }}</h1><p>{{ $isEdit ? 'Ubah nama, kategori, atau status. Harga diubah lewat menu Ubah harga.' : 'Masukkan jenis sampah baru beserta harga awalnya.' }}</p></div><a class="btn btn-outline" href="{{ $back }}">← Kembali</a></div>
<div class="panel" style="padding:22px;max-width:850px">
<form method="POST" action="{{ $isEdit ? route('admin.jenis-sampah.update',$jenis) : route('admin.jenis-sampah.store') }}" novalidate>
@csrf @if($isEdit)@method('PUT')@endif
<div class="form-grid">
    <label class="form-field full">Nama jenis sampah
        <input name="nama_jenis" value="{{ old('nama_jenis',$jenis->nama_jenis) }}" maxlength="100" placeholder="Contoh: Botol plastik PET">
        @error('nama_jenis')<small class="field-error">{{ $message }}</small>@enderror
    </label>
    <label class="form-field">Kategori
        <select name="kategori">
            <option value="">— Pilih kategori —</option>
            @foreach(\App\Models\JenisSampah::KATEGORI as $k)<option value="{{ $k }}" @selected(old('kategori',$jenis->kategori)===$k)>{{ $k }}</option>@endforeach
        </select>
        @error('kategori')<small class="field-error">{{ $message }}</small>@enderror
    </label>
    @unless($isEdit)
    <label class="form-field">Harga awal (Rp / kg)
        <input name="harga_awal" type="number" min="1" step="any" value="{{ old('harga_awal') }}" placeholder="4000">
        @error('harga_awal')<small class="field-error">{{ $message }}</small>@enderror
    </label>
    @endunless
    <label class="form-field">Status
        <select name="status_aktif">
            <option value="1" @selected((int)old('status_aktif',(int)$jenis->status_aktif)===1)>Aktif</option>
            <option value="0" @selected((int)old('status_aktif',(int)$jenis->status_aktif)===0)>Nonaktif</option>
        </select>
    </label>
</div>
<div class="modal-actions"><a class="btn btn-outline" href="{{ $back }}">Batal</a><button class="btn btn-primary" type="submit">Simpan jenis sampah</button></div>
</form></div>
@endsection
