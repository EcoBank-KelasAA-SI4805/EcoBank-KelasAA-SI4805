@extends('layouts.admin')
@section('title', 'Lokasi Drop Point')
@section('breadcrumb', 'Drop Points')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
            P-02 · MANAJEMEN LOKASI SETOR
        </div>
        <h1>Lokasi Drop Point</h1>
        <p>Kelola titik kumpul penyetoran sampah, jam operasional layanan, dan status keaktifan pos.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('admin.drop-points.create') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>Tambah Drop Point Baru</span>
    </a>
</div>

{{-- Mini Stats Bar --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-bottom: 20px;">
    <div class="mini-stat" style="background:#fff; border:1px solid var(--line); border-radius:var(--radius); padding:14px 18px; display:flex; align-items:center; gap:12px;">
        <div class="stat-icon purple"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg></div>
        <div><small style="font-size:10.5px; color:#64748b; font-weight:700;">TOTAL TITIK SETOR</small><strong style="font-size:19px; color:#0f172a; display:block;">{{ $dropPoints->total() }} <span style="font-size:12px; font-weight:500;">titik</span></strong></div>
    </div>
    <div class="mini-stat" style="background:#fff; border:1px solid var(--line); border-radius:var(--radius); padding:14px 18px; display:flex; align-items:center; gap:12px;">
        <div class="stat-icon green"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg></div>
        <div><small style="font-size:10.5px; color:#64748b; font-weight:700;">TITIK BERSTATUS AKTIF</small><strong style="font-size:19px; color:#166534; display:block;">{{ \App\Models\DropPoint::where('status_aktif', true)->count() }} <span style="font-size:12px; font-weight:500;">titik siap melayani</span></strong></div>
    </div>
</div>

<div class="panel">
    <div class="data-toolbar">
        <div>
            <h3>Daftar Drop Point EcoBank</h3>
            <p>{{ $dropPoints->total() }} lokasi terdaftar dalam jaringan</p>
        </div>
        <form class="toolbar-actions" method="GET" action="{{ route('admin.drop-points.index') }}">
            <input class="data-search" type="search" name="q" value="{{ $q }}" placeholder="Cari nama atau alamat pos..." style="width: 240px;">
            <button class="btn btn-outline" type="submit">Cari</button>
            @if($q)
                <a class="btn btn-outline" href="{{ route('admin.drop-points.index') }}">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>NAMA DROP POINT</th>
                    <th>ALAMAT LOKASI</th>
                    <th>JADWAL & JAM OPERASIONAL</th>
                    <th>STATUS LAYANAN</th>
                    <th class="align-right">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dropPoints as $item)
                    <tr>
                        <td>
                            <div class="table-person">
                                <div class="avatar pastel-purple">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                                </div>
                                <div>
                                    <strong>{{ $item->nama }}</strong>
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->alamat }}</td>
                        <td>
                            <span style="display:inline-flex; align-items:center; gap:5px; color:#475569;">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" color="#64748b"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $item->jam_buka }}
                            </span>
                        </td>
                        <td>
                            <span class="status {{ $item->status_aktif ? 'success' : 'inactive' }}">
                                {{ $item->status_aktif ? 'Aktif Melayani' : 'Nonaktif Sementara' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a class="act-btn view" href="{{ route('admin.drop-points.show', $item) }}" title="Lihat Detail">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <span>Detail</span>
                                </a>
                                <a class="act-btn edit" href="{{ route('admin.drop-points.edit', $item) }}" title="Ubah Data">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                    <span>Edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.drop-points.destroy', $item) }}" onsubmit="return confirm('Hapus drop point {{ addslashes($item->nama) }}?')" style="margin: 0; display: inline-flex;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="act-btn delete" type="submit" title="Hapus Drop Point">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-table">Belum ada lokasi drop point atau data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-bottom">
        <div>Menampilkan {{ $dropPoints->count() }} dari {{ $dropPoints->total() }} titik setor</div>
        <div>{{ $dropPoints->links() }}</div>
    </div>
</div>
@endsection
