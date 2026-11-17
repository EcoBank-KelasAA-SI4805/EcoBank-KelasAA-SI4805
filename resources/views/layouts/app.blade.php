<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoBank - @yield('title', 'Sistem Bank Sampah Digital')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: 700; color: #198754 !important; }
        .sidebar { min-height: calc(100vh - 56px); background: #fff; border-right: 1px solid #dee2e6; }
        .sidebar .nav-link { color: #495057; border-radius: 6px; margin-bottom: 2px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #d1e7dd; color: #0f5132; }
        .content-wrapper { padding: 24px; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="/"><i class="bi bi-recycle me-2"></i>EcoBank</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 p-0 sidebar">
            <nav class="nav flex-column p-3">
                <span class="text-muted small fw-semibold mb-1 mt-2">RESIDU</span>
                <a class="nav-link {{ request()->routeIs('jenis-residu.*') ? 'active' : '' }}"
                   href="{{ route('jenis-residu.index') }}">
                    <i class="bi bi-tags me-2"></i>Jenis Residu
                </a>
                <a class="nav-link {{ request()->routeIs('residu.*') ? 'active' : '' }}"
                   href="{{ route('residu.index') }}">
                    <i class="bi bi-trash3 me-2"></i>Pencatatan Residu
                </a>
                {{-- TODO: tambahkan menu fitur anggota lain di sini --}}
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
