@extends('layouts.app')

@section('title', 'Daftar Kegiatan Penyuluhan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-megaphone me-2 text-success"></i>Kegiatan Penyuluhan</h4>
    <a href="{{ route('kegiatan.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle me-1"></i>Tambah Kegiatan
    </a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Peserta</th>
                    <th class="text-center">Hadir</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kegiatan as $item)
                <tr>
                    <td>{{ $kegiatan->firstItem() + $loop->index }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td class="text-center">
                        @php
                            $badgeStatus = match($item->status) {
                                'dijadwalkan' => 'bg-primary',
                                'selesai'     => 'bg-success',
                                'dibatalkan'  => 'bg-danger',
                                default       => 'bg-secondary',
                            };
                        @endphp
                        <span class="badge {{ $badgeStatus }}">{{ ucfirst($item->status) }}</span>
                    </td>
                    <td class="text-center">{{ $item->peserta_count }}/{{ $item->kuota }}</td>
                    <td class="text-center">{{ $item->hadir_count }}</td>
                    <td class="text-center">
                        <a href="{{ route('kegiatan.show', $item) }}"
                           class="btn btn-sm btn-outline-info" title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('kegiatan.edit', $item) }}"
                           class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('kegiatan.destroy', $item) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus kegiatan ini? {{ $item->peserta_count > 0 ? $item->peserta_count . " peserta akan ikut terhapus." : "" }}')">
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
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada data kegiatan penyuluhan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($kegiatan->hasPages())
    <div class="card-footer d-flex justify-content-end">
        {{ $kegiatan->links() }}
    </div>
    @endif
</div>
@endsection
