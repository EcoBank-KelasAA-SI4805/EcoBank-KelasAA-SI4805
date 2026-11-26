@extends('layouts.admin')
@section('title', 'Master Jenis Residu')
@section('breadcrumb', 'Jenis Residu')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 5 4 4-10 10H5v-4l10-10z"/><path d="m13 7 4 4"/></svg>
            P-05 · MASTER DATA RESIDU
        </div>
        <h1>Master Jenis Residu</h1>
        <p>Klasifikasi sampah residu yang tidak layak didaur ulang beserta cara penanganan dan tarif biaya pengelolaan.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('jenis-residu.create') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>Tambah Jenis Residu</span>
    </a>
</div>

{{-- Mini Stats Bar --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-bottom: 20px;">
    <div class="mini-stat" style="background:#fff; border:1px solid var(--line); border-radius:var(--radius); padding:14px 18px; display:flex; align-items:center; gap:12px;">
        <div class="stat-icon green"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 5 4 4-10 10H5v-4l10-10z"/></svg></div>
        <div><small style="font-size:10.5px; color:#64748b; font-weight:700;">TOTAL KLASIFIKASI</small><strong style="font-size:19px; color:#0f172a; display:block;">{{ $jenisResidu->total() }} <span style="font-size:12px; font-weight:500;">jenis</span></strong></div>
    </div>
    <div class="mini-stat" style="background:#fff; border:1px solid var(--line); border-radius:var(--radius); padding:14px 18px; display:flex; align-items:center; gap:12px;">
        <div class="stat-icon blue"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/></svg></div>
        <div><small style="font-size:10.5px; color:#64748b; font-weight:700;">PENANGANAN TPA</small><strong style="font-size:19px; color:#1e40af; display:block;">{{ \App\Models\JenisResidu::where('cara_penanganan', 'TPA')->count() }} <span style="font-size:12px; font-weight:500;">jenis</span></strong></div>
    </div>
    <div class="mini-stat" style="background:#fff; border:1px solid var(--line); border-radius:var(--radius); padding:14px 18px; display:flex; align-items:center; gap:12px;">
        <div class="stat-icon orange"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
        <div><small style="font-size:10.5px; color:#64748b; font-weight:700;">PENANGANAN INSINERASI</small><strong style="font-size:19px; color:#9a3412; display:block;">{{ \App\Models\JenisResidu::where('cara_penanganan', 'insinerasi')->count() }} <span style="font-size:12px; font-weight:500;">jenis</span></strong></div>
    </div>
</div>

<div class="panel">
    <div class="data-toolbar">
        <div>
            <h3>Daftar Jenis Residu Terklasifikasi</h3>
            <p>{{ $jenisResidu->total() }} jenis residu aktif</p>
        </div>
        <form class="toolbar-actions" method="GET" action="{{ route('jenis-residu.index') }}">
            <select name="cara_penanganan" style="height: 38px; border: 1px solid var(--line); border-radius: var(--radius); padding: 0 12px; font-size: 12px; color: #334155;">
                <option value="">Semua Cara Penanganan</option>
                @foreach(['TPA', 'insinerasi', 'lainnya'] as $cp)
                    <option value="{{ $cp }}" {{ request('cara_penanganan') === $cp ? 'selected' : '' }}>
                        {{ ucfirst($cp) }}
                    </option>
                @endforeach
            </select>
            <button class="btn btn-outline" type="submit">Filter</button>
            @if(request('cara_penanganan'))
                <a class="btn btn-outline" href="{{ route('jenis-residu.index') }}">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>NAMA RESIDU</th>
                    <th>CARA PENANGANAN</th>
                    <th>TARIF BIAYA / KG</th>
                    <th>ALASAN TIDAK LAYAK DAUR ULANG</th>
                    <th class="align-right">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jenisResidu as $item)
                    <tr>
                        <td>
                            <div class="table-person">
                                <div class="avatar pastel-green">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 5 4 4-10 10H5v-4l10-10z"/></svg>
                                </div>
                                <div>
                                    <strong>{{ $item->nama }}</strong>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $badgeStyle = match($item->cara_penanganan) {
                                    'TPA' => 'background:#dbeafe; color:#1e40af;',
                                    'insinerasi' => 'background:#fee2e2; color:#991b1b;',
                                    default => 'background:#fef3c7; color:#92400e;'
                                };
                            @endphp
                            <span class="type-pill" style="{{ $badgeStyle }} font-weight:700;">
                                {{ ucfirst($item->cara_penanganan) }}
                            </span>
                        </td>
                        <td><strong style="color: #166534; font-size: 13.5px;">Rp {{ number_format($item->biaya_per_kg, 0, ',', '.') }}</strong> <small style="display:inline; color:#64748b;">/ kg</small></td>
                        <td><small style="color: #475569; font-size: 12px;">{{ Str::limit($item->alasan, 55) }}</small></td>
                        <td>
                            <div class="action-group">
                                <a class="act-btn view" href="{{ route('jenis-residu.show', $item) }}" title="Lihat Detail">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <span>Detail</span>
                                </a>
                                <a class="act-btn edit" href="{{ route('jenis-residu.edit', $item) }}" title="Ubah Data">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                    <span>Edit</span>
                                </a>
                                <form method="POST" action="{{ route('jenis-residu.destroy', $item) }}" onsubmit="return confirm('Hapus jenis residu {{ addslashes($item->nama) }}?')" style="margin: 0; display: inline-flex;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="act-btn delete" type="submit" title="Hapus Jenis Residu">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-table">Belum ada data jenis residu atau data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-bottom">
        <div>Menampilkan {{ $jenisResidu->count() }} dari {{ $jenisResidu->total() }} jenis residu</div>
        <div>{{ $jenisResidu->links() }}</div>
    </div>
</div>
@endsection
