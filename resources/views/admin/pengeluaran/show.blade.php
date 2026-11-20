@extends('layouts.admin')

@section('title', 'Detail Pengeluaran · EcoBank')
@section('breadcrumb', 'Pengeluaran Operasional / Detail')

@section('content')
<style>
    .detail-container {
        max-width: 820px;
        margin: 0 auto;
    }
    .detail-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        padding: 28px;
    }
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    .amount-highlight-box {
        grid-column: 1 / -1;
        background: #fffbeb;
        border: 1px solid #fde68a;
        padding: 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .detail-actions-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }
    @media (max-width: 640px) {
        .detail-card {
            padding: 18px;
        }
        .detail-grid {
            grid-template-columns: 1fr;
        }
        .detail-actions-footer {
            flex-direction: column-reverse;
            align-items: stretch;
        }
        .detail-actions-footer .btn,
        .detail-actions-footer form,
        .detail-actions-footer form button {
            width: 100%;
        }
    }
</style>

<div class="page-heading">
    <div>
        <div class="eyebrow" style="color: #16865b; font-weight: 700; letter-spacing: 1.2px; font-size: 11px; margin-bottom: 4px;">DETAIL PENGELUARAN</div>
        <h1 style="font: 800 24px/1.3 'Manrope', sans-serif; color: #0f172a; margin: 0 0 4px;">Detail Catatan Pengeluaran</h1>
        <p style="font-size: 12px; color: #64748b; margin: 0;">Rincian pengeluaran kas operasional bank sampah.</p>
    </div>
    <div class="heading-actions" style="display: flex; gap: 8px; flex-wrap: wrap;">
        <a class="btn btn-outline" href="{{ route('admin.pengeluaran.index') }}" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            <span>Daftar Pengeluaran</span>
        </a>
        <a class="btn btn-primary" href="{{ route('admin.pengeluaran.edit', $pengeluaran) }}" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
            <span>Edit Pengeluaran</span>
        </a>
    </div>
</div>

@if(session('success'))
    <div style="margin-bottom: 20px; padding: 12px 18px; background: #ecfdf5; color: #065f46; border-radius: 9px; font-size: 12px; font-weight: 600; border-left: 4px solid #10b981; display: flex; align-items: center; gap: 8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="detail-container">
    <div class="detail-card">
        <div class="detail-grid">
            <div>
                <small style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">TANGGAL TRANSAKSI</small>
                <strong style="font-size: 15px; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" style="color: #64748b;"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    {{ \Carbon\Carbon::parse($pengeluaran->tanggal)->format('d F Y') }}
                </strong>
            </div>

            <div>
                <small style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">KATEGORI BIAYA</small>
                <span style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 6px; display: inline-block;">
                    {{ $pengeluaran->kategori }}
                </span>
            </div>

            <div class="amount-highlight-box">
                <div>
                    <small style="font-size: 11px; font-weight: 700; color: #b45309; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">NOMINAL PENGELUARAN KAS</small>
                    <strong style="font: 800 28px/1 'Manrope', sans-serif; color: #e11d48;">
                        Rp {{ number_format($pengeluaran->nominal, 0, ',', '.') }}
                    </strong>
                </div>
                <div style="font-size: 11px; color: #78350f;">
                    Status: <span style="font-weight: 700;">Tercatat Resmi</span>
                </div>
            </div>

            <div style="grid-column: 1 / -1;">
                <small style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">KETERANGAN / RINCIAN BIAYA</small>
                <div style="background: #fafcfb; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; font-size: 13px; color: #1e293b; line-height: 1.6; white-space: pre-line;">
                    {{ $pengeluaran->keterangan ?: 'Tidak ada keterangan tambahan yang dicantumkan.' }}
                </div>
            </div>

            <div>
                <small style="font-size: 11px; color: #94a3b8; display: block; margin-bottom: 2px;">Ditambahkan pada</small>
                <span style="font-size: 12px; color: #475569; font-weight: 600;">{{ $pengeluaran->created_at ? $pengeluaran->created_at->format('d M Y, H:i') : '—' }}</span>
            </div>

            <div>
                <small style="font-size: 11px; color: #94a3b8; display: block; margin-bottom: 2px;">Terakhir diperbarui</small>
                <span style="font-size: 12px; color: #475569; font-weight: 600;">{{ $pengeluaran->updated_at ? $pengeluaran->updated_at->format('d M Y, H:i') : '—' }}</span>
            </div>
        </div>

        <div class="detail-actions-footer">
            <form method="POST" action="{{ route('admin.pengeluaran.destroy', $pengeluaran) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan pengeluaran ini?')" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline" type="submit" style="color: #e11d48; border-color: #fecdd3; display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18"/>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                    </svg>
                    <span>Hapus Catatan</span>
                </button>
            </form>

            <a class="btn btn-primary" href="{{ route('admin.pengeluaran.edit', $pengeluaran) }}" style="display: inline-flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                <span>Edit Pengeluaran</span>
            </a>
        </div>
    </div>
</div>
@endsection
