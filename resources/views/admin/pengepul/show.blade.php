@extends('layouts.admin')
@section('title','Detail Pengepul')
@section('breadcrumb','Pengepul / Detail')
@section('content')
<div class="page-heading"><div><div class="eyebrow">DATA MASTER · DETAIL</div><h1>{{ $pengepul->nama }}</h1><p>Informasi lengkap pengepul.</p></div><div class="heading-actions"><a class="btn btn-outline" href="{{ route('admin.pengepul.index') }}">← Kembali</a><a class="btn btn-primary" href="{{ route('admin.pengepul.edit',$pengepul) }}">Edit Data</a></div></div>
<div class="panel" style="max-width:820px;padding:24px"><div class="detail-grid"><div class="detail-item"><small>NAMA PENGEPUL</small><strong>{{ $pengepul->nama }}</strong></div><div class="detail-item"><small>KONTAK / NOMOR TELEPON</small><strong>{{ $pengepul->kontak }}</strong></div><div class="detail-item"><small>ALAMAT</small><strong>{{ $pengepul->alamat }}</strong></div><div class="detail-item"><small>JENIS SAMPAH YANG DIBELI</small><strong>{{ $pengepul->jenis_dibeli }}</strong></div><div class="detail-item"><small>DIBUAT</small><strong>{{ $pengepul->created_at?->format('d M Y H:i') ?? '-' }}</strong></div></div></div>
@endsection
