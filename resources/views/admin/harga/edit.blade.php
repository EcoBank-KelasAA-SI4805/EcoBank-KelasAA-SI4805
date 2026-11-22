@extends('layouts.admin')
@section('title','Ubah Harga')
@section('breadcrumb','Jenis Sampah / Ubah Harga')
@section('content')
<div class="page-heading"><div><div class="eyebrow">P-03 · HARGA SAMPAH</div><h1>Ubah harga: {{ $jenis->nama_jenis }}</h1><p>Harga baru hanya berlaku untuk setoran berikutnya. Setoran lama tidak berubah.</p></div><a class="btn btn-outline" href="{{ route('admin.jenis-sampah.show',$jenis) }}">← Kembali</a></div>
<div class="panel" style="padding:22px;max-width:850px">
<form method="POST" action="{{ route('admin.harga.update',$jenis) }}" novalidate>
@csrf @method('PUT')
<div class="form-grid">
    <div class="price-card"><small>HARGA LAMA</small><strong>Rp {{ number_format($jenis->harga_per_kg,0,',','.') }} / kg</strong></div>
    <label class="form-field">Harga baru (Rp / kg)
        <input name="harga_baru" type="number" min="1" step="any" value="{{ old('harga_baru') }}" placeholder="Masukkan harga baru" autofocus>
        @error('harga_baru')<small class="field-error">{{ $message }}</small>@enderror
        <span class="hint">Harus berupa angka lebih dari 0.</span>
    </label>
</div>
<div class="modal-actions"><a class="btn btn-outline" href="{{ route('admin.jenis-sampah.show',$jenis) }}">Batal</a><button class="btn btn-primary" type="submit">Simpan harga</button></div>
</form></div>
@endsection
