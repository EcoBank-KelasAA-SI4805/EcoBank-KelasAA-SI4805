@extends('layouts.admin')
@section('title',$isEdit ? 'Edit Wilayah' : 'Tambah Wilayah')
@section('breadcrumb','Wilayah/RW')
@section('content')
<div class="page-heading"><div><div class="eyebrow">P-10 · MASTER DATA</div><h1>{{ $isEdit ? 'Edit wilayah' : 'Tambah wilayah' }}</h1><p>{{ $isEdit ? 'Perbarui data wilayah/RW.' : 'Masukkan wilayah/RW baru.' }}</p></div><a class="btn btn-outline" href="{{ $isEdit ? route('admin.wilayah.show',$wilayah) : route('admin.wilayah.index') }}">← Kembali</a></div>
<div class="panel" style="padding:22px;max-width:850px"><form method="POST" action="{{ $isEdit ? route('admin.wilayah.update',$wilayah) : route('admin.wilayah.store') }}">@csrf @if($isEdit)@method('PUT')@endif
<div class="form-grid"><label class="form-field">Nama RW<input name="nama_rw" value="{{ old('nama_rw',$wilayah->nama_rw) }}" required maxlength="100" placeholder="Contoh: RW 05">@error('nama_rw')<small style="display:block;color:#cb4b4b;font-weight:500;font-size:10px">{{ $message }}</small>@enderror</label><label class="form-field">Kelurahan<input name="kelurahan" value="{{ old('kelurahan',$wilayah->kelurahan) }}" required maxlength="100" placeholder="Contoh: Sukapura">@error('kelurahan')<small style="display:block;color:#cb4b4b;font-weight:500;font-size:10px">{{ $message }}</small>@enderror</label></div>
<div class="modal-actions"><a class="btn btn-outline" href="{{ $isEdit ? route('admin.wilayah.show',$wilayah) : route('admin.wilayah.index') }}">Batal</a><button class="btn btn-primary" type="submit">Simpan wilayah</button></div></form></div>
@endsection
