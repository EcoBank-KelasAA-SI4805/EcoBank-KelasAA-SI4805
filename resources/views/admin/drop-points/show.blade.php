@extends('layouts.admin')
@section('title', 'Detail Drop Point · ' . $dropPoint->nama)
@section('breadcrumb', 'Drop Points / Detail')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
            P-02 · DETAIL LOKASI SETOR
        </div>
        <h1>{{ $dropPoint->nama }}</h1>
        <p>Rincian jadwal operasional, ketersediaan layanan, dan alamat lokasi pos setor.</p>
    </div>
    <div class="heading-actions">
        <a class="btn btn-outline" href="{{ route('admin.drop-points.index') }}">← Daftar Drop Point</a>
        <a class="btn btn-primary" href="{{ route('admin.drop-points.edit', $dropPoint) }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
            Edit Drop Point
        </a>
    </div>
</div>

<div class="panel" style="max-width: 820px;">
    {{-- Header Status Pos --}}
    <div style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 1px solid var(--line); padding: 22px 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div class="avatar pastel-purple" style="width: 48px; height: 48px; font-size: 20px; border-radius: 12px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div>
                <strong style="font: 800 17px 'Manrope', sans-serif; color: #0f172a; display: block;">{{ $dropPoint->nama }}</strong>
                <span style="font-size: 12px; color: #64748b;">Pos Layanan Penimbangan Sampah Terpadu</span>
            </div>
        </div>
        <div>
            <span class="status {{ $dropPoint->status_aktif ? 'success' : 'inactive' }}" style="padding: 6px 14px; font-size: 12px;">
                {{ $dropPoint->status_aktif ? '✓ Pos Aktif Beroperasi' : '✕ Nonaktif Sementara' }}
            </span>
        </div>
    </div>

    <div class="detail-grid">
        <div class="detail-item" style="grid-column: 1 / -1;">
            <small>ALAMAT LENGKAP LOKASI</small>
            <p style="margin: 4px 0 0; color: #334155; font-size: 14px; line-height: 1.5;">{{ $dropPoint->alamat }}</p>
        </div>
        <div class="detail-item">
            <small>JADWAL & JAM BUKA</small>
            <strong style="display: flex; align-items: center; gap: 6px; font-size: 14px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" color="#64748b"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ $dropPoint->jam_buka }}
            </strong>
        </div>
        <div class="detail-item">
            <small>STATUS OPERASIONAL</small>
            <strong>{{ $dropPoint->status_aktif ? 'Aktif Menerima Setoran' : 'Tutup Sementara' }}</strong>
        </div>
        <div class="detail-item">
            <small>DITAMBAHKAN PADA</small>
            <strong>{{ $dropPoint->created_at ? $dropPoint->created_at->format('d M Y, H:i') : '-' }}</strong>
        </div>
        <div class="detail-item">
            <small>TERAKHIR DIPERBARUI</small>
            <strong>{{ $dropPoint->updated_at ? $dropPoint->updated_at->format('d M Y, H:i') : '-' }}</strong>
        </div>
    </div>
</div>
@endsection
