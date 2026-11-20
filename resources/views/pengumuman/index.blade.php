@extends('layouts.admin')

@section('title', 'Papan Pengumuman & Informasi · EcoBank')
@section('breadcrumb', 'Papan Pengumuman')

@section('content')
<style>
    .nasabah-heading {
        margin-bottom: 24px;
    }
    .nasabah-heading h1 {
        font: 800 26px/1.25 'Manrope', sans-serif;
        color: #0f172a;
        margin: 0 0 6px;
    }
    .nasabah-heading p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }
    .public-search-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    }
    .public-search-form {
        display: flex;
        gap: 10px;
        max-width: 600px;
        flex-wrap: wrap;
    }
    .public-search-input-wrap {
        position: relative;
        flex: 1;
        min-width: 200px;
        display: flex;
        align-items: center;
    }
    .public-search-input-wrap svg {
        position: absolute;
        left: 12px;
        color: #94a3b8;
        pointer-events: none;
    }
    .public-search-input-wrap input {
        width: 100%;
        height: 40px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 0 14px 0 36px;
        font-size: 13px;
        outline: none;
        transition: all 0.15s ease;
    }
    .public-search-input-wrap input:focus {
        border-color: #16865b;
        box-shadow: 0 0 0 3px rgba(22, 134, 91, 0.15);
    }
    .public-card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }
    .public-announcement-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 22px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        position: relative;
    }
    .public-announcement-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        border-color: #cbd5e1;
    }
    .public-card-title {
        font: 700 16px/1.4 'Manrope', sans-serif;
        color: #0f172a;
        margin: 0 0 10px;
    }
    .public-card-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.15s ease;
    }
    .public-card-title a:hover {
        color: #16865b;
    }
    .public-card-excerpt {
        font-size: 13px;
        color: #475569;
        line-height: 1.6;
        margin: 0 0 18px;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .public-card-footer {
        border-top: 1px solid #f1f5f9;
        padding-top: 14px;
        margin-top: auto;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }
    .btn-read-more {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #16865b;
        font-weight: 700;
        font-size: 12px;
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 6px;
        background: #ecfdf5;
        transition: all 0.15s ease;
    }
    .btn-read-more:hover {
        background: #16865b;
        color: #ffffff;
    }
    @media (max-width: 640px) {
        .public-card-grid {
            grid-template-columns: 1fr;
        }
        .public-search-form {
            max-width: 100%;
        }
    }
</style>

<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-5v12L3 13v-2z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
            PORTAL INFORMASI WARGA & NASABAH
        </div>
        <h1>Papan Pengumuman Publik</h1>
        <p>Informasi resmi seputar jadwal operasional pos penimbangan, penyesuaian harga beli sampah, dan kegiatan EcoBank.</p>
    </div>
    @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isPetugas()))
        <a class="btn btn-outline" href="{{ route('admin.pengumuman.index') }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
            Kelola Pengumuman (Admin)
        </a>
    @endif
</div>

<div class="public-search-bar">
    <form class="public-search-form" method="GET" action="{{ route('pengumuman.public') }}">
        <div class="public-search-input-wrap">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.3-4.3"/>
            </svg>
            <input 
                type="search" 
                name="q" 
                value="{{ $q }}" 
                placeholder="Cari pengumuman atau berita penting..."
            >
        </div>
        <button class="btn btn-primary" type="submit" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <span>Cari</span>
        </button>
        @if($q)
            <a class="btn btn-outline" href="{{ route('pengumuman.public') }}" style="display: inline-flex; align-items: center; gap: 5px;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                <span>Reset</span>
            </a>
        @endif
    </form>
</div>

<div class="public-card-grid">
    @forelse($pengumuman as $item)
        <article class="public-announcement-card">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; gap: 10px;">
                <span style="display: inline-flex; align-items: center; gap: 5px; padding: 3px 9px; border-radius: 9999px; font-size: 11px; font-weight: 600; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span>
                    <span>Warta Resmi</span>
                </span>
                <span style="font-size: 11px; color: #64748b; display: inline-flex; align-items: center; gap: 4px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    {{ \Carbon\Carbon::parse($item->tanggal_tayang)->format('d M Y') }}
                </span>
            </div>

            <h3 class="public-card-title">
                <a href="{{ route('pengumuman.public.show', $item) }}">
                    {{ $item->judul }}
                </a>
            </h3>

            <p class="public-card-excerpt">
                {{ $item->isi }}
            </p>

            <div class="public-card-footer">
                <a class="btn-read-more" href="{{ route('pengumuman.public.show', $item) }}">
                    <span>Baca Selengkapnya</span>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        </article>
    @empty
        <div class="public-announcement-card" style="grid-column: 1 / -1; padding: 56px 20px; text-align: center;">
            <div style="width: 56px; height: 56px; border-radius: 14px; background: #f1f5f9; color: #94a3b8; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 14px; margin-left: auto; margin-right: auto;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 11 18-5v12L3 14v-3z"/>
                    <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
                </svg>
            </div>
            <strong style="color: #1e293b; font-size: 15px; display: block; margin-bottom: 4px; font-family: 'Manrope', sans-serif;">Belum Ada Pengumuman</strong>
            <p style="font-size: 12px; color: #64748b; margin: 0;">Saat ini belum ada pengumuman resmi yang aktif dipublikasikan.</p>
        </div>
    @endforelse
</div>

@if($pengumuman->hasPages())
    <div style="margin-top: 24px;">
        {{ $pengumuman->links() }}
    </div>
@endif
@endsection
