@extends('layouts.admin')
@section('title', 'Data Nasabah')
@section('breadcrumb', 'Data Nasabah')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            P-01 · MANAJEMEN DATA NASABAH
        </div>
        <h1>Data Nasabah</h1>
        <p>Kelola identitas warga, nomor kontak, RW domisili, dan pantau saldo tabungan sampah.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('admin.nasabah.create') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>Tambah Nasabah Baru</span>
    </a>
</div>

{{-- Mini Stats Bar --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-bottom: 20px;">
    <div class="mini-stat" style="background:#fff; border:1px solid var(--line); border-radius:var(--radius); padding:14px 18px; display:flex; align-items:center; gap:12px;">
        <div class="stat-icon blue"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
        <div><small style="font-size:10.5px; color:#64748b; font-weight:700;">TOTAL NASABAH</small><strong style="font-size:19px; color:#0f172a; display:block;">{{ $nasabah->total() }} <span style="font-size:12px; font-weight:500;">warga</span></strong></div>
    </div>
    <div class="mini-stat" style="background:#fff; border:1px solid var(--line); border-radius:var(--radius); padding:14px 18px; display:flex; align-items:center; gap:12px;">
        <div class="stat-icon green"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/></svg></div>
        <div><small style="font-size:10.5px; color:#64748b; font-weight:700;">TOTAL SALDO SIMPANAN</small><strong style="font-size:19px; color:#166534; display:block;">Rp {{ number_format(\App\Models\Nasabah::sum('saldo'), 0, ',', '.') }}</strong></div>
    </div>
</div>

<div class="panel">
    <div class="data-toolbar">
        <div>
            <h3>Daftar Nasabah Terdaftar</h3>
            <p>{{ $nasabah->total() }} nasabah dalam database</p>
        </div>
        <form class="toolbar-actions" method="GET" action="{{ route('admin.nasabah.index') }}">
            <input class="data-search" type="search" name="q" value="{{ $q }}" placeholder="Cari nama, NIK, atau no HP..." style="width: 240px;">
            <button class="btn btn-outline" type="submit">Cari</button>
            @if($q)
                <a class="btn btn-outline" href="{{ route('admin.nasabah.index') }}">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>NAMA NASABAH</th>
                    <th>NIK</th>
                    <th>NO. WHATSAPP / HP</th>
                    <th>RW</th>
                    <th>SALDO TABUNGAN</th>
                    <th class="align-right">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nasabah as $item)
                    <tr>
                        <td>
                            <div class="table-person">
                                <div class="avatar pastel-green">
                                    {{ strtoupper(substr($item->nama, 0, 2)) }}
                                </div>
                                <div>
                                    <strong>{{ $item->nama }}</strong>
                                    <small>{{ $item->alamat }}</small>
                                </div>
                            </div>
                        </td>
                        <td><code style="background:#f1f5f9; padding:2px 6px; border-radius:4px; font-size:11.5px; color:#334155;">{{ $item->nik }}</code></td>
                        <td>
                            <span style="display:inline-flex; align-items:center; gap:5px;">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" color="#16a34a"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                {{ $item->no_hp }}
                            </span>
                        </td>
                        <td><span class="type-pill" style="background:#f1f5f9; color:#475569;">RW {{ $item->rw }}</span></td>
                        <td><strong style="color: #166534; font-size: 13.5px;">Rp {{ number_format($item->saldo, 0, ',', '.') }}</strong></td>
                        <td>
                            <div class="action-group">
                                <a class="act-btn view" href="{{ route('admin.nasabah.show', $item) }}" title="Lihat Detail">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <span>Detail</span>
                                </a>
                                <a class="act-btn edit" href="{{ route('admin.nasabah.edit', $item) }}" title="Ubah Data">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                    <span>Edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.nasabah.destroy', $item) }}" onsubmit="return confirm('Hapus data nasabah {{ addslashes($item->nama) }}?')" style="margin: 0; display: inline-flex;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="act-btn delete" type="submit" title="Hapus Nasabah">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-table">Belum ada data nasabah atau data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-bottom">
        <div>Menampilkan {{ $nasabah->count() }} dari {{ $nasabah->total() }} nasabah</div>
        <div>{{ $nasabah->links() }}</div>
    </div>
</div>
@endsection
