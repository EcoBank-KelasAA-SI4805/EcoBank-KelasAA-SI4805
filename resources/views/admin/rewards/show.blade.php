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
@if(session('error'))
    <div class="flash error">{{ session('error') }}</div>
@endif

<div class="panel">
    <div class="detail-grid">
        <div class="detail-item">
            <small>NAMA REWARD</small>
            <strong>{{ $reward->nama_reward }}</strong>
        </div>
        <div class="detail-item">
            <small>STATUS</small>
            <span class="status {{ $reward->status_aktif ? 'success' : 'inactive' }}" style="margin-top:4px;display:inline-flex;">
                {{ $reward->status_aktif ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>
        <div class="detail-item">
            <small>POIN DIBUTUHKAN</small>
            <strong>{{ number_format($reward->poin_harga, 0, ',', '.') }} poin</strong>
        </div>
        <div class="detail-item">
            <small>SISA STOK</small>
            @if($reward->stok > 0)
                <strong style="color:#065f46;">{{ $reward->stok }} unit</strong>
            @else
                <strong style="color:#be123c;">Habis</strong>
            @endif
        </div>
        <div class="detail-item detail-full">
            <small>DESKRIPSI</small>
            <p>{{ $reward->deskripsi ?: 'Tidak ada deskripsi tambahan.' }}</p>
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
