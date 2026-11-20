@extends('layouts.admin')
@section('title', $pageTitle ?? 'Halaman')
@section('breadcrumb', $pageTitle ?? 'Halaman')
@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">ECOBANK · MODUL</div>
        <h1>{{ $pageTitle ?? 'Halaman' }}</h1>
        <p>Halaman ini terhubung dalam sistem informasi EcoBank.</p>
    </div>
</div>
<div class="panel empty-state">
    <div class="empty-icon">◷</div>
    <h3>Modul {{ $pageTitle ?? 'ini' }} sedang dikembangkan</h3>
    <p>Data aktivitas saat ini telah terhubung ke modul Nasabah, Drop Points, Pencatatan Residu, dan Pengeluaran Operasional.</p>
    <div style="display: flex; gap: 10px; justify-content: center; margin-top: 16px;">
        <a class="btn btn-primary" href="{{ route('admin.dashboard') }}">Kembali ke Dashboard</a>
        <a class="btn btn-outline" href="{{ route('admin.nasabah.index') }}">Buka Data Nasabah</a>
    </div>
</div>
@endsection
