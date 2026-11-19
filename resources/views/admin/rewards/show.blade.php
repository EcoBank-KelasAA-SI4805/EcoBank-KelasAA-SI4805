@extends('layouts.admin')
@section('title', 'Detail Reward')
@section('breadcrumb', 'Katalog Reward / Detail')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-11 • DETAIL REWARD</div>
        <h1>{{ $reward->nama_reward }}</h1>
        <p>Informasi detail reward dan stok penukaran nasabah.</p>
    </div>
    <div class="heading-actions">
        <a class="btn btn-outline" href="{{ route('admin.rewards.index') }}">← Daftar</a>
        <a class="btn btn-primary" href="{{ route('admin.rewards.edit', $reward) }}">Edit reward</a>
    </div>
</div>

@if(session('success'))
    <div class="flash success">{{ session('success') }}</div>
@endif

<div class="panel">
    <div class="detail-grid">
        <div class="detail-item">
            <small>NAMA REWARD</small>
            <strong>{{ $reward->nama_reward }}</strong>
        </div>
        <div class="detail-item">
            <small>STATUS REWARD</small>
            <strong>{{ $reward->status_aktif ? 'Aktif' : 'Nonaktif' }}</strong>
        </div>
        <div class="detail-item">
            <small>POIN DIBUTUHKAN</small>
            <strong>{{ number_format($reward->poin_harga, 0, ',', '.') }} Poin</strong>
        </div>
        <div class="detail-item">
            <small>SISA STOK</small>
            <strong>{{ $reward->stok }} Unit</strong>
        </div>
        <div class="detail-item" style="grid-column: span 2;">
            <small>DESKRIPSI</small>
            <p style="margin-top:4px;color:#374151;line-height:1.5;">{{ $reward->deskripsi ?: 'Tidak ada deskripsi tambahan.' }}</p>
        </div>
        <div class="detail-item">
            <small>DITAMBAHKAN PADA</small>
            <strong>{{ $reward->created_at?->format('d M Y, H:i') }} WIB</strong>
        </div>
        <div class="detail-item">
            <small>TERAKHIR DIPERBARUI</small>
            <strong>{{ $reward->updated_at?->format('d M Y, H:i') }} WIB</strong>
        </div>
    </div>
</div>
@endsection
