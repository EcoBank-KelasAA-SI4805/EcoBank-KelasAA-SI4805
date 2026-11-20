@extends('layouts.admin')
@section('title', 'Detail Wilayah · RW ' . $wilayah->nama_rw)
@section('breadcrumb', 'Wilayah/RW / Detail')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
            P-10 · DETAIL WILAYAH
        </div>
        <h1>RW {{ $wilayah->nama_rw }}</h1>
        <p>Kelurahan {{ $wilayah->kelurahan }} · Informasi cakupan wilayah dan statistik nasabah.</p>
    </div>
    <div class="heading-actions">
        <a class="btn btn-outline" href="{{ route('admin.wilayah.index') }}">← Daftar Wilayah</a>
        <a class="btn btn-primary" href="{{ route('admin.wilayah.edit', $wilayah) }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
            Edit Wilayah
        </a>
    </div>
</div>

<div class="panel" style="max-width: 820px;">
    {{-- Header Banner Wilayah --}}
    <div style="background: linear-gradient(135deg, #f0fdf4 0%, #e2f8ec 100%); border-bottom: 1px solid #bbf7d0; padding: 22px 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div class="avatar pastel-green" style="width: 48px; height: 48px; font-size: 20px; border-radius: 12px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
            </div>
            <div>
                <strong style="font: 800 17px 'Manrope', sans-serif; color: #0f172a; display: block;">Wilayah RW {{ $wilayah->nama_rw }}</strong>
                <span style="font-size: 12px; color: #166534;">Kelurahan {{ $wilayah->kelurahan }}</span>
            </div>
        </div>
        <div>
            <span class="type-pill" style="background:#dcfce7; color:#166534; font-size: 12px; font-weight:700; padding: 6px 14px;">
                {{ $wilayah->nasabah_count }} Nasabah Terdaftar
            </span>
        </div>
    </div>

    <div class="detail-grid">
        <div class="detail-item">
            <small>NAMA RW</small>
            <strong>RW {{ $wilayah->nama_rw }}</strong>
        </div>
        <div class="detail-item">
            <small>KELURAHAN</small>
            <strong>{{ $wilayah->kelurahan }}</strong>
        </div>
        <div class="detail-item">
            <small>JUMLAH NASABAH</small>
            <strong style="color: #16a34a;">{{ $wilayah->nasabah_count }} Orang</strong>
        </div>
        <div class="detail-item">
            <small>TOTAL JADWAL PENGUMPULAN</small>
            <strong>{{ $wilayah->jadwal_count }} Kali Agenda</strong>
        </div>
        <div class="detail-item">
            <small>DITAMBAHKAN PADA</small>
            <strong>{{ $wilayah->created_at ? $wilayah->created_at->format('d M Y, H:i') : '-' }}</strong>
        </div>
    </div>
</div>
@endsection
