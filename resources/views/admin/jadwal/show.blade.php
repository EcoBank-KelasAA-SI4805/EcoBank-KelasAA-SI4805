@extends('layouts.admin')
@section('title','Detail Jadwal')
@section('breadcrumb','Jadwal Pengumpulan / Detail')
@section('content')
<div class="page-heading"><div><div class="eyebrow">P-09 · DETAIL JADWAL</div><h1>{{ $jadwal->wilayah?->nama_rw }} · {{ $jadwal->tanggal->format('d M Y') }}</h1><p>Informasi jadwal pengumpulan sampah.</p></div><div class="heading-actions"><a class="btn btn-outline" href="{{ route('admin.jadwal.index') }}">← Daftar</a><a class="btn btn-primary" href="{{ route('admin.jadwal.edit',$jadwal) }}">Edit jadwal</a></div></div>
<div class="panel"><div class="detail-grid"><div class="detail-item"><small>TANGGAL</small><strong>{{ $jadwal->tanggal->format('d M Y') }}</strong></div><div class="detail-item"><small>JAM</small><strong>{{ $jadwal->jam_hm }} WIB</strong></div><div class="detail-item"><small>WILAYAH</small><strong>{{ $jadwal->wilayah?->nama_rw }} — Kel. {{ $jadwal->wilayah?->kelurahan }}</strong></div><div class="detail-item"><small>PETUGAS</small><strong>{{ $jadwal->petugas?->name ?? '-' }}</strong></div></div></div>
@endsection
