@extends('layouts.admin')
@section('title', 'Penarikan Saldo')
@section('breadcrumb', 'Penarikan Saldo')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/gracia_p11_p12.css') }}">
@endpush

@section('content')
<div class="page-heading">
    <div>
        <h1>Penarikan Saldo</h1>
        <p>Kelola pengajuan penarikan saldo tabungan nasabah.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('admin.penarikan-saldo.create') }}">＋ Ajukan Penarikan</a>
</div>

@if(session('success'))
    <div class="flash success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="flash error">{{ session('error') }}</div>
@endif

<div class="panel">
    <div class="data-toolbar">
        <div>
            <h3>Daftar Penarikan Saldo</h3>
            <p>{{ $penarikan->total() }} pengajuan terdaftar</p>
        </div>
        <form class="toolbar-actions" method="GET">
            <input class="data-search" type="search" name="q" value="{{ $q }}" placeholder="Cari nama atau NIK nasabah...">
            <select name="status" onchange="this.form.submit()" style="height:36px;border:1px solid #e9eeeb;border-radius:8px;padding:0 10px;font-size:12px;">
                <option value="">Semua Status</option>
                <option value="diajukan"  {{ $status === 'diajukan'  ? 'selected' : '' }}>Diajukan</option>
                <option value="disetujui" {{ $status === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak"   {{ $status === 'ditolak'   ? 'selected' : '' }}>Ditolak</option>
                <option value="selesai"   {{ $status === 'selesai'   ? 'selected' : '' }}>Selesai</option>
            </select>
            <button class="btn btn-outline" type="submit">Cari</button>
            @if($q || $status)
                <a class="btn btn-outline" href="{{ route('admin.penarikan-saldo.index') }}">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>NASABAH</th>
                    <th>METODE</th>
                    <th>JUMLAH</th>
                    <th>STATUS</th>
                    <th>TANGGAL</th>
                    <th class="align-right">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penarikan as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->nasabah->nama }}</strong>
                            <div style="font-size:11px;color:#84918c;margin-top:2px;">NIK {{ $item->nasabah->nik }}</div>
                        </td>
                        <td>{{ $item->metodePenarikan->nama_metode }}</td>
                        <td><strong>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</strong></td>
                        <td>
                            <span class="status {{ $item->statusClass() }}">{{ $item->statusLabel() }}</span>
                        </td>
                        <td style="font-size:11px;color:#84918c;">{{ $item->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="row-actions">
                                <a class="action-btn" href="{{ route('admin.penarikan-saldo.show', $item) }}">Detail</a>
                                @if($item->status === 'diajukan')
                                    <a class="action-btn" href="{{ route('admin.penarikan-saldo.edit', $item) }}">Ubah Status</a>
                                @endif
                                @if($item->bisaDibatalkan())
                                    <form method="POST" action="{{ route('admin.penarikan-saldo.destroy', $item) }}"
                                          data-gracia-confirm="Batalkan pengajuan penarikan Rp {{ number_format($item->jumlah, 0, ',', '.') }}?">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-btn delete" type="submit">Batalkan</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-table">Belum ada pengajuan penarikan atau data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-bottom">
        {{ $penarikan->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/gracia_p11_p12.js') }}"></script>
@endpush
