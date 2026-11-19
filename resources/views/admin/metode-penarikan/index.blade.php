@extends('layouts.admin')
@section('title', 'Metode Penarikan')
@section('breadcrumb', 'Metode Penarikan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/gracia_p11_p12.css') }}">
@endpush

@section('content')
<div class="page-heading">
    <div>
        <h1>Metode Penarikan</h1>
        <p>Kelola jalur pencairan saldo nasabah.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('admin.metode-penarikan.create') }}">＋ Tambah Metode</a>
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
            <h3>Daftar Metode Penarikan</h3>
            <p>{{ $metodeList->total() }} metode terdaftar</p>
        </div>
        <form class="toolbar-actions" method="GET">
            <input class="data-search" type="search" name="q" value="{{ $q }}" placeholder="Cari nama atau kategori...">
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
                    <th>Nama Metode</th>
                    <th>Kategori</th>
                    <th>Minimal Tarik</th>
                    <th>Status</th>
                    <th class="align-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($metodeList as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->nama_metode }}</strong>
                            @if($item->deskripsi)
                                <div style="font-size:11px;color:#84918c;margin-top:2px;">{{ Str::limit($item->deskripsi, 60) }}</div>
                            @endif
                        </td>
                        <td>
                            @if($item->kategori === 'transfer')
                                <span class="status info">Transfer Bank</span>
                            @elseif($item->kategori === 'ewallet')
                                <span class="status" style="background:#f5f3ff;color:#6d28d9;">E-Wallet</span>
                            @else
                                <span class="status success">Kasir Tunai</span>
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
                                <form method="POST" action="{{ route('admin.metode-penarikan.destroy', $item) }}"
                                      data-gracia-confirm="Hapus metode {{ addslashes($item->nama_metode) }}?">
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

@push('scripts')
<script src="{{ asset('js/gracia_p11_p12.js') }}"></script>
@endpush
