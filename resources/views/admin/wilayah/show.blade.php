@extends('layouts.admin')
@section('title','Detail Wilayah')
@section('breadcrumb','Wilayah/RW / Detail')
@section('content')
<div class="page-heading"><div><div class="eyebrow">P-10 · DETAIL WILAYAH</div><h1>{{ $wilayah->nama_rw }}</h1><p>Kelurahan {{ $wilayah->kelurahan }}</p></div><div class="heading-actions"><a class="btn btn-outline" href="{{ route('admin.wilayah.index') }}">← Daftar</a><a class="btn btn-primary" href="{{ route('admin.wilayah.edit',$wilayah) }}">Edit wilayah</a></div></div>
<div class="panel"><div class="detail-grid"><div class="detail-item"><small>NAMA RW</small><strong>{{ $wilayah->nama_rw }}</strong></div><div class="detail-item"><small>KELURAHAN</small><strong>{{ $wilayah->kelurahan }}</strong></div><div class="detail-item"><small>JUMLAH NASABAH</small><strong>{{ $wilayah->nasabah_count }}</strong></div><div class="detail-item"><small>JUMLAH JADWAL</small><strong>{{ $wilayah->jadwal_count }}</strong></div><div class="detail-item"><small>DITAMBAHKAN</small><strong>{{ $wilayah->created_at?->format('d M Y') }}</strong></div></div></div>
@endsection
