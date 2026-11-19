@extends('layouts.admin')
@section('title', 'Metode Penarikan')
@section('breadcrumb', 'Metode Penarikan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/gracia_p11_p12.css') }}">
@endpush

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-12 • METODE PENARIKAN</div>
        <h1>Metode Penarikan</h1>
        <p>Kelola jalur pencairan saldo tabungan nasabah (Transfer Bank, E-Wallet, dan Kasir Tunai).</p>
    </div>
    <a class="btn btn-primary" href="{{ route('admin.metode-penarikan.create') }}">＋ Tambah metode</a>
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
            <h3>Daftar metode penarikan</h3>
            <p>{{ $metodeList->total() }} metode terdaftar</p>
        </div>
        <form class="toolbar-actions" method="GET">
            <input class="data-search" type="search" name="q" value="{{ $q }}" placeholder="Cari nama atau kategori metode...">
            <button class="btn btn-outline" type="submit">Cari</button>
            @if($q)
                <a class="btn btn-outline" href="{{ route('admin.metode-penarikan.index') }}">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>NAMA METODE</th>
                    <th>KATEGORI</th>
                    <th>MINIMAL TARIK</th>
                    <th>STATUS</th>
                    <th class="align-right">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($metodeList as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->nama_metode }}</strong>
                            @if($item->deskripsi)
                                <div style="font-size:12px;color:#6b7280;margin-top:2px;">{{ Str::limit($item->deskripsi, 60) }}</div>
                            @endif
                        </td>
                        <td>
                            @if($item->kategori === 'transfer')
                                <span style="display:inline-block;padding:2px 8px;border-radius:6px;font-size:12px;font-weight:600;background:#eff6ff;color:#1d4ed8;">Transfer Bank</span>
                            @elseif($item->kategori === 'ewallet')
                                <span style="display:inline-block;padding:2px 8px;border-radius:6px;font-size:12px;font-weight:600;background:#f5f3ff;color:#6d28d9;">E-Wallet</span>
                            @else
                                <span style="display:inline-block;padding:2px 8px;border-radius:6px;font-size:12px;font-weight:600;background:#ecfdf5;color:#047857;">Kasir Tunai</span>
                            @endif
                        </td>
                        <td><strong>Rp {{ number_format($item->minimal_tarik, 0, ',', '.') }}</strong></td>
                        <td>
                            <span class="status {{ $item->status_aktif ? 'success' : 'inactive' }}">
                                {{ $item->status_aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="row-actions">
                                <a class="action-btn" href="{{ route('admin.metode-penarikan.show', $item) }}">Detail</a>
                                <a class="action-btn" href="{{ route('admin.metode-penarikan.edit', $item) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.metode-penarikan.destroy', $item) }}" onsubmit="return confirm('Hapus metode penarikan {{ addslashes($item->nama_metode) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="action-btn delete" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-table">Belum ada metode penarikan atau data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-bottom">
        {{ $metodeList->links() }}
    </div>
</div>
@endsection
