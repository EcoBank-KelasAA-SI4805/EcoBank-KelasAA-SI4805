@extends('layouts.admin')
@section('title', 'Dashboard Utama · EcoBank')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
            OVERVIEW OPERASIONAL ECOBANK
        </div>
        <h1>Dashboard Utama</h1>
        <p>Selamat datang kembali, <strong>{{ Auth::check() ? (Auth::user()->nama ?? Auth::user()->name) : 'Admin' }}</strong>. Pantau aktivitas nasabah, keuangan, drop point, dan pengumuman.</p>
    </div>
    <div class="heading-actions">
        <div class="date-chip">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span id="todayLabel">Memuat tanggal...</span>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 21h5v-5"/></svg>
            <span>Perbarui Data</span>
        </a>
    </div>
</div>

{{-- 4 Stat Cards Utama dari Database --}}
<div class="stats-grid">
    <article class="stat-card">
        <div class="stat-top">
            <span>NASABAH TERDAFTAR</span>
            <div class="stat-icon blue">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
        <div class="stat-value" id="totalDeposits">{{ $totalNasabah }} <small>warga terdaftar</small></div>
        <div class="stat-foot neutral">
            <span>Total Saldo: <b>Rp {{ number_format($totalSaldoNasabah, 0, ',', '.') }}</b></span>
        </div>
        <div class="stat-accent blue-accent"></div>
    </article>

    <article class="stat-card">
        <div class="stat-top">
            <span>DROP POINTS & JARINGAN</span>
            <div class="stat-icon purple">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
        </div>
        <div class="stat-value">{{ $totalDropPointsAktif }} <small>titik setor aktif</small></div>
        <div class="stat-foot positive">
            <span>Dari total {{ $totalDropPoints }} titik lokasi</span>
        </div>
        <div class="stat-accent purple-accent"></div>
    </article>

    <article class="stat-card">
        <div class="stat-top">
            <span>PENGELUARAN OPERASIONAL</span>
            <div class="stat-icon orange">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
            </div>
        </div>
        <div class="stat-value" id="withdrawValue">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        <div class="stat-foot neutral">
            <span>Total kas keluar operasional</span>
        </div>
        <div class="stat-accent orange-accent"></div>
    </article>

    <article class="stat-card">
        <div class="stat-top">
            <span>PENGUMUMAN & EDUKASI</span>
            <div class="stat-icon green">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-5v12L3 13v-2z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
            </div>
        </div>
        <div class="stat-value">{{ $totalPengumuman }} <small>informasi aktif</small></div>
        <div class="stat-foot positive">
            <span>Tersinkron ke Papan Pengumuman Publik</span>
        </div>
        <div class="stat-accent green-accent"></div>
    </article>
</div>

{{-- Pintas Modul EcoBank yang Saling Terhubung --}}
<div style="margin-bottom: 26px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
        <h3 style="font: 800 16px 'Manrope', sans-serif; color: #0f172a; margin: 0;">Pintas Akses Modul Terintegrasi</h3>
        <span style="font-size: 12px; color: var(--muted);">Semua modul aktif dan tersinkronisasi</span>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 14px;">
        <a href="{{ route('admin.nasabah.index') }}" class="panel" style="padding: 16px; display: flex; align-items: center; gap: 14px; text-decoration: none; transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);">
            <div class="stat-icon blue" style="width: 40px; height: 40px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div>
                <strong style="color: #0f172a; font-size: 13.5px; display: block;">Data Nasabah</strong>
                <small style="color: #64748b; font-size: 11.5px;">P-01 · {{ $totalNasabah }} Terdaftar</small>
            </div>
        </a>

        <a href="{{ route('admin.drop-points.index') }}" class="panel" style="padding: 16px; display: flex; align-items: center; gap: 14px; text-decoration: none; transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);">
            <div class="stat-icon purple" style="width: 40px; height: 40px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div>
                <strong style="color: #0f172a; font-size: 13.5px; display: block;">Drop Points</strong>
                <small style="color: #64748b; font-size: 11.5px;">P-02 · {{ $totalDropPointsAktif }} Lokasi Aktif</small>
            </div>
        </a>

        <a href="{{ route('admin.pengeluaran.index') }}" class="panel" style="padding: 16px; display: flex; align-items: center; gap: 14px; text-decoration: none; transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);">
            <div class="stat-icon orange" style="width: 40px; height: 40px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/></svg>
            </div>
            <div>
                <strong style="color: #0f172a; font-size: 13.5px; display: block;">Pengeluaran</strong>
                <small style="color: #64748b; font-size: 11.5px;">P-13 · Kas Operasional</small>
            </div>
        </a>

        <a href="{{ route('admin.pengumuman.index') }}" class="panel" style="padding: 16px; display: flex; align-items: center; gap: 14px; text-decoration: none; transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);">
            <div class="stat-icon green" style="width: 40px; height: 40px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 11 18-5v12L3 13v-2z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
            </div>
            <div>
                <strong style="color: #0f172a; font-size: 13.5px; display: block;">Kelola Pengumuman</strong>
                <small style="color: #64748b; font-size: 11.5px;">P-14 · {{ $totalPengumuman }} Informasi</small>
            </div>
        </a>
    </div>
