@extends('layouts.admin')
@section('title', 'Katalog Reward')
@section('breadcrumb', 'Katalog Reward')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/gracia_p11_p12.css') }}">
@endpush

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">P-11 • REWARD DAN POIN</div>
        <h1>Katalog Reward</h1>
        <p>Kelola daftar reward dan produk daur ulang yang dapat ditukar oleh nasabah.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('admin.rewards.create') }}">＋ Tambah reward</a>
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
            <h3>Daftar reward</h3>
            <p>{{ $rewards->total() }} reward terdaftar</p>
        </div>
        <form class="toolbar-actions" method="GET">
            <input class="data-search" type="search" name="q" value="{{ $q }}" placeholder="Cari nama atau deskripsi reward...">
            <button class="btn btn-outline" type="submit">Cari</button>
            @if($q)
                <a class="btn btn-outline" href="{{ route('admin.rewards.index') }}">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>NAMA REWARD</th>
                    <th>POIN DIBUTUHKAN</th>
                    <th>STOK TERSEDIA</th>
                    <th>STATUS</th>
                    <th class="align-right">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rewards as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->nama_reward }}</strong>
                            @if($item->deskripsi)
                                <div style="font-size:12px;color:#6b7280;margin-top:2px;">{{ Str::limit($item->deskripsi, 60) }}</div>
                            @endif
                        </td>
                        <td><strong>{{ number_format($item->poin_harga, 0, ',', '.') }}</strong> poin</td>
                        <td>
                            @if($item->stok > 0)
                                <span style="font-weight:600;color:#047857;">{{ $item->stok }} unit</span>
                            @else
                                <span style="font-weight:600;color:#dc2626;">Habis</span>
                            @endif
                        </td>
                        <td>
                            <span class="status {{ $item->status_aktif ? 'success' : 'inactive' }}">
                                {{ $item->status_aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="row-actions">
                                <a class="action-btn" href="{{ route('admin.rewards.show', $item) }}">Detail</a>
                                <a class="action-btn" href="{{ route('admin.rewards.edit', $item) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.rewards.destroy', $item) }}" onsubmit="return confirm('Hapus reward {{ addslashes($item->nama_reward) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="action-btn delete" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-table">Belum ada katalog reward atau data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-bottom">
        {{ $rewards->links() }}
    </div>
</div>
@endsection
