@extends('layouts.admin')
@section('title','Detail Nasabah')
@section('breadcrumb','Data Nasabah / Detail')
@section('content')
<div class="page-heading"><div><div class="eyebrow">P-01 · DETAIL NASABAH</div><h1>{{ $nasabah->nama }}</h1><p>Informasi identitas dan saldo nasabah.</p></div><div class="heading-actions"><a class="btn btn-outline" href="{{ route('admin.nasabah.index') }}">← Daftar</a><a class="btn btn-primary" href="{{ route('admin.nasabah.edit',$nasabah) }}">Edit data</a></div></div>
@if(session('success'))<div class="flash success">{{ session('success') }}</div>@endif @if(session('error'))<div class="flash error">{{ session('error') }}</div>@endif
<div class="panel"><div class="detail-grid"><div class="detail-item"><small>NAMA LENGKAP</small><strong>{{ $nasabah->nama }}</strong></div><div class="detail-item"><small>NIK</small><strong>{{ $nasabah->nik }}</strong></div><div class="detail-item"><small>ALAMAT</small><strong>{{ $nasabah->alamat }}</strong></div><div class="detail-item"><small>NOMOR HP</small><strong>{{ $nasabah->no_hp }}</strong></div><div class="detail-item"><small>RW</small><strong>{{ $nasabah->rw }}</strong></div><div class="detail-item"><small>SALDO SAAT INI</small><strong style="color:#26945e;font-size:18px">Rp {{ number_format($nasabah->saldo,0,',','.') }}</strong></div><div class="detail-item"><small>JUMLAH TRANSAKSI</small><strong>{{ $nasabah->transactions()->count() }} transaksi</strong></div><div class="detail-item"><small>TERDAFTAR SEJAK</small><strong>{{ $nasabah->created_at?->format('d M Y') }}</strong></div></div></div>
@endsection
