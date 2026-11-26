@extends('layouts.admin')
@section('title','Detail Kendaraan Pengangkut')
@section('breadcrumb','Kendaraan Pengangkut / Detail')
@section('content')
<div class="page-heading"><div><div class="eyebrow">DATA MASTER · DETAIL</div><h1>{{ $kendaraan->nama }}</h1><p>Informasi lengkap kendaraan pengangkut.</p></div><div class="heading-actions"><a class="btn btn-outline" href="{{ route('admin.kendaraan.index') }}">← Kembali</a><a class="btn btn-primary" href="{{ route('admin.kendaraan.edit',$kendaraan) }}">Edit Data</a></div></div>
<div class="panel" style="max-width:820px;padding:24px"><div class="detail-grid"><div class="detail-item"><small>NAMA KENDARAAN</small><strong>{{ $kendaraan->nama }}</strong></div><div class="detail-item"><small>NOMOR POLISI</small><strong>{{ $kendaraan->nomor_polisi }}</strong></div><div class="detail-item"><small>JENIS KENDARAAN</small><strong>{{ $kendaraan->jenis }}</strong></div><div class="detail-item"><small>STATUS</small><strong>{{ $kendaraan->status }}</strong></div><div class="detail-item"><small>DIBUAT</small><strong>{{ $kendaraan->created_at?->format('d M Y H:i') ?? '-' }}</strong></div></div></div>
@endsection
