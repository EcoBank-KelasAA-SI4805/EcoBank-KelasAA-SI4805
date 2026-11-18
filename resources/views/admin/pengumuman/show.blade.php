@extends('layouts.admin')

@section('title', 'Detail Pengumuman · ' . $pengumuman->judul)
@section('breadcrumb', 'Pengumuman / Detail')

@section('content')
<style>
    .detail-container {
        max-width: 860px;
        margin: 0 auto;
    }
    .detail-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        padding: 28px;
    }
    .detail-meta-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding-bottom: 18px;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 22px;
    }
    .detail-body {
        background: #fafcfb;
        border: 1px solid #e9eeeb;
        border-radius: 12px;
        padding: 24px;
        font-size: 14px;
        line-height: 1.8;
        color: #1e293b;
        white-space: pre-line;
        margin-bottom: 28px;
    }
    .detail-actions-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }
    @media (max-width: 640px) {
        .detail-card {
            padding: 18px;
        }
        .detail-body {
            padding: 16px;
            font-size: 13px;
        }
        .detail-actions-footer {
            flex-direction: column-reverse;
            align-items: stretch;
        }
        .detail-actions-footer .btn,
        .detail-actions-footer form,
        .detail-actions-footer form button {
            width: 100%;
        }
    }
</style>

<div class="page-heading">
    <div>
        <div class="eyebrow" style="color: #16865b; font-weight: 700; letter-spacing: 1.2px; font-size: 11px; margin-bottom: 4px;">DETAIL PENGUMUMAN</div>
        <h1 style="font: 800 24px/1.3 'Manrope', sans-serif; color: #0f172a; margin: 0 0 4px;">Detail Pengumuman</h1>
        <p style="font-size: 12px; color: #64748b; margin: 0;">Pratinjau konten pengumuman resmi bank sampah.</p>
    </div>
    <div class="heading-actions" style="display: flex; gap: 8px; flex-wrap: wrap;">
        <a class="btn btn-outline" href="{{ route('admin.pengumuman.index') }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            <span>Daftar Pengumuman</span>
        </a>
        <a class="btn btn-primary" href="{{ route('admin.pengumuman.edit', $pengumuman) }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
            <span>Edit Pengumuman</span>
        </a>
    </div>
</div>

@if(session('success'))
    <div style="margin-bottom: 20px; padding: 12px 18px; background: #ecfdf5; color: #065f46; border-radius: 9px; font-size: 12px; font-weight: 600; border-left: 4px solid #10b981; display: flex; align-items: center; gap: 8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="detail-container">
    <div class="detail-card">
        @php
            $isTayang = $pengumuman->tanggal_tayang && \Carbon\Carbon::parse($pengumuman->tanggal_tayang)->lte(now()->startOfDay());
        @endphp

        <div class="detail-meta-bar">
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                @if($isTayang)
                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 600; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span>
                        <span>Sedang Tayang</span>
                    </span>
                @else
                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 600; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #f59e0b;"></span>
                        <span>Terjadwal</span>
                    </span>
                @endif

                <span style="font-size: 12px; color: #64748b; display: inline-flex; align-items: center; gap: 5px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    Mulai tayang: <strong style="color: #0f172a;">{{ \Carbon\Carbon::parse($pengumuman->tanggal_tayang)->format('d F Y') }}</strong>
                </span>
            </div>

            <span style="font-size: 11px; color: #94a3b8; display: inline-flex; align-items: center; gap: 4px;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 14 14"/></svg>
                Dibuat: {{ $pengumuman->created_at ? $pengumuman->created_at->format('d M Y, H:i') : '—' }}
            </span>
        </div>

        {{-- Judul --}}
        <h2 style="font: 800 22px/1.35 'Manrope', sans-serif; color: #0f172a; margin: 0 0 20px;">
            {{ $pengumuman->judul }}
        </h2>

        {{-- Isi Konten --}}
        <div class="detail-body">
            {{ $pengumuman->isi }}
        </div>

        {{-- Footer Actions --}}
        <div class="detail-actions-footer">
            <form method="POST" action="{{ route('admin.pengumuman.destroy', $pengumuman) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline" type="submit" style="color: #e11d48; border-color: #fecdd3; display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18"/>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                    </svg>
                    <span>Hapus Pengumuman</span>
                </button>
            </form>

            <div style="display: flex; gap: 8px;">
                <a class="btn btn-primary" href="{{ route('admin.pengumuman.edit', $pengumuman) }}" style="display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                    <span>Edit Pengumuman</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
