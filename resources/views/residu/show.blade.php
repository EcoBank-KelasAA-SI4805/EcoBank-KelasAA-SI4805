@extends('layouts.admin')
@section('title', 'Detail Catatan Residu · ' . ($residu->jenisResidu->nama ?? 'Residu'))
@section('breadcrumb', 'Pencatatan Residu / Detail')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-06 · OPERASIONAL RESIDU</div>
        <h1>Detail Catatan Residu</h1>
        <p>Rincian data sampah residu yang disetorkan dan total biaya penanganan.</p>
    </div>
    <div class="heading-actions">
        <a class="btn btn-outline" href="{{ route('residu.index') }}">← Daftar Residu</a>
        <a class="btn btn-primary" href="{{ route('residu.edit', $residu) }}">Edit Catatan</a>
    </div>
</div>

<div class="panel" style="max-width: 800px;">
    <div class="detail-grid">
        <div class="detail-item">
            <small>TANGGAL PENIMBANGAN</small>
            <strong style="font-size: 15px;">{{ $residu->tanggal ? $residu->tanggal->format('d M Y') : '-' }}</strong>
        </div>
        <div class="detail-item">
            <small>STATUS PENANGANAN</small>
            <div>
                @php
                    $statusStyle = match($residu->status) {
                        'ditampung' => 'background:#eaf2ff; color:#3b82f6;',
                        'diangkut'  => 'background:#fff6e8; color:#d97706;',
                        'dibuang'   => 'background:#f1f5f9; color:#475569;',
                        default     => 'background:#f1f5f9; color:#475569;',
                    };
                @endphp
                <span class="type-pill" style="{{ $statusStyle }} font-weight: 700;">
                    {{ ucfirst($residu->status) }}
                </span>
            </div>
        </div>
        <div class="detail-item">
            <small>JENIS RESIDU</small>
            <strong style="font-size: 15px;">{{ $residu->jenisResidu->nama ?? '-' }}</strong>
        </div>
        <div class="detail-item">
            <small>ASAL SAMPAH (WILAYAH)</small>
            <strong>{{ $residu->asal }}</strong>
        </div>
        <div class="detail-item">
            <small>BERAT TERTIMBANG</small>
            <strong style="font-size: 16px;">{{ number_format($residu->berat_kg, 2, ',', '.') }} kg</strong>
        </div>
        <div class="detail-item">
            <small>TARIF BIAYA PER KG</small>
            <strong>Rp {{ number_format($residu->biaya_per_kg, 0, ',', '.') }}</strong>
        </div>
        <div class="detail-item" style="grid-column: 1 / -1; background: #f8fafc; padding: 14px 18px; border-radius: 10px; border: 1px solid #e2e8f0;">
            <small style="font-weight: 700; color: #64748b;">TOTAL BIAYA PENANGANAN</small>
            <strong style="color: #16865b; font-size: 22px; display: block; margin-top: 4px;">Rp {{ number_format($residu->total_biaya, 0, ',', '.') }}</strong>
        </div>
        <div class="detail-item">
            <small>DICATAT PADA</small>
            <strong>{{ $residu->created_at ? $residu->created_at->format('d M Y, H:i') : '-' }}</strong>
        </div>
        <div class="detail-item">
            <small>TERAKHIR DIPERBARUI</small>
            <strong>{{ $residu->updated_at ? $residu->updated_at->format('d M Y, H:i') : '-' }}</strong>
        </div>
    </div>
</div>
@endsection
