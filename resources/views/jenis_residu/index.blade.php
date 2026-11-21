@extends('layouts.app')

@section('title', 'Daftar Jenis Residu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-tags me-2 text-success"></i>Jenis Residu</h4>
    <a href="{{ route('jenis-residu.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle me-1"></i>Tambah Jenis Residu
    </a>
</div>

{{-- Filter --}}
<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('jenis-residu.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Filter Cara Penanganan</label>
                <select name="cara_penanganan" class="form-select">
                    <option value="">-- Semua --</option>
                    @foreach(['TPA', 'insinerasi', 'lainnya'] as $cp)
                        <option value="{{ $cp }}" {{ request('cara_penanganan') === $cp ? 'selected' : '' }}>
                            {{ ucfirst($cp) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                <a href="{{ route('jenis-residu.index') }}" class="btn btn-link text-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Cara Penanganan</th>
                    <th class="text-end">Biaya/kg</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jenisResidu as $item)
                <tr>
                    <td>{{ $jenisResidu->firstItem() + $loop->index }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>
                        @php
                            $badgeClass = match($item->cara_penanganan) {
                                'TPA' => 'bg-secondary',
                                'insinerasi' => 'bg-danger',
                                'lainnya' => 'bg-warning text-dark',
                                default => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $item->cara_penanganan }}</span>
                    </td>
                    <td class="text-end">Rp {{ number_format($item->biaya_per_kg, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <a href="{{ route('jenis-residu.show', $item) }}" class="btn btn-sm btn-outline-info" title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('jenis-residu.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('jenis-residu.destroy', $item) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus jenis residu ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada data jenis residu.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($jenisResidu->hasPages())
    <div class="card-footer d-flex justify-content-end">
        {{ $jenisResidu->links() }}
    </div>
    @endif
</div>
@endsection
