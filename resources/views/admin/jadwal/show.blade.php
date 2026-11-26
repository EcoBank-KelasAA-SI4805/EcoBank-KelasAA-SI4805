@extends('layouts.admin')
@section('title', 'Detail Jadwal · ' . ($jadwal->wilayah?->nama_rw ?? 'RW') . ' · ' . $jadwal->tanggal->format('d M Y'))
@section('breadcrumb', 'Jadwal Pengumpulan / Detail')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            P-09 · DETAIL JADWAL PENGUMPULAN
        </div>
        <h1>RW {{ $jadwal->wilayah?->nama_rw }} · {{ $jadwal->tanggal->format('d M Y') }}</h1>
        <p>Informasi jadwal penjemputan sampah dan penugasan petugas operasional di lapangan.</p>
    </div>
    <div class="heading-actions">
        <a class="btn btn-outline" href="{{ route('admin.jadwal.index') }}">← Daftar Jadwal</a>
        <a class="btn btn-primary" href="{{ route('admin.jadwal.edit', $jadwal) }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
            Edit Jadwal
        </a>
    </div>
</div>

<div class="panel" style="max-width: 820px;">
    {{-- Header Banner Jadwal --}}
    <div style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 1px solid var(--line); padding: 22px 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div class="avatar pastel-green" style="width: 48px; height: 48px; font-size: 20px; border-radius: 12px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            </div>
            <div>
                <strong style="font: 800 17px 'Manrope', sans-serif; color: #0f172a; display: block;">Jadwal Penjemputan RW {{ $jadwal->wilayah?->nama_rw }}</strong>
                <span style="font-size: 12px; color: #64748b;">Kelurahan {{ $jadwal->wilayah?->kelurahan }}</span>
            </div>
        </div>
        <div>
            <span class="status {{ $jadwal->tanggal->isToday() ? 'pending' : ($jadwal->tanggal->isPast() ? 'inactive' : 'success') }}" style="padding: 6px 14px; font-size: 12px;">
                {{ $jadwal->tanggal->isToday() ? 'Agenda Hari Ini' : ($jadwal->tanggal->isPast() ? 'Selesai Dilaksanakan' : 'Akan Datang') }}
            </span>
        </div>
    </div>

    <div class="detail-grid">
        <div class="detail-item">
            <small>TANGGAL PELAKSANAAN</small>
            <strong style="font-size: 14px; color: #0f172a;">{{ $jadwal->tanggal->format('d F Y') }}</strong>
        </div>
        <div class="detail-item">
            <small>JAM OPERASIONAL</small>
            <strong style="display: flex; align-items: center; gap: 6px; font-size: 14px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" color="#16a34a"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ $jadwal->jam_hm }} WIB
            </strong>
        </div>
        <div class="detail-item">
            <small>WILAYAH TUJUAN</small>
            <strong>RW {{ $jadwal->wilayah?->nama_rw }} (Kel. {{ $jadwal->wilayah?->kelurahan }})</strong>
        </div>
        <div class="detail-item">
            <small>PETUGAS LAPANGAN</small>
            <strong style="color: #166534; font-size: 14px;">{{ $jadwal->petugas?->name ?? '-' }}</strong>
        </div>
        <div class="detail-item">
            <small>DIBUAT PADA</small>
            <strong>{{ $jadwal->created_at ? $jadwal->created_at->format('d M Y, H:i') : '-' }}</strong>
        </div>
    </div>
</div>
@endsection