</div>

{{-- Charts Grid --}}
<div class="charts-grid">
    <article class="panel chart-panel" style="grid-column: 1 / -1;">
        <div class="panel-heading" style="padding: 0 0 16px;">
            <div>
                <h3>Arus Kas & Operasional</h3>
                <p>Perbandingan simpanan tabungan nasabah dengan biaya pengeluaran operasional</p>
            </div>
            <span class="legend-inline">
                <i class="dot deposit"></i> Simpanan Nasabah 
                <i class="dot withdraw"></i> Pengeluaran
            </span>
        </div>
        <div class="bar-summary">
            <div>
                <small>Total Saldo Nasabah</small>
                <strong id="chartDeposit">Rp {{ number_format($totalSaldoNasabah, 0, ',', '.') }}</strong>
            </div>
            <div>
                <small>Pengeluaran Operasional</small>
                <strong id="chartWithdraw">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong>
            </div>
        </div>
        <div class="chart-wrap bar-wrap">
            <canvas id="cashflowChart"></canvas>
        </div>
    </article>
</div>

{{-- Dua Panel Tabel Terbaru --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(420px, 1fr)); gap: 20px; margin-bottom: 24px;">
    {{-- Tabel Nasabah Terbaru --}}
    <div class="panel">
        <div class="panel-heading">
            <div>
                <h3>Nasabah Terdaftar</h3>
                <p>Warga yang baru bergabung dalam bank sampah</p>
            </div>
            <a class="btn btn-outline btn-sm" href="{{ route('admin.nasabah.index') }}">Kelola Nasabah →</a>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>NASABAH</th>
                        <th>NIK</th>
                        <th>RW</th>
                        <th>SALDO SIMPANAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nasabahTerbaru as $n)
                        <tr>
                            <td>
                                <div class="table-person">
                                    <div class="avatar pastel-green">{{ strtoupper(substr($n->nama ?? $n->name, 0, 2)) }}</div>
                                    <div>
                                        <strong>{{ $n->nama ?? $n->name }}</strong>
                                        <small>{{ $n->no_hp }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $n->nik }}</td>
                            <td>RW {{ $n->rw }}</td>
                            <td><strong style="color: #166534;">Rp {{ number_format($n->saldo, 0, ',', '.') }}</strong></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="empty-table">Belum ada nasabah terdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tabel Pengeluaran Operasional Terkini --}}
    <div class="panel">
        <div class="panel-heading">
            <div>
                <h3>Pengeluaran Operasional Terakhir</h3>
                <p>Pencatatan kas keluar untuk keperluan operasional</p>
            </div>
            <a class="btn btn-outline btn-sm" href="{{ route('admin.pengeluaran.index') }}">Lihat Semua →</a>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>TANGGAL</th>
                        <th>KATEGORI</th>
                        <th>NOMINAL</th>
                        <th>KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengeluaranTerbaru as $p)
                        <tr>
                            <td>{{ $p->tanggal ? $p->tanggal->format('d M Y') : '-' }}</td>
                            <td><span class="type-pill withdraw-type">{{ $p->kategori }}</span></td>
                            <td><strong style="color: #b91c1c;">Rp {{ number_format($p->nominal, 0, ',', '.') }}</strong></td>
                            <td><small>{{ Str::limit($p->keterangan, 36) }}</small></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="empty-table">Belum ada catatan pengeluaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Baris Pengumuman --}}
<div style="margin-bottom: 24px;">
    <div class="panel">
        <div class="panel-heading">
            <div>
                <h3>Pengumuman & Edukasi Aktif</h3>
                <p>Informasi yang dipublikasikan ke warga</p>
            </div>
            <a class="btn btn-outline btn-sm" href="{{ route('admin.pengumuman.index') }}">Kelola Pengumuman →</a>
        </div>
        <div style="padding: 16px 22px; display: flex; flex-direction: column; gap: 14px;">
            @forelse($pengumumanTerbaru as $peng)
                <div style="border-left: 3px solid var(--green); padding-left: 14px;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 3px;">
                        <strong style="color: #0f172a; font-size: 13.5px;">{{ $peng->judul }}</strong>
                        <small style="color: #64748b; font-size: 11px;">{{ $peng->tanggal_tayang ? $peng->tanggal_tayang->format('d M Y') : '-' }}</small>
                    </div>
                    <p style="margin: 0; color: #475569; font-size: 12px; line-height: 1.45;">
                        {{ Str::limit($peng->isi, 95) }}
                    </p>
                    <a href="{{ route('admin.pengumuman.show', $peng) }}" style="font-size: 11.5px; color: var(--green); font-weight: 700; display: inline-block; margin-top: 4px;">Lihat selengkapnya ↗</a>
                </div>
            @empty
                <p class="empty-table">Belum ada pengumuman.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof initDashboard === 'function') {
        initDashboard();
    }
});
</script>
@endpush
