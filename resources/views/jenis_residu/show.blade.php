@extends('layouts.app')

@section('title', 'Detail Jenis Residu')

@section('content')
<div class="mb-3">
    <a href="{{ route('jenis-residu.index') }}" class="text-decoration-none text-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
    </a>
</div>

<div class="card shadow-sm" style="max-width: 640px;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-info-circle me-2 text-info"></i>Detail Jenis Residu</h5>
        <a href="{{ route('jenis-residu.edit', $jenisResidu) }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
    </div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-4">Nama</dt>
            <dd class="col-sm-8">{{ $jenisResidu->nama }}</dd>

            <dt class="col-sm-4">Cara Penanganan</dt>
            <dd class="col-sm-8">
                @php
                    $badgeClass = match($jenisResidu->cara_penanganan) {
                        'TPA' => 'bg-secondary',
                        'insinerasi' => 'bg-danger',
                        'lainnya' => 'bg-warning text-dark',
                        default => 'bg-secondary'
                    };
                @endphp
                <span class="badge {{ $badgeClass }}">{{ $jenisResidu->cara_penanganan }}</span>
            </dd>

            <dt class="col-sm-4">Biaya/kg</dt>
            <dd class="col-sm-8">Rp {{ number_format($jenisResidu->biaya_per_kg, 0, ',', '.') }}</dd>

            <dt class="col-sm-4">Alasan</dt>
            <dd class="col-sm-8">{{ $jenisResidu->alasan }}</dd>

            <dt class="col-sm-4">Dibuat</dt>
            <dd class="col-sm-8">{{ $jenisResidu->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-4">Diperbarui</dt>
            <dd class="col-sm-8">{{ $jenisResidu->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@endsection
