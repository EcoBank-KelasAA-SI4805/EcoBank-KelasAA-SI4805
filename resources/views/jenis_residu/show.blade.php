@extends('layouts.admin')
@section('title', 'Detail Jenis Residu · ' . $jenisResidu->nama)
@section('breadcrumb', 'Jenis Residu / ' . $jenisResidu->nama)

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-05 · MASTER DATA RESIDU</div>
        <h1>{{ $jenisResidu->nama }}</h1>
        <p>Detail klasifikasi dan tarif biaya penanganan residu.</p>
    </div>
    <div class="heading-actions">
        <a class="btn btn-outline" href="{{ route('jenis-residu.index') }}">← Daftar Jenis Residu</a>
        <a class="btn btn-primary" href="{{ route('jenis-residu.edit', $jenisResidu) }}">Edit Jenis Residu</a>
    </div>
</div>

<div class="panel" style="max-width: 800px;">
    <div class="detail-grid">
        <div class="detail-item">
            <small>NAMA RESIDU</small>
            <strong style="font-size: 16px;">{{ $jenisResidu->nama }}</strong>
        </div>
        <div class="detail-item">
            <small>CARA PENANGANAN</small>
            <div>
                <span class="type-pill {{ $jenisResidu->cara_penanganan === 'TPA' ? 'deposit-type' : 'withdraw-type' }}">
                    {{ ucfirst($jenisResidu->cara_penanganan) }}
                </span>
            </div>
        </div>
        <div class="detail-item">
            <small>BIAYA PENANGANAN PER KG</small>
            <strong style="color: #16865b; font-size: 16px;">Rp {{ number_format($jenisResidu->biaya_per_kg, 0, ',', '.') }}</strong>
        </div>
        <div class="detail-item">
            <small>DITAMBAHKAN PADA</small>
            <strong>{{ $jenisResidu->created_at ? $jenisResidu->created_at->format('d M Y, H:i') : '-' }}</strong>
        </div>
        <div class="detail-item" style="grid-column: 1 / -1;">
            <small>ALASAN TIDAK LAYAK DAUR ULANG</small>
            <p style="margin: 6px 0 0; color: #475569; font-size: 13px; line-height: 1.6;">
                {{ $jenisResidu->alasan }}
            </p>
        </div>
    </div>
</div>
@endsection
