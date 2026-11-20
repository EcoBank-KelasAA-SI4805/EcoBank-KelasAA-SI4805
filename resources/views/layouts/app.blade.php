<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoBank - @yield('title', 'Sistem Bank Sampah Digital')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; }
        .navbar-brand { font-weight: 800; color: #16865b !important; letter-spacing: -0.5px; }
        .sidebar { min-height: calc(100vh - 56px); background: #ffffff; border-right: 1px solid #e2e8f0; }
        .sidebar .nav-link { color: #475569; border-radius: 8px; margin-bottom: 3px; font-weight: 500; font-size: 13px; padding: 9px 14px; }
        .sidebar .nav-link:hover { background-color: #f1f5f9; color: #0f172a; }
        .sidebar .nav-link.active { background-color: #eaf7f0; color: #16865b; font-weight: 700; }
        .sidebar .sidebar-heading { font-size: 10px; font-weight: 800; letter-spacing: 0.8px; color: #94a3b8; text-transform: uppercase; padding: 12px 14px 4px; }
        .content-wrapper { padding: 28px; }
    </style>
</head>
<body>
@php
    $isNasabah = Auth::check() && Auth::user()->isNasabah();
    $isAdmin = Auth::check() && Auth::user()->isAdmin();
    $brandUrl = $isNasabah ? route('pengumuman.public') : route('admin.dashboard');
@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-2">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center" href="{{ $brandUrl }}">
            <i class="bi bi-recycle me-2 fs-4 text-success"></i>
            <span>eco<span class="fw-light text-dark">bank</span></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('pengumuman.public') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-megaphone me-1"></i>Papan Pengumuman
                </a>
                @if(Auth::check())
                    <span class="badge bg-light text-dark border px-3 py-2">
                        <i class="bi bi-person-circle me-1 text-success"></i>{{ Auth::user()->name }} ({{ Auth::user()->role }})
                    </span>
                    <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-box-arrow-right me-1"></i>Keluar
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-success">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 p-0 sidebar">
            <nav class="nav flex-column p-3">
                @if($isNasabah)
                    <div class="sidebar-heading">MENU NASABAH</div>
                    <a class="nav-link {{ request()->routeIs('pengumuman.*') ? 'active' : '' }}"
                       href="{{ route('pengumuman.public') }}">
                        <i class="bi bi-megaphone-fill me-2"></i>Papan Info Publik
                    </a>
                @else
                    <div class="sidebar-heading">MENU UTAMA</div>
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-grid-fill me-2"></i>Dashboard
                    </a>

                    <div class="sidebar-heading mt-2">DATA MASTER</div>
                    <a class="nav-link {{ request()->routeIs('admin.nasabah.*') ? 'active' : '' }}"
                       href="{{ route('admin.nasabah.index') }}">
                        <i class="bi bi-people-fill me-2"></i>Data Nasabah
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.drop-points.*') ? 'active' : '' }}"
                       href="{{ route('admin.drop-points.index') }}">
                        <i class="bi bi-geo-alt-fill me-2"></i>Drop Points
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.wilayah.*') ? 'active' : '' }}"
                       href="{{ route('admin.wilayah.index') }}">
                        <i class="bi bi-map-fill me-2"></i>Wilayah/RW
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}"
                       href="{{ route('admin.jadwal.index') }}">
                        <i class="bi bi-calendar-event-fill me-2"></i>Jadwal Pengumpulan
                    </a>

                    <div class="sidebar-heading mt-2">OPERASIONAL</div>
                    <a class="nav-link {{ request()->routeIs('admin.pengeluaran.*') ? 'active' : '' }}"
                       href="{{ route('admin.pengeluaran.index') }}">
                        <i class="bi bi-cash-stack me-2"></i>Pengeluaran
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}"
                       href="{{ route('admin.pengumuman.index') }}">
                        <i class="bi bi-megaphone-fill me-2"></i>Pengumuman
                    </a>
                @endif
            </nav>
        </div>

        <div class="col-md-10 content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
