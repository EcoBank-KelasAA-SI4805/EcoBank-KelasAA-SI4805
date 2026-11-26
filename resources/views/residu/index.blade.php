@extends('layouts.admin')
@section('title', 'Pencatatan Sampah Residu')
@section('breadcrumb', 'Pencatatan Residu')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/></svg>
            P-06 · PENCATATAN OPERASIONAL RESIDU
        </div>
        <h1>Pencatatan Sampah Residu</h1>
        <p>Pencatatan sampah residu masuk, penimbangan berat, kalkulasi biaya penanganan otomatis, dan pelacakan status.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('residu.create') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>Catat Residu Baru</span>
    </a>
</div>

{{-- Mini Stats Bar --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-bottom: 20px;">
    <div class="mini-stat" style="background:#fff; border:1px solid var(--line); border-radius:var(--radius); padding:14px 18px; display:flex; align-items:center; gap:12px;">
        <div class="stat-icon green"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
        <div><small style="font-size:10.5px; color:#64748b; font-weight:700;">TOTAL BERAT (FILTER AKTIF)</small><strong style="font-size:20px; color:#166534; display:block;">{{ number_format($totalBerat, 2, ',', '.') }} <span style="font-size:13px; font-weight:500;">kg</span></strong></div>
    </div>
    <div class="mini-stat" style="background:#fff; border:1px solid var(--line); border-radius:var(--radius); padding:14px 18px; display:flex; align-items:center; gap:12px;">
        <div class="stat-icon orange"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/></svg></div>
        <div><small style="font-size:10.5px; color:#64748b; font-weight:700;">TOTAL BIAYA PENANGANAN</small><strong style="font-size:20px; color:#c2410c; display:block;">Rp {{ number_format(\App\Models\Residu::sum('total_biaya'), 0, ',', '.') }}</strong></div>
    </div>
    <div class="mini-stat" style="background:#fff; border:1px solid var(--line); border-radius:var(--radius); padding:14px 18px; display:flex; align-items:center; gap:12px;">
        <div class="stat-icon blue"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/></svg></div>
        <div><small style="font-size:10.5px; color:#64748b; font-weight:700;">STATUS DITAMPUNG</small><strong style="font-size:20px; color:#1e40af; display:block;">{{ \App\Models\Residu::where('status', 'ditampung')->count() }} <span style="font-size:12px; font-weight:500;">entri</span></strong></div>
    </div>
</div>

<div class="panel">
    <div class="data-toolbar" style="flex-wrap: wrap; gap: 14px;">
        <div>
            <h3>Daftar Pencatatan Residu</h3>
            <p>{{ $residu->total() }} data penimbangan residu tercatat</p>
        </div>
        <form class="toolbar-actions" method="GET" action="{{ route('residu.index') }}" style="flex-wrap: wrap;">
            <input type="date" name="dari" value="{{ request('dari') }}" class="date-input" title="Dari Tanggal">
            <span style="color:#94a3b8;">—</span>
            <input type="date" name="sampai" value="{{ request('sampai') }}" class="date-input" title="Sampai Tanggal">

            <select name="id_jenis_residu" style="height: 38px; border: 1px solid var(--line); border-radius: var(--radius); padding: 0 10px; font-size: 12px; color: #334155;">
                <option value="">Semua Jenis Residu</option>
                @foreach($jenisResiduList as $jr)
                    <option value="{{ $jr->id }}" {{ request('id_jenis_residu') == $jr->id ? 'selected' : '' }}>
                        {{ $jr->nama }}
                    </option>
                @endforeach
            </select>
            <button class="btn btn-outline" type="submit">Filter Data</button>
            @if(request('dari') || request('sampai') || request('id_jenis_residu'))
                <a class="btn btn-outline" href="{{ route('residu.index') }}">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>TANGGAL</th>
                    <th>JENIS RESIDU</th>
                    <th>ASAL SAMPAH (WILAYAH)</th>
                    <th>BERAT (KG)</th>
                    <th>TOTAL BIAYA</th>
                    <th>STATUS PENANGANAN</th>
                    <th class="align-right">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($residu as $item)
                    <tr>
                        <td>{{ $item->tanggal ? $item->tanggal->format('d M Y') : '-' }}</td>
                        <td>
                            <strong>{{ $item->jenisResidu->nama ?? '-' }}</strong>
                        </td>
                        <td><small style="color: #475569; font-size: 12px;">{{ $item->asal }}</small></td>
                        <td><strong style="font-size: 13.5px;">{{ number_format($item->berat_kg, 2, ',', '.') }} kg</strong></td>
                        <td><strong style="color: #c2410c; font-size: 13.5px;">Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</strong></td>
                        <td>
                            @php
                                $statusStyle = match($item->status) {
                                    'ditampung' => 'background:#dbeafe; color:#1e40af;',
                                    'diangkut'  => 'background:#fef3c7; color:#92400e;',
                                    'dibuang'   => 'background:#f1f5f9; color:#475569;',
                                    default     => 'background:#f1f5f9; color:#475569;',
                                };
                            @endphp
                            <span class="type-pill" style="{{ $statusStyle }} font-weight: 700;">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a class="act-btn view" href="{{ route('residu.show', $item) }}" title="Lihat Detail">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <span>Detail</span>
                                </a>
                                <a class="act-btn edit" href="{{ route('residu.edit', $item) }}" title="Ubah Data">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                    <span>Edit</span>
                                </a>
                                @if($item->status === 'ditampung')
                                    <form method="POST" action="{{ route('residu.destroy', $item) }}" onsubmit="return confirm('Hapus pencatatan residu tanggal {{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '' }}?')" style="margin: 0; display: inline-flex;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="act-btn delete" type="submit" title="Hapus Residu">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-table">Belum ada pencatatan residu atau data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-bottom">
        <div>Menampilkan {{ $residu->count() }} dari {{ $residu->total() }} entri pencatatan</div>
        <div>{{ $residu->links() }}</div>
    </div>
</div>
@endsection
