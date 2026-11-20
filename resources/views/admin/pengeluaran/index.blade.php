@extends('layouts.admin')

@section('title', 'Pengeluaran Operasional · EcoBank')
@section('breadcrumb', 'Pengeluaran Operasional')

@section('content')
<style>
    .pengeluaran-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }
    .pengeluaran-header h1 {
        font: 800 26px/1.25 'Manrope', sans-serif;
        color: #0f172a;
        margin: 0 0 6px;
        letter-spacing: -0.5px;
    }
    .pengeluaran-header p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
        max-width: 600px;
        line-height: 1.5;
    }
    .btn-create-pengeluaran {
        background: #16865b;
        color: #ffffff;
        font-weight: 600;
        font-size: 12px;
        padding: 10px 18px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(22, 134, 91, 0.22);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid #147952;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .btn-create-pengeluaran:hover {
        background: #116c49;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(22, 134, 91, 0.28);
        color: #ffffff;
    }

    /* KPI Grid */
    .kpi-grid-expense {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px 20px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        position: relative;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.07);
    }
    .kpi-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }
    .kpi-title {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        letter-spacing: 0.2px;
    }
    .kpi-icon-wrap {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .kpi-icon-wrap.amber { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .kpi-icon-wrap.blue { background: #eff6ff; color: #3b82f6; border: 1px solid #dbeafe; }

    .kpi-value {
        font: 800 26px/1 'Manrope', sans-serif;
        color: #0f172a;
        margin-bottom: 6px;
        display: flex;
        align-items: baseline;
        gap: 6px;
    }
    .kpi-value small {
        font: 500 12px 'DM Sans', sans-serif;
        color: #94a3b8;
    }
    .kpi-foot {
        font-size: 11px;
        color: #64748b;
    }
    .kpi-accent {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
    }
    .kpi-accent.amber { background: #f59e0b; }
    .kpi-accent.blue { background: #3b82f6; }

    /* Panel & Filter Bar */
    .data-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }
    .filter-bar {
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .filter-bar-title h3 {
        font: 700 15px 'Manrope', sans-serif;
        color: #0f172a;
        margin: 0 0 2px;
    }
    .filter-bar-title p {
        font-size: 11px;
        color: #64748b;
        margin: 0;
    }
    .filter-bar-form {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .search-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .search-input-wrap svg {
        position: absolute;
        left: 11px;
        pointer-events: none;
        color: #94a3b8;
    }
    .search-input-wrap input {
        height: 38px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 0 12px 0 34px;
        font-size: 12px;
        color: #0f172a;
        background: #ffffff;
        transition: all 0.15s ease;
        width: 190px;
    }
    .search-input-wrap input:focus,
    .filter-bar-form select:focus,
    .filter-bar-form input[type="date"]:focus {
        outline: none;
        border-color: #16865b;
        box-shadow: 0 0 0 3px rgba(22, 134, 91, 0.15);
    }
    .filter-bar-form select,
    .filter-bar-form input[type="date"] {
        height: 38px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 0 10px;
        font-size: 12px;
        color: #334155;
        background: #ffffff;
        transition: all 0.15s ease;
    }
    .date-range-container {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .btn-filter-submit {
        height: 38px;
        padding: 0 14px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        color: #334155;
        font-weight: 600;
        font-size: 12px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-filter-submit:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a;
    }
    .btn-filter-reset {
        height: 38px;
        padding: 0 12px;
        border: 1px solid transparent;
        background: transparent;
        color: #64748b;
        font-weight: 600;
        font-size: 12px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .btn-filter-reset:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    /* Desktop Table Layout */
    .table-responsive-desktop {
        display: block;
        width: 100%;
        overflow-x: auto;
    }
    .expense-table {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
        white-space: normal;
    }
    .expense-table thead th {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 16px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        color: #64748b;
        text-transform: uppercase;
        text-align: left;
    }
    .expense-table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 12px;
        color: #334155;
        vertical-align: middle;
        white-space: normal;
        word-break: break-word;
    }
    .expense-table tbody tr:hover td {
        background-color: #fcfdfc;
    }

    /* Action buttons */
    .action-group {
        display: inline-flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
        width: 100%;
        flex-wrap: nowrap;
    }
    .act-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s ease;
        border: 1px solid transparent;
        cursor: pointer;
        white-space: nowrap !important;
        word-break: keep-all !important;
        flex-shrink: 0 !important;
        line-height: 1.2;
    }
    .act-btn.view {
        background: #f8fafc;
        border-color: #e2e8f0;
        color: #334155;
    }
    .act-btn.view:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #0f172a;
    }
    .act-btn.edit {
        background: #eef2ff;
        border-color: #e0e7ff;
        color: #4338ca;
    }
    .act-btn.edit:hover {
        background: #e0e7ff;
        border-color: #c7d2fe;
        color: #3730a3;
    }
    .act-btn.delete {
        background: #fff;
        border-color: #fecdd3;
        color: #e11d48;
    }
    .act-btn.delete:hover {
        background: #fff1f2;
        border-color: #fda4af;
        color: #be123c;
    }

    /* Category Pill */
    .category-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 9px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        white-space: nowrap;
    }

    /* Mobile Cards View */
    .mobile-cards-view {
        display: none;
        padding: 12px;
        gap: 12px;
        background: #fafcfb;
    }
    .mobile-expense-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        box-shadow: 0 1px 4px rgba(15, 23, 42, 0.04);
    }
    .mobile-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .mobile-card-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }
    .mobile-card-actions .act-btn {
        flex: 1;
        height: 38px;
        justify-content: center;
        font-size: 12px;
        border-radius: 8px;
    }

    /* --- TAMPILAN RESPONSIVE MOBILE TINGKAT TINGGI (< 768px) --- */
    @media (max-width: 767px) {
        .table-responsive-desktop {
            display: none !important;
        }
        .mobile-cards-view {
            display: flex !important;
            flex-direction: column;
        }
        .pengeluaran-header {
            flex-direction: column;
            align-items: stretch !important;
            gap: 12px;
            margin-bottom: 16px;
        }
        .pengeluaran-header h1 {
            font-size: 21px !important;
            line-height: 1.25;
        }
        .pengeluaran-header p {
            font-size: 12px !important;
            line-height: 1.4;
        }
        .btn-create-pengeluaran {
            width: 100% !important;
            justify-content: center;
            height: 42px;
            font-size: 13px !important;
        }

        /* KPI cards: 2 kolom compact berdampingan, bukan numpuk raksasa */
        .kpi-grid-expense {
            grid-template-columns: 1fr 1fr !important;
            gap: 10px !important;
            margin-bottom: 16px !important;
        }
        .kpi-card {
            padding: 12px 14px !important;
            min-height: auto !important;
            border-radius: 10px !important;
        }
        .kpi-top {
            margin-bottom: 8px !important;
        }
        .kpi-title {
            font-size: 11px !important;
        }
        .kpi-icon-wrap {
            width: 28px !important;
            height: 28px !important;
            border-radius: 7px !important;
        }
        .kpi-icon-wrap svg {
            width: 14px !important;
            height: 14px !important;
        }
        .kpi-value {
            font-size: 16px !important;
            margin-bottom: 3px !important;
            line-height: 1.2 !important;
        }
        .kpi-foot {
            font-size: 9px !important;
            line-height: 1.3 !important;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Filter bar di mobile */
        .filter-bar {
            flex-direction: column;
            align-items: stretch;
            padding: 14px !important;
        }
        .filter-bar-form {
            flex-direction: column;
            align-items: stretch;
            width: 100%;
            gap: 10px;
        }
        .search-input-wrap,
        .search-input-wrap input {
            width: 100% !important;
            height: 40px !important;
        }
        .filter-bar-form select {
            width: 100% !important;
            height: 40px !important;
        }
        .date-range-container {
            display: grid !important;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            width: 100%;
        }
        .date-range-container span {
            display: none !important;
        }
        .date-range-container input[type="date"] {
            width: 100% !important;
            height: 40px !important;
            font-size: 12px !important;
            padding: 0 8px !important;
        }
        .btn-filter-submit {
            width: 100% !important;
            height: 42px !important;
            justify-content: center;
            font-size: 13px !important;
        }
        .btn-filter-reset {
            width: 100% !important;
            height: 38px !important;
            justify-content: center;
            border: 1px solid #cbd5e1 !important;
        }
    }

    /* Empty State */
    .empty-expense-box {
        text-align: center;
        padding: 56px 20px;
        color: #64748b;
    }
    .empty-expense-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: #f1f5f9;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
    }
    .empty-expense-box strong {
        font: 700 15px 'Manrope', sans-serif;
        color: #1e293b;
        display: block;
        margin-bottom: 4px;
    }
    .empty-expense-box p {
        font-size: 12px;
        color: #64748b;
        margin: 0 0 16px;
    }
</style>

<div class="pengeluaran-header">
    <div>
        <div class="eyebrow" style="color: #16865b; font-weight: 700; letter-spacing: 1.2px; font-size: 11px; margin-bottom: 4px;">P-13 · MASTER DATA OPERASIONAL</div>
        <h1>Pengeluaran Operasional</h1>
        <p>Kelola, pantau, dan catat riwayat pengeluaran kas operasional bank sampah.</p>
    </div>
    <a class="btn-create-pengeluaran" href="{{ route('admin.pengeluaran.create') }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        <span>Catat Pengeluaran</span>
    </a>
</div>

@if(session('success'))
    <div style="margin-bottom: 18px; padding: 12px 18px; background: #ecfdf5; color: #065f46; border-radius: 9px; font-size: 12px; font-weight: 600; border-left: 4px solid #10b981; display: flex; align-items: center; gap: 8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div style="margin-bottom: 18px; padding: 12px 18px; background: #fff1f2; color: #9f1239; border-radius: 9px; font-size: 12px; font-weight: 600; border-left: 4px solid #f43f5e; display: flex; align-items: center; gap: 8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
        <span>{{ session('error') }}</span>
    </div>
@endif

{{-- Quick Metric Cards (2 Kolom kompak di Mobile) --}}
<div class="kpi-grid-expense">
    <article class="kpi-card">
        <div class="kpi-top">
            <span class="kpi-title">Total Kas Keluar</span>
            <div class="kpi-icon-wrap amber">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="14" x="2" y="5" rx="2"/>
                    <line x1="2" x2="22" y1="10" y2="10"/>
                </svg>
            </div>
        </div>
        <div class="kpi-value" style="color: #b45309;">
            Rp {{ number_format($totalNominal ?? 0, 0, ',', '.') }}
        </div>
        <div class="kpi-foot">Akumulasi pengeluaran kas</div>
        <div class="kpi-accent amber"></div>
    </article>

    <article class="kpi-card">
        <div class="kpi-top">
            <span class="kpi-title">Total Transaksi</span>
            <div class="kpi-icon-wrap blue">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" x2="8" y1="13" y2="13"/>
                    <line x1="16" x2="8" y1="17" y2="17"/>
                </svg>
            </div>
        </div>
        <div class="kpi-value">
            {{ $totalTransaksi ?? 0 }} <small>transaksi</small>
        </div>
        <div class="kpi-foot" style="color: #2563eb; font-weight: 600;">Tercatat resmi di sistem</div>
        <div class="kpi-accent blue"></div>
    </article>
</div>

<div class="data-panel">
    {{-- Filter Toolbar --}}
    <div class="filter-bar">
        <div class="filter-bar-title">
            <h3>Daftar Pengeluaran</h3>
            <p>{{ $pengeluaran->total() }} catatan pengeluaran ditemukan</p>
        </div>

        <form class="filter-bar-form" method="GET" action="{{ route('admin.pengeluaran.index') }}">
            <div class="search-input-wrap">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.3-4.3"/>
                </svg>
                <input type="search" name="q" value="{{ $q }}" placeholder="Cari rincian / keterangan...">
            </div>
            
            <select name="kategori">
                <option value="Semua">Semua Kategori</option>
                @foreach($daftarKategori as $kat)
                    <option value="{{ $kat }}" {{ $kategori === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>

            <div class="date-range-container">
                <input type="date" name="start_date" value="{{ $startDate }}" title="Tanggal awal">
                <span style="color: #94a3b8; font-size: 11px;">—</span>
                <input type="date" name="end_date" value="{{ $endDate }}" title="Tanggal akhir">
            </div>

            <button class="btn-filter-submit" type="submit">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                </svg>
                <span>Filter</span>
            </button>

            @if($q || ($kategori && $kategori !== 'Semua') || $startDate || $endDate)
                <a class="btn-filter-reset" href="{{ route('admin.pengeluaran.index') }}">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                    <span>Reset Filter</span>
                </a>
            @endif
        </form>
    </div>

    {{-- Desktop Table View --}}
    <div class="table-responsive-desktop">
        <table class="expense-table">
            <colgroup>
                <col style="width: 16%;">
                <col style="width: 18%;">
                <col style="width: 28%;">
                <col style="width: 18%;">
                <col style="width: 20%; min-width: 190px;">
            </colgroup>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th style="text-align: right;">Nominal</th>
                    <th style="text-align: right; min-width: 190px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengeluaran as $item)
                    <tr>
                        <td>
                            <strong style="color: #0f172a; font-size: 12px; display: flex; align-items: center; gap: 5px;">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" style="color: #64748b;"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </strong>
                            <small style="color: #64748b; font-size: 11px; margin-top: 2px;">{{ \Carbon\Carbon::parse($item->tanggal)->diffForHumans() }}</small>
                        </td>
                        <td>
                            <span class="category-pill">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td>
                            <span style="color: #334155; font-size: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.45;">
                                {{ $item->keterangan ?: '—' }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <strong style="color: #e11d48; font-size: 13px; font-family: 'Manrope', sans-serif;">
                                Rp {{ number_format($item->nominal, 0, ',', '.') }}
                            </strong>
                        </td>
                        <td>
                            <div class="action-group">
                                <a class="act-btn view" href="{{ route('admin.pengeluaran.show', $item) }}" title="Lihat Detail">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <span>Detail</span>
                                </a>
                                <a class="act-btn edit" href="{{ route('admin.pengeluaran.edit', $item) }}" title="Edit Pengeluaran">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                        <path d="m15 5 4 4"/>
                                    </svg>
                                    <span>Edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.pengeluaran.destroy', $item) }}" onsubmit="return confirm('Hapus catatan pengeluaran sebesar Rp {{ number_format($item->nominal, 0, ',', '.') }}?')" style="margin: 0; display: inline-flex; flex-shrink: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="act-btn delete" type="submit" title="Hapus Pengeluaran">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 6h18"/>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                            <line x1="10" x2="10" y1="11" y2="17"/>
                                            <line x1="14" x2="14" y1="11" y2="17"/>
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-expense-box">
                                <div class="empty-expense-icon">
                                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="20" height="14" x="2" y="5" rx="2"/>
                                        <line x1="2" x2="22" y1="10" y2="10"/>
                                    </svg>
                                </div>
                                <strong>Belum Ada Catatan Pengeluaran</strong>
                                <p>Gunakan tombol "Catat Pengeluaran" di atas untuk menambahkan transaksi baru.</p>
                                @if($q || ($kategori && $kategori !== 'Semua') || $startDate || $endDate)
                                    <a class="act-btn view" href="{{ route('admin.pengeluaran.index') }}" style="display: inline-flex;">Reset Filter</a>
                                @else
                                    <a class="btn-create-pengeluaran" href="{{ route('admin.pengeluaran.create') }}" style="display: inline-flex;">Catat Pengeluaran Baru</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile Cards View (Tampil Otomatis di Layar Handphone) --}}
    <div class="mobile-cards-view">
        @forelse($pengeluaran as $item)
            <div class="mobile-expense-card">
                <div class="mobile-card-top">
                    <span class="category-pill">{{ $item->kategori }}</span>
                    <strong style="color: #e11d48; font-size: 14px; font-family: 'Manrope', sans-serif;">
                        Rp {{ number_format($item->nominal, 0, ',', '.') }}
                    </strong>
                </div>

                <div style="font-size: 11px; color: #64748b; display: flex; align-items: center; gap: 5px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    <span>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }} &bull; {{ \Carbon\Carbon::parse($item->tanggal)->diffForHumans() }}</span>
                </div>

                @if($item->keterangan)
                    <div style="font-size: 12px; color: #334155; line-height: 1.5; background: #f8fafc; padding: 8px 10px; border-radius: 6px; border: 1px solid #f1f5f9;">
                        {{ $item->keterangan }}
                    </div>
                @endif

                <div class="mobile-card-actions">
                    <a class="act-btn view" href="{{ route('admin.pengeluaran.show', $item) }}">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        <span>Detail</span>
                    </a>
                    <a class="act-btn edit" href="{{ route('admin.pengeluaran.edit', $item) }}">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                        <span>Edit</span>
                    </a>
                    <form method="POST" action="{{ route('admin.pengeluaran.destroy', $item) }}" onsubmit="return confirm('Hapus catatan pengeluaran sebesar Rp {{ number_format($item->nominal, 0, ',', '.') }}?')" style="margin: 0; flex: 1; display: flex;">
                        @csrf
                        @method('DELETE')
                        <button class="act-btn delete" type="submit" style="width: 100%;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                            <span>Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-expense-box">
                <div class="empty-expense-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="14" x="2" y="5" rx="2"/>
                        <line x1="2" x2="22" y1="10" y2="10"/>
                    </svg>
                </div>
                <strong>Belum Ada Catatan Pengeluaran</strong>
                <p>Gunakan tombol "Catat Pengeluaran" di atas untuk menambahkan transaksi baru.</p>
                @if($q || ($kategori && $kategori !== 'Semua') || $startDate || $endDate)
                    <a class="act-btn view" href="{{ route('admin.pengeluaran.index') }}" style="display: inline-flex;">Reset Filter</a>
                @else
                    <a class="btn-create-pengeluaran" href="{{ route('admin.pengeluaran.create') }}" style="display: inline-flex;">Catat Pengeluaran Baru</a>
                @endif
            </div>
        @endforelse
    </div>

    @if($pengeluaran->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid #e2e8f0; background: #ffffff;">
            {{ $pengeluaran->links() }}
        </div>
    @endif
</div>
@endsection
