<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · EcoBank</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ecobank.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="app-shell">
    <aside class="sidebar" id="sidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}">
            <span class="brand-mark"><span></span><span></span><span></span></span>
            <span>eco<span class="brand-light">bank</span><small>Waste management system</small></span>
        </a>
        <div class="side-label">MENU UTAMA</div>
        <nav class="side-nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') || request()->path() === '/' ? 'active' : '' }}"><span class="nav-icon">▦</span>Dashboard</a>
            <a href="{{ route('admin.nasabah.index') }}" class="{{ request()->routeIs('admin.nasabah.*') ? 'active' : '' }}"><span class="nav-icon">♟</span>Data Nasabah</a>
            <a href="{{ route('admin.drop-points.index') }}" class="{{ request()->routeIs('admin.drop-points.*') ? 'active' : '' }}"><span class="nav-icon">⌖</span>Drop Point</a>
            <a href="{{ route('admin.rewards.index') }}" class="{{ request()->routeIs('admin.rewards.*') ? 'active' : '' }}"><span class="nav-icon">✦</span>Katalog Reward</a>
            <a href="{{ route('admin.metode-penarikan.index') }}" class="{{ request()->routeIs('admin.metode-penarikan.*') ? 'active' : '' }}"><span class="nav-icon">▭</span>Metode Penarikan</a>
            <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}"><span class="nav-icon">♙</span>Kelola Pengguna</a>
            <a href="{{ route('admin.transactions') }}" class="{{ request()->routeIs('admin.transactions') ? 'active' : '' }}"><span class="nav-icon">⇄</span>Transaksi</a>
            <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}"><span class="nav-icon">▤</span>Laporan</a>
        </nav>
        <div class="sidebar-bottom">
            <div class="help-card"><div class="help-icon">✦</div><strong>Butuh bantuan?</strong><p>Hubungi tim dukungan EcoBank jika mengalami kendala.</p><a href="mailto:support@ecobank.test">Hubungi support ↗</a></div>
            <div class="profile-mini"><div class="avatar">HM</div><div><strong>Hasbi Admin</strong><small>Administrator</small></div><span class="profile-more">···</span></div>
        </div>
    </aside>

    <main class="main-area">
        <header class="topbar">
            <button class="mobile-menu" id="mobileMenu" aria-label="Buka menu">☰</button>
            <div class="breadcrumb">EcoBank <span>/</span> @yield('breadcrumb', 'Dashboard')</div>
            <div class="top-actions"><button class="icon-button" aria-label="Notifikasi">♧<i></i></button><div class="top-user"><div class="avatar small">HM</div><span>Hasbi Muhammad</span><b>⌄</b></div></div>
        </header>
        <section class="page-content">@yield('content')</section>
        <footer class="footer">© {{ date('Y') }} EcoBank · Sistem Informasi Bank Sampah</footer>
    </main>
</div>
<div class="toast" id="toast" role="status"></div>
<script src="{{ asset('js/ecobank.js') }}"></script>
@stack('scripts')
</body>
</html>
