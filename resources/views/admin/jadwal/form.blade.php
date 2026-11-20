@extends('layouts.admin')
@section('title',$isEdit ? 'Edit Jadwal' : 'Buat Jadwal')
@section('breadcrumb','Jadwal Pengumpulan')
@section('content')
<div class="page-heading"><div><div class="eyebrow">P-09 · MASTER DATA</div><h1>{{ $isEdit ? 'Edit jadwal pengumpulan' : 'Buat jadwal pengumpulan' }}</h1><p>{{ $isEdit ? 'Perbarui tanggal, jam, wilayah, atau petugas.' : 'Tentukan tanggal, jam, wilayah, dan petugas.' }}</p></div><a class="btn btn-outline" href="{{ $isEdit ? route('admin.jadwal.show',$jadwal) : route('admin.jadwal.index') }}">← Kembali</a></div>
<div class="panel" style="padding:22px;max-width:850px"><form method="POST" action="{{ $isEdit ? route('admin.jadwal.update',$jadwal) : route('admin.jadwal.store') }}">@csrf @if($isEdit)@method('PUT')@endif
<div class="form-grid">
<label class="form-field">Tanggal<input type="date" name="tanggal" value="{{ old('tanggal',$jadwal->tanggal?->format('Y-m-d')) }}" required>@error('tanggal')<small style="display:block;color:#cb4b4b;font-weight:500;font-size:10px">{{ $message }}</small>@enderror</label>
<label class="form-field">Jam<input type="time" name="jam" value="{{ old('jam',$jadwal->jam_hm ?: '') }}" required>@error('jam')<small style="display:block;color:#cb4b4b;font-weight:500;font-size:10px">{{ $message }}</small>@enderror</label>
<label class="form-field">Wilayah<select name="wilayah_id" required><option value="">— Pilih wilayah —</option>@foreach($wilayahList as $w)<option value="{{ $w->id }}" @selected(old('wilayah_id',$jadwal->wilayah_id) == $w->id)>{{ $w->nama_rw }} — {{ $w->kelurahan }}</option>@endforeach</select>@error('wilayah_id')<small style="display:block;color:#cb4b4b;font-weight:500;font-size:10px">{{ $message }}</small>@enderror</label>
<label class="form-field">Petugas<select name="petugas_id" required><option value="">— Pilih petugas —</option>@foreach($petugasList as $p)<option value="{{ $p->id }}" @selected(old('petugas_id',$jadwal->petugas_id) == $p->id)>{{ $p->name }}</option>@endforeach</select>@error('petugas_id')<small style="display:block;color:#cb4b4b;font-weight:500;font-size:10px">{{ $message }}</small>@enderror</label>
</div>
<div class="modal-actions"><a class="btn btn-outline" href="{{ $isEdit ? route('admin.jadwal.show',$jadwal) : route('admin.jadwal.index') }}">Batal</a><button class="btn btn-primary" type="submit">Simpan jadwal</button></div></form></div>
@endsection
