@extends('layouts.admin')
@section('title', 'Data Wilayah/RW')
@section('breadcrumb', 'Wilayah/RW')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
            P-10 · MASTER DATA
        </div>
        <h1>Wilayah / RW</h1>
        <p>Kelola cakupan wilayah operasional bank sampah dan pantau jumlah nasabah terdaftar per RW.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('admin.wilayah.create') }}">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Wilayah
    </a>
</div>

<div class="panel">
    <div class="data-toolbar">
        <div>
            <h3>Daftar Wilayah Operasional</h3>
            <p>{{ $wilayah->total() }} wilayah RW terdaftar dalam sistem</p>
        </div>
        <form class="toolbar-actions" method="GET" action="{{ route('admin.wilayah.index') }}">
            <input class="data-search" type="search" name="q" value="{{ $q }}" placeholder="Cari RW atau kelurahan..." style="width: 240px;">
            <button class="btn btn-outline" type="submit">Cari</button>
            @if($q)
                <a class="btn btn-outline" href="{{ route('admin.wilayah.index') }}">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>WILAYAH / RW</th>
                    <th>KELURAHAN</th>
                    <th>JUMLAH NASABAH</th>
                    <th class="align-right">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wilayah as $item)
                    <tr>
                        <td>
                            <div class="table-person">
                                <div class="avatar pastel-green">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
                                </div>
                                <div>
                                    <strong>RW {{ $item->nama_rw }}</strong>
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->kelurahan }}</td>
                        <td>
                            <span class="type-pill" style="background:#f1f5f9; color:#475569;">
                                {{ $item->nasabah_count }} Nasabah
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a class="act-btn view" href="{{ route('admin.wilayah.show', $item) }}" title="Lihat Detail">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <span>Detail</span>
                                </a>
                                <a class="act-btn edit" href="{{ route('admin.wilayah.edit', $item) }}" title="Ubah Data">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                    <span>Edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.wilayah.destroy', $item) }}" onsubmit="return confirm('Hapus wilayah RW {{ addslashes($item->nama_rw) }}?')" style="margin: 0; display: inline-flex;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="act-btn delete" type="submit" title="Hapus Wilayah">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-table">Belum ada data wilayah RW atau pencarian tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($wilayah->hasPages())
        <div class="table-bottom">
            {{ $wilayah->links() }}
        </div>
    @endif
</div>
@endsection
