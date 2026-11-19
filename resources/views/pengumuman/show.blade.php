@extends('layouts.admin')

@section('title', $pengumuman->judul . ' · Pengumuman EcoBank')
@section('breadcrumb', 'Pengumuman / ' . \Illuminate\Support\Str::limit($pengumuman->judul, 25))

@section('content')
<style>
    .public-detail-container {
        max-width: 840px;
        margin: 0 auto;
    }
    .public-detail-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 32px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }
    .public-detail-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e2e8f0;
        flex-wrap: wrap;
    }
    .public-detail-body {
        font-size: 14px;
        color: #1e293b;
        line-height: 1.85;
        white-space: pre-line;
    }
    .public-detail-footer {
        margin-top: 36px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    @media (max-width: 640px) {
        .public-detail-card {
            padding: 20px;
        }
        .public-detail-body {
            font-size: 13px;
        }
    }
</style>

<div class="page-heading">
    <div>
        <div class="eyebrow" style="color: #16865b; font-weight: 700; letter-spacing: 1.2px; font-size: 11px; margin-bottom: 4px;">PENGUMUMAN RESMI</div>
        <h1 style="font: 800 24px/1.3 'Manrope', sans-serif; color: #0f172a; margin: 0 0 4px;">{{ $pengumuman->judul }}</h1>
        <p style="font-size: 12px; color: #64748b; margin: 0;">Dipublikasikan pada tanggal {{ \Carbon\Carbon::parse($pengumuman->tanggal_tayang)->format('d F Y') }}</p>
    </div>
    <a class="btn btn-outline" href="{{ route('pengumuman.public') }}" style="display: inline-flex; align-items: center; gap: 6px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        <span>Kembali ke Pengumuman</span>
    </a>
</div>

<div class="public-detail-container">
    <article class="public-detail-card">
        <div class="public-detail-meta">
            <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 600; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span>
                <span>Warta Pengurus Bank Sampah</span>
            </span>
            <span style="font-size: 12px; color: #64748b; display: inline-flex; align-items: center; gap: 5px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                Berlaku efektif sejak: <strong style="color: #0f172a;">{{ \Carbon\Carbon::parse($pengumuman->tanggal_tayang)->format('d M Y') }}</strong>
            </span>
        </div>

        <div class="public-detail-body">
            {{ $pengumuman->isi }}
        </div>

        <div class="public-detail-footer">
            <span style="font-size: 11px; color: #94a3b8;">© Pengurus EcoBank · Telkom University</span>
            <a class="btn btn-outline btn-sm" href="{{ route('pengumuman.public') }}" style="display: inline-flex; align-items: center; gap: 5px;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                <span>Daftar Pengumuman Lainnya</span>
            </a>
        </div>
    </article>
</div>
@endsection
