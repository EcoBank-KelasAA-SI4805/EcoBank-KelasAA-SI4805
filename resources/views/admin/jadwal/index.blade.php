@extends('layouts.admin')
@section('title', 'Jadwal Pengumpulan')
@section('breadcrumb', 'Jadwal Pengumpulan')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            P-09 · MASTER DATA
        </div>
        <h1>Jadwal Pengumpulan</h1>
        <p>Atur jadwal penjemputan sampah per wilayah RW beserta penugasan petugas operasional di lapangan.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('admin.jadwal.create') }}">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Buat Jadwal
    </a>
</div>

<div class="panel">
    <div class="data-toolbar">
        <div>
            <h3>Daftar Agenda Penjemputan</h3>
            <p>{{ $jadwal->total() }} agenda jadwal ditemukan</p>
        </div>
        <form class="toolbar-actions" method="GET" action="{{ route('admin.jadwal.index') }}">
            <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #475569;">
                Dari:
                <input class="data-search" type="date" name="dari" value="{{ $dari }}" style="width: auto;">
            </label>
            <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #475569;">
                Sampai:
                <input class="data-search" type="date" name="sampai" value="{{ $sampai }}" style="width: auto;">
            </label>
            <button class="btn btn-outline" type="submit">Filter</button>
            @if($dari || $sampai)
                <a class="btn btn-outline" href="{{ route('admin.jadwal.index') }}">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>TANGGAL</th>
                    <th>JAM OPERASIONAL</th>
                    <th>WILAYAH / RW</th>
                    <th>PETUGAS LAPANGAN</th>
                    <th>STATUS AGENDA</th>
                    <th class="align-right">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwal as $item)
                    <tr>
                        <td>
                            <strong style="color: #0f172a;">{{ $item->tanggal->format('d M Y') }}</strong>
                        </td>
                        <td>
                            <span style="display:inline-flex; align-items:center; gap:5px; color:#475569;">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" color="#64748b"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $item->jam_hm }} WIB
                            </span>
                        </td>
                        <td>
                            <div>
                                <strong>RW {{ $item->wilayah?->nama_rw }}</strong>
                                <small style="display:block; color:#64748b;">Kel. {{ $item->wilayah?->kelurahan }}</small>
                            </div>
                        </td>
                        <td>
                            <div style="display:inline-flex; align-items:center; gap:6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" color="#16a34a"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <span>{{ $item->petugas?->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="status {{ $item->tanggal->isToday() ? 'pending' : ($item->tanggal->isPast() ? 'inactive' : 'success') }}">
                                {{ $item->tanggal->isToday() ? 'Hari Ini' : ($item->tanggal->isPast() ? 'Selesai' : 'Akan Datang') }}
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a class="act-btn view" href="{{ route('admin.jadwal.show', $item) }}" title="Lihat Detail">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <span>Detail</span>
                                </a>
                                <a class="act-btn edit" href="{{ route('admin.jadwal.edit', $item) }}" title="Ubah Jadwal">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                    <span>Edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.jadwal.destroy', $item) }}" onsubmit="return confirm('Batalkan/hapus jadwal pengumpulan ini?')" style="margin: 0; display: inline-flex;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="act-btn delete" type="submit" title="Batalkan Jadwal">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-table">Belum ada agenda jadwal pengumpulan atau data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($jadwal->hasPages())
        <div class="table-bottom">
            {{ $jadwal->links() }}
        </div>
    @endif
</div>
@endsection
