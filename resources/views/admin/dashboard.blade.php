@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('breadcrumb', 'Dashboard')
@section('content')
<div class="page-heading">
    <div><div class="eyebrow">OVERVIEW</div><h1>Dashboard</h1><p>Selamat datang kembali, Hasbi. Ini ringkasan aktivitas bank sampah.</p></div>
    <div class="heading-actions"><div class="date-chip">◷ <span id="todayLabel">Memuat tanggal...</span></div><button class="btn btn-primary" onclick="showToast('Data dashboard diperbarui')">↻ <span>Refresh data</span></button></div>
</div>

<div class="filter-row">
    <div><strong>Ringkasan aktivitas</strong><span class="muted">Pantau performa EcoBank berdasarkan periode</span></div>
    <div class="filter-controls"><label for="periodFilter">Periode</label><select id="periodFilter"><option value="month">Bulan ini</option><option value="today">Hari ini</option><option value="week">Minggu ini</option><option value="year">Tahun ini</option></select><input type="date" id="startDate" class="date-input" aria-label="Tanggal awal"><span class="muted">—</span><input type="date" id="endDate" class="date-input" aria-label="Tanggal akhir"><button class="btn btn-outline btn-sm" id="applyDate">Terapkan</button></div>
</div>

<div class="stats-grid">
    <article class="stat-card"><div class="stat-top"><span>Total sampah terkumpul</span><span class="stat-icon green">♻</span></div><div class="stat-value" id="totalWaste">8.450 <small>kg</small></div><div class="stat-foot positive">↗ 12,8% <span>dari periode sebelumnya</span></div><div class="stat-accent green-accent"></div></article>
    <article class="stat-card"><div class="stat-top"><span>Jumlah setoran</span><span class="stat-icon blue">⇩</span></div><div class="stat-value" id="totalDeposits">1.284 <small>transaksi</small></div><div class="stat-foot positive">↗ 8,2% <span>dari periode sebelumnya</span></div><div class="stat-accent blue-accent"></div></article>
    <article class="stat-card"><div class="stat-top"><span>Total nilai setoran</span><span class="stat-icon purple">↗</span></div><div class="stat-value" id="depositValue">Rp 42,8jt</div><div class="stat-foot positive">↗ 10,4% <span>dari periode sebelumnya</span></div><div class="stat-accent purple-accent"></div></article>
    <article class="stat-card"><div class="stat-top"><span>Total penarikan</span><span class="stat-icon orange">↗</span></div><div class="stat-value" id="withdrawValue">Rp 18,6jt</div><div class="stat-foot neutral">Saldo bersih <b id="netBalance">Rp 24,2jt</b></div><div class="stat-accent orange-accent"></div></article>
</div>

<div class="charts-grid">
    <article class="panel chart-panel"><div class="panel-heading"><div><h3>Komposisi sampah</h3><p>Total berat sampah berdasarkan jenis</p></div><button class="more-button" aria-label="Menu">···</button></div><div class="chart-wrap doughnut-wrap"><canvas id="wasteChart"></canvas><div class="chart-center"><strong>8.450</strong><span>Total kg</span></div></div><div class="legend-grid" id="wasteLegend"></div></article>
    <article class="panel chart-panel"><div class="panel-heading"><div><h3>Perputaran saldo</h3><p>Perbandingan total setoran dan penarikan</p></div><span class="legend-inline"><i class="dot deposit"></i> Setoran <i class="dot withdraw"></i> Penarikan</span></div><div class="bar-summary"><div><small>Total setoran</small><strong id="chartDeposit">Rp 42,8 jt</strong></div><div><small>Total penarikan</small><strong id="chartWithdraw">Rp 18,6 jt</strong></div></div><div class="chart-wrap bar-wrap"><canvas id="cashflowChart"></canvas></div></article>
</div>

<div class="panel activity-panel"><div class="panel-heading"><div><h3>Aktivitas terbaru</h3><p>Transaksi terakhir yang tercatat di EcoBank</p></div><a class="text-link" href="{{ route('admin.transactions') }}">Lihat semua →</a></div><div class="table-scroll"><table><thead><tr><th>NASABAH</th><th>JENIS AKTIVITAS</th><th>TANGGAL</th><th>BERAT / NOMINAL</th><th>STATUS</th></tr></thead><tbody>
<tr><td><div class="table-person"><div class="avatar pastel-green">AP</div><div><strong>Andi Pratama</strong><small>EC-000124</small></div></div></td><td><span class="type-pill deposit-type">Setoran sampah</span></td><td>11 Nov 2026, 09:42</td><td><strong>12,5 kg</strong><small>Rp 62.500</small></td><td><span class="status success">Selesai</span></td></tr>
<tr><td><div class="table-person"><div class="avatar pastel-blue">SR</div><div><strong>Siti Rahma</strong><small>EC-000098</small></div></div></td><td><span class="type-pill withdraw-type">Penarikan saldo</span></td><td>11 Nov 2026, 09:15</td><td><strong>—</strong><small>Rp 150.000</small></td><td><span class="status success">Selesai</span></td></tr>
<tr><td><div class="table-person"><div class="avatar pastel-yellow">BP</div><div><strong>Budi Permana</strong><small>EC-000143</small></div></div></td><td><span class="type-pill deposit-type">Setoran sampah</span></td><td>11 Nov 2026, 08:50</td><td><strong>8 kg</strong><small>Rp 40.000</small></td><td><span class="status pending">Diproses</span></td></tr>
<tr><td><div class="table-person"><div class="avatar pastel-purple">DW</div><div><strong>Dewi Wulandari</strong><small>EC-000076</small></div></div></td><td><span class="type-pill deposit-type">Setoran sampah</span></td><td>10 Nov 2026, 15:24</td><td><strong>15 kg</strong><small>Rp 87.500</small></td><td><span class="status success">Selesai</span></td></tr>
</tbody></table></div></div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => initDashboard());
</script>
@endpush
