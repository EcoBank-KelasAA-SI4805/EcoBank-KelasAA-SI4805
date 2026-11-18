@extends('layouts.admin')
@section('title', 'Detail Nasabah · ' . $nasabah->nama)
@section('breadcrumb', 'Data Nasabah / Detail')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            P-01 · DETAIL NASABAH
        </div>
        <h1>{{ $nasabah->nama }}</h1>
        <p>Rincian data identitas kependudukan, nomor kontak, dan ringkasan tabungan nasabah.</p>
    </div>
    <div class="heading-actions">
        <a class="btn btn-outline" href="{{ route('admin.nasabah.index') }}">← Daftar Nasabah</a>
        <a class="btn btn-primary" href="{{ route('admin.nasabah.edit', $nasabah) }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
            Edit Data Nasabah
        </a>
    </div>
</div>

<div class="panel" style="max-width: 820px;">
    {{-- Header Banner Saldo Nasabah --}}
    <div style="background: linear-gradient(135deg, #f0fdf4 0%, #e2f8ec 100%); border-bottom: 1px solid #bbf7d0; padding: 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div class="avatar" style="width: 52px; height: 52px; font-size: 18px; border-radius: 14px; background: #22c55e; color: #fff;">
                {{ strtoupper(substr($nasabah->nama, 0, 2)) }}
            </div>
            <div>
                <strong style="font: 800 18px 'Manrope', sans-serif; color: #064e3b; display: block;">{{ $nasabah->nama }}</strong>
                <span style="font-size: 12px; color: #047857;">NIK: {{ $nasabah->nik }} · Wilayah RW {{ $nasabah->rw }}</span>
            </div>
        </div>
        <div style="text-align: right;">
            <small style="font-size: 11px; font-weight: 700; color: #047857; text-transform: uppercase;">SALDO SIMPANAN AKTIF</small>
            <div style="font: 800 24px 'Manrope', sans-serif; color: #166534;">Rp {{ number_format($nasabah->saldo, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="detail-grid">
        <div class="detail-item">
            <small>NOMOR INDUK KEPENDUDUKAN (NIK)</small>
            <code>{{ $nasabah->nik }}</code>
        </div>
        <div class="detail-item">
            <small>NOMOR WHATSAPP / HP</small>
            <strong>{{ $nasabah->no_hp }}</strong>
        </div>
        <div class="detail-item">
            <small>WILAYAH DOMISILI</small>
            <strong>RW {{ $nasabah->rw }}</strong>
        </div>
        <div class="detail-item">
            <small>TOTAL TRANSAKSI TERCATAT</small>
            <strong>{{ $nasabah->transactions()->count() }} kali transaksi</strong>
        </div>
        <div class="detail-item" style="grid-column: 1 / -1;">
            <small>ALAMAT LENGKAP DOMISILI</small>
            <p style="margin: 4px 0 0; color: #334155; font-size: 13.5px; line-height: 1.5;">{{ $nasabah->alamat }}</p>
        </div>
        <div class="detail-item">
            <small>TERDAFTAR SEJAK</small>
            <strong>{{ $nasabah->created_at ? $nasabah->created_at->format('d M Y, H:i') : '-' }}</strong>
        </div>
        <div class="detail-item">
            <small>TERAKHIR DIPERBARUI</small>
            <strong>{{ $nasabah->updated_at ? $nasabah->updated_at->format('d M Y, H:i') : '-' }}</strong>
        </div>
    </div>
</div>
@endsection
