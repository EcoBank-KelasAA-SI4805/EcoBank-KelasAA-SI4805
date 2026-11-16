@extends('layouts.admin')
@section('title','Detail Drop Point')
@section('breadcrumb','Lokasi Drop Point / Detail')
@section('content')
<div class="page-heading"><div><div class="eyebrow">P-02 · DETAIL LOKASI</div><h1>{{ $dropPoint->nama }}</h1><p>Informasi operasional titik setor.</p></div><div class="heading-actions"><a class="btn btn-outline" href="{{ route('admin.drop-points.index') }}">← Daftar</a><a class="btn btn-primary" href="{{ route('admin.drop-points.edit',$dropPoint) }}">Edit lokasi</a></div></div>
@if(session('success'))<div class="flash success">{{ session('success') }}</div>@endif
<div class="panel"><div class="detail-grid"><div class="detail-item"><small>NAMA LOKASI</small><strong>{{ $dropPoint->nama }}</strong></div><div class="detail-item"><small>STATUS</small><strong>{{ $dropPoint->status_aktif ? 'Aktif' : 'Nonaktif' }}</strong></div><div class="detail-item"><small>ALAMAT</small><strong>{{ $dropPoint->alamat }}</strong></div><div class="detail-item"><small>JAM BUKA</small><strong>{{ $dropPoint->jam_buka }}</strong></div><div class="detail-item"><small>DITAMBAHKAN</small><strong>{{ $dropPoint->created_at?->format('d M Y') }}</strong></div></div></div>
@endsection