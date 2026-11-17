@extends('layouts.app')

@section('title', 'Pencatatan Residu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-trash3 me-2 text-success"></i>Pencatatan Residu</h4>
    <a href="{{ route('residu.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle me-1"></i>Catat Residu Baru
    </a>
</div>

{{-- Filter --}}
<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('residu.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Dari Tanggal</label>
                <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Sampai Tanggal</label>
                <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Jenis Residu</label>
                <select name="id_jenis_residu" class="form-select">
                    <option value="">-- Semua Jenis --</option>
                    @foreach($jenisResiduList as $jr)
                        <option value="{{ $jr->id }}" {{ request('id_jenis_residu') == $jr->id ? 'selected' : '' }}>
                            {{ $jr->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                <a href="{{ route('residu.index') }}" class="btn btn-link text-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Ringkasan Total Berat --}}
<div class="alert alert-info d-flex align-items-center mb-3" role="alert">
    <i class="bi bi-bar-chart-fill me-2 fs-5"></i>
    <div>
        <strong>Total Berat (filter aktif):</strong>
        {{ number_format($totalBerat, 2, ',', '.') }} kg
    </div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Asal</th>
                    <th class="text-end">Berat (kg)</th>
                    <th class="text-end">Total Biaya</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($residu as $item)
                <tr>
                    <td>{{ $residu->firstItem() + $loop->index }}</td>
                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $item->jenisResidu->nama ?? '-' }}</td>
                    <td>{{ $item->asal }}</td>
                    <td class="text-end">{{ number_format($item->berat_kg, 2, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $statusClass = match($item->status) {
                                'ditampung' => 'bg-primary',
                                'diangkut'  => 'bg-warning text-dark',
                                'dibuang'   => 'bg-secondary',
                                default     => 'bg-light text-dark',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ ucfirst($item->status) }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('residu.show', $item) }}" class="btn btn-sm btn-outline-info" title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('residu.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($item->status === 'ditampung')
                        <form action="{{ route('residu.destroy', $item) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus data residu ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @else
                        <button class="btn btn-sm btn-outline-danger" disabled title="Tidak bisa dihapus (status: {{ $item->status }})">
                            <i class="bi bi-trash"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada data residu.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($residu->hasPages())
    <div class="card-footer d-flex justify-content-end">
        {{ $residu->links() }}
    </div>
    @endif
</div>
@endsection
