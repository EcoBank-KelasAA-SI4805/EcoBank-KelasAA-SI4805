@extends('layouts.admin')
@section('title', 'Detail Metode Penarikan')
@section('breadcrumb', 'Metode Penarikan / Detail')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-12 • DETAIL METODE</div>
        <h1>{{ $metode->nama_metode }}</h1>
        <p>Informasi detail jalur dan ketentuan penarikan saldo nasabah.</p>
    </div>
    <div class="heading-actions">
        <a class="btn btn-outline" href="{{ route('admin.metode-penarikan.index') }}">← Daftar</a>
        <a class="btn btn-primary" href="{{ route('admin.metode-penarikan.edit', $metode) }}">Edit metode</a>
    </div>
</div>

@if(session('success'))
    <div class="flash success">{{ session('success') }}</div>
@endif

<div class="panel">
    <div class="detail-grid">
        <div class="detail-item">
            <small>NAMA METODE</small>
            <strong>{{ $metode->nama_metode }}</strong>
        </div>
        <div class="detail-item">
            <small>STATUS</small>
            <strong>{{ $metode->status_aktif ? 'Aktif' : 'Nonaktif' }}</strong>
        </div>
        <div class="detail-item">
            <small>KATEGORI</small>
            <strong>
                @if($metode->kategori === 'transfer')
                    Transfer Bank
                @elseif($metode->kategori === 'ewallet')
                    E-Wallet
                @else
                    Kasir Tunai
                @endif
            </strong>
        </div>
        <div class="detail-item">
            <small>MINIMAL PENARIKAN</small>
            <strong>Rp {{ number_format($metode->minimal_tarik, 0, ',', '.') }}</strong>
        </div>
        <div class="detail-item" style="grid-column: span 2;">
            <small>PETUNJUK / DESKRIPSI</small>
            <p style="margin-top:4px;color:#374151;line-height:1.5;">{{ $metode->deskripsi ?: 'Tidak ada petunjuk khusus.' }}</p>
        </div>
        <div class="detail-item">
            <small>DITAMBAHKAN PADA</small>
            <strong>{{ $metode->created_at?->format('d M Y, H:i') }} WIB</strong>
        </div>
        <div class="detail-item">
            <small>TERAKHIR DIPERBARUI</small>
            <strong>{{ $metode->updated_at?->format('d M Y, H:i') }} WIB</strong>
        </div>
    </div>
</div>
@endsection
