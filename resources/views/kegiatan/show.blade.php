@extends('layouts.app')

@section('title', 'Detail Kegiatan Penyuluhan')

@section('content')
<div class="mb-3">
    <a href="{{ route('kegiatan.index') }}" class="text-decoration-none text-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
    </a>
</div>

{{-- Kartu Detail Kegiatan --}}
<div class="card shadow-sm mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-megaphone me-2 text-success"></i>{{ $kegiatan->judul }}</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('kegiatan.edit', $kegiatan) }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
            <form action="{{ route('kegiatan.destroy', $kegiatan) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Yakin ingin menghapus kegiatan ini? {{ $kegiatan->peserta_count > 0 ? $kegiatan->peserta_count . " peserta akan ikut terhapus." : "" }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash me-1"></i>Hapus
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Tanggal</dt>
            <dd class="col-sm-9">{{ $kegiatan->tanggal->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Lokasi</dt>
            <dd class="col-sm-9">{{ $kegiatan->lokasi }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                @php
                    $badgeStatus = match($kegiatan->status) {
                        'dijadwalkan' => 'bg-primary',
                        'selesai'     => 'bg-success',
                        'dibatalkan'  => 'bg-danger',
                        default       => 'bg-secondary',
                    };
                @endphp
                <span class="badge {{ $badgeStatus }}">{{ ucfirst($kegiatan->status) }}</span>
            </dd>

            <dt class="col-sm-3">Peserta</dt>
            <dd class="col-sm-9">{{ $kegiatan->peserta_count }}/{{ $kegiatan->kuota }}
                @if($kegiatan->peserta_count >= $kegiatan->kuota)
                    <span class="badge bg-danger ms-1">Kuota Penuh</span>
                @endif
            </dd>

            <dt class="col-sm-3">Hadir</dt>
            <dd class="col-sm-9">{{ $kegiatan->hadir_count }} orang</dd>
        </dl>
    </div>
</div>

{{-- Daftar Peserta --}}
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="bi bi-people me-2"></i>Daftar Peserta</h6>
        <span class="badge bg-secondary">{{ $kegiatan->hadir_count }} hadir</span>
    </div>

    {{-- Form Tambah Peserta (hanya jika dijadwalkan dan kuota belum penuh) --}}
    @if($kegiatan->isDijadwalkan() && $kegiatan->peserta_count < $kegiatan->kuota && $nasabahList->isNotEmpty())
    <div class="card-body border-bottom bg-light">
        <form action="{{ route('peserta.store', $kegiatan) }}" method="POST" class="row g-2 align-items-end">
            @csrf
            <div class="col-md-7">
                <label for="id_nasabah" class="form-label small fw-semibold">Daftarkan Nasabah</label>
                <select id="id_nasabah" name="id_nasabah"
                        class="form-select @error('id_nasabah') is-invalid @enderror" required>
                    <option value="">-- Pilih Nasabah --</option>
                    @foreach($nasabahList as $nasabah)
                        <option value="{{ $nasabah->id }}" {{ old('id_nasabah') == $nasabah->id ? 'selected' : '' }}>
                            {{ $nasabah->nama }} ({{ $nasabah->nik ?? 'No NIK' }})
                        </option>
                    @endforeach
                </select>
                @error('id_nasabah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-person-plus me-1"></i>Daftarkan
                </button>
            </div>
        </form>
    </div>
    @elseif($kegiatan->isDijadwalkan() && $kegiatan->peserta_count >= $kegiatan->kuota)
    <div class="card-body border-bottom">
        <div class="alert alert-warning mb-0">
            <i class="bi bi-exclamation-triangle me-2"></i>Kuota sudah penuh, tidak dapat mendaftarkan peserta baru.
        </div>
    </div>
    @elseif($kegiatan->isDijadwalkan() && $nasabahList->isEmpty())
    <div class="card-body border-bottom">
        <div class="alert alert-info mb-0">
            <i class="bi bi-info-circle me-2"></i>Semua nasabah sudah terdaftar di kegiatan ini.
        </div>
    </div>
    @elseif(! $kegiatan->isDijadwalkan())
    <div class="card-body border-bottom">
        <div class="alert alert-secondary mb-0">
            <i class="bi bi-lock me-2"></i>Pendaftaran peserta ditutup karena kegiatan berstatus "{{ $kegiatan->status }}".
        </div>
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Nasabah</th>
                    <th>NIK</th>
                    <th class="text-center">Status Hadir</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesertaList as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->nasabah->nama }}</td>
                    <td>{{ $p->nasabah->nik ?? '-' }}</td>
                    <td class="text-center">
                        @if($p->hadir)
                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Hadir</span>
                        @else
                            <span class="badge bg-secondary"><i class="bi bi-dash-circle me-1"></i>Belum Hadir</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {{-- Toggle Kehadiran --}}
                        @if(! $kegiatan->isBatalkan())
                        <form action="{{ route('peserta.hadir', $p) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="btn btn-sm {{ $p->hadir ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                    title="{{ $p->hadir ? 'Tandai Tidak Hadir' : 'Tandai Hadir' }}">
                                <i class="bi {{ $p->hadir ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
                            </button>
                        </form>
                        @endif

                        {{-- Keluarkan Peserta --}}
                        <form action="{{ route('peserta.destroy', $p) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin mengeluarkan {{ $p->nasabah->nama }} dari kegiatan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Keluarkan">
                                <i class="bi bi-person-dash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="bi bi-people fs-3 d-block mb-2"></i>Belum ada peserta terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
