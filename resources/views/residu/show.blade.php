@extends('layouts.app')

@section('title', 'Detail Residu')

@section('content')
<div class="mb-3">
    <a href="{{ route('residu.index') }}" class="text-decoration-none text-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
    </a>
</div>

<div class="card shadow-sm" style="max-width: 640px;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-info-circle me-2 text-info"></i>Detail Residu</h5>
        <a href="{{ route('residu.edit', $residu) }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
    </div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-5">Tanggal</dt>
            <dd class="col-sm-7">{{ $residu->tanggal->format('d/m/Y') }}</dd>

            <dt class="col-sm-5">Jenis Residu</dt>
            <dd class="col-sm-7">{{ $residu->jenisResidu->nama ?? '-' }}</dd>

            <dt class="col-sm-5">Asal</dt>
            <dd class="col-sm-7">{{ $residu->asal }}</dd>

            <dt class="col-sm-5">Berat</dt>
            <dd class="col-sm-7">{{ number_format($residu->berat_kg, 2, ',', '.') }} kg</dd>

            <dt class="col-sm-5">Biaya/kg (saat dicatat)</dt>
            <dd class="col-sm-7">Rp {{ number_format($residu->biaya_per_kg, 0, ',', '.') }}</dd>

            <dt class="col-sm-5">Total Biaya</dt>
            <dd class="col-sm-7"><strong>Rp {{ number_format($residu->total_biaya, 0, ',', '.') }}</strong></dd>

            <dt class="col-sm-5">Status</dt>
            <dd class="col-sm-7">
                @php
                    $statusClass = match($residu->status) {
                        'ditampung' => 'bg-primary',
                        'diangkut'  => 'bg-warning text-dark',
                        'dibuang'   => 'bg-secondary',
                        default     => 'bg-light text-dark',
                    };
                @endphp
                <span class="badge {{ $statusClass }}">{{ ucfirst($residu->status) }}</span>
            </dd>

            <dt class="col-sm-5">Dicatat</dt>
            <dd class="col-sm-7">{{ $residu->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-5">Diperbarui</dt>
            <dd class="col-sm-7">{{ $residu->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@endsection
