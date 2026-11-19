@extends('layouts.admin')
@section('title', 'Detail Penarikan Saldo')
@section('breadcrumb', 'Penarikan Saldo / Detail')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/gracia_p11_p12.css') }}">
@endpush

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-16 • DETAIL PENARIKAN</div>
        <h1>Penarikan #{{ $penarikanSaldo->id }}</h1>
        <p>Detail pengajuan penarikan saldo nasabah.</p>
    </div>
    <div class="heading-actions">
        <a class="btn btn-outline" href="{{ route('admin.penarikan-saldo.index') }}">← Daftar</a>
        @if($penarikanSaldo->status === 'diajukan')
            <a class="btn btn-primary" href="{{ route('admin.penarikan-saldo.edit', $penarikanSaldo) }}">Ubah Status</a>
        @endif
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
            <small>NASABAH</small>
            <strong>{{ $penarikanSaldo->nasabah->nama }}</strong>
        </div>
        <div class="detail-item">
            <small>NIK</small>
            <strong>{{ $penarikanSaldo->nasabah->nik }}</strong>
        </div>
        <div class="detail-item">
            <small>METODE PENARIKAN</small>
            <strong>{{ $penarikanSaldo->metodePenarikan->nama_metode }}</strong>
        </div>
        <div class="detail-item">
            <small>JUMLAH PENARIKAN</small>
            <strong>Rp {{ number_format($penarikanSaldo->jumlah, 0, ',', '.') }}</strong>
        </div>
        <div class="detail-item">
            <small>STATUS</small>
            <span class="status {{ $penarikanSaldo->statusClass() }}" style="margin-top:4px;display:inline-flex;">
                {{ $penarikanSaldo->statusLabel() }}
            </span>
        </div>
        <div class="detail-item">
            <small>SALDO NASABAH SAAT INI</small>
            <strong style="color:#15803d;">Rp {{ number_format($penarikanSaldo->nasabah->saldo, 0, ',', '.') }}</strong>
        </div>
        <div class="detail-item detail-full">
            <small>CATATAN PETUGAS</small>
            <p>{{ $penarikanSaldo->catatan ?: 'Tidak ada catatan.' }}</p>
        </div>
        <div class="detail-item">
            <small>TANGGAL PENGAJUAN</small>
            <strong>{{ $penarikanSaldo->created_at->format('d M Y, H:i') }} WIB</strong>
        </div>
        <div class="detail-item">
            <small>TERAKHIR DIPERBARUI</small>
            <strong>{{ $penarikanSaldo->updated_at->format('d M Y, H:i') }} WIB</strong>
        </div>
    </div>
</div>

@if($penarikanSaldo->bisaDibatalkan())
<div style="margin-top:12px;">
    <form method="POST" action="{{ route('admin.penarikan-saldo.destroy', $penarikanSaldo) }}"
          onsubmit="return confirm('Batalkan pengajuan penarikan ini?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit">Batalkan Pengajuan</button>
    </form>
</div>
@endif
@endsection
