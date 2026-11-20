<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · EcoBank</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ecobank.css') }}?v={{ filemtime(public_path('css/ecobank.css')) }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .flash-container { margin-bottom: 20px; }
        .flash-msg {
            padding: 14px 18px;
            border-radius: var(--radius);
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow-sm);
        }
        .flash-msg.success { background: #dcfce7; color: #166534; border-left: 4px solid #16a34a; }
        .flash-msg.error { background: #fee2e2; color: #991b1b; border-left: 4px solid #dc2626; }
        .close-flash { background: none; border: none; font-size: 18px; cursor: pointer; opacity: 0.6; line-height: 1; }
        .close-flash:hover { opacity: 1; }
        .role-badge.role-guest { background: #f1f5f9; color: #475569; }
    </style>
</head>
<body>
@php
    $isNasabah = Auth::check() && Auth::user()->isNasabah();
    $isAdmin = Auth::check() && Auth::user()->isAdmin();
    $isPetugas = Auth::check() && Auth::user()->isPetugas();
    $brandUrl = $isNasabah ? route('pengumuman.public') : route('admin.dashboard');
@endphp
<div class="app-shell">
    <aside class="sidebar" id="sidebar">
        <a class="brand" href="{{ $brandUrl }}">
            <span class="brand-mark"><span></span><span></span><span></span></span>
            <span>eco<span class="brand-light">bank</span><small>Sistem Informasi Bank Sampah</small></span>
        </a>

        @if($isNasabah)
            <div class="side-label">MENU NASABAH</div>
            <nav class="side-nav">
                <a href="{{ route('pengumuman.public') }}" class="{{ request()->routeIs('pengumuman.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                    <span>Papan Info Publik</span>
                </a>
            </nav>
        @else
            <div class="side-label">MENU UTAMA</div>
            <nav class="side-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') || request()->path() === 'admin' ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                    <span>Dashboard</span>
                </a>
            </nav>

            <div class="nav-section-title">DATA MASTER</div>
            <nav class="side-nav">
                <a href="{{ route('admin.nasabah.index') }}" class="{{ request()->routeIs('admin.nasabah.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span>Data Nasabah</span>
                </a>
                <a href="{{ route('admin.drop-points.index') }}" class="{{ request()->routeIs('admin.drop-points.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                    <span>Drop Points</span>
                </a>
                <a href="{{ route('admin.wilayah.index') }}" class="{{ request()->routeIs('admin.wilayah.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
                    <span>Wilayah/RW</span>
                </a>
                <a href="{{ route('admin.jadwal.index') }}" class="{{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    <span>Jadwal Pengumpulan</span>
                </a>
            </nav>

            <div class="nav-section-title">OPERASIONAL</div>
            <nav class="side-nav">
                <a href="{{ route('admin.pengeluaran.index') }}" class="{{ request()->routeIs('admin.pengeluaran.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
                    <span>Pengeluaran Kas</span>
                </a>
                <a href="{{ route('admin.pengumuman.index') }}" class="{{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-5v12L3 13v-2z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
                    <span>Pengumuman</span>
                </a>
            </nav>

            <div class="nav-section-title">SISTEM & INFORMASI</div>
            <nav class="side-nav">
                <a href="{{ route('pengumuman.public') }}" class="{{ request()->routeIs('pengumuman.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                    <span>Papan Info Publik</span>
                </a>
            </nav>
        @endif

        <div class="sidebar-bottom">
            <div class="help-card">
                <div class="help-icon">✦</div>
                <strong>EcoBank Terpadu</strong>
                @if($isNasabah)
                    <p>Akses informasi resmi dan jadwal operasional bank sampah.</p>
                    <a href="{{ route('pengumuman.public') }}">Papan Info Publik</a>
                @else
                    <p>Seluruh modul bank sampah terhubung dalam satu sistem.</p>
                    <a href="{{ route('pengumuman.public') }}">Buka Papan Pengumuman</a>
                @endif
            </div>
            <div class="profile-mini">
                <div class="avatar">{{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 2)) : 'EB' }}</div>
                <div style="flex: 1; min-width: 0;">
                    <strong style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ Auth::check() ? Auth::user()->name : 'Tamu (Warga)' }}
                    </strong>
                    @php
                        $role = Auth::check() ? Auth::user()->role : 'Tamu';
                        $roleClass = match(strtolower($role)) {
                            'admin' => 'role-admin',
                            'petugas' => 'role-petugas',
                            'nasabah' => 'role-nasabah',
                            default => 'role-guest'
                        };
                    @endphp
                    <span class="role-badge {{ $roleClass }}" style="padding: 2px 7px; font-size: 9.5px; margin-top: 3px;">
                        {{ ucfirst($role) }}
                    </span>
                </div>
                @if(Auth::check())
                    <a href="{{ route('logout') }}" title="Keluar / Logout" class="action-btn delete" style="padding: 4px 8px; font-size: 11px;">Keluar</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm" style="padding: 4px 10px; font-size: 11px;">Masuk</a>
                @endif
            </div>
        </div>
    </aside>

    <main class="main-area">
        <header class="topbar">
            <button class="mobile-menu" id="mobileMenu" aria-label="Buka menu navigasi">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <div class="breadcrumb">
                <span>EcoBank</span>
                <span>/</span>
                <strong>@yield('breadcrumb', $isNasabah ? 'Papan Info Publik' : 'Dashboard')</strong>
            </div>
            <div class="top-actions">
                <a href="{{ route('pengumuman.public') }}" class="icon-button" title="Papan Pengumuman Publik">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-5v12L3 13v-2z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
                </a>
                @if(Auth::check())
                    <div class="top-user" style="cursor: pointer;" onclick="if(confirm('Apakah Anda ingin keluar (logout)?')) { window.location.href='{{ route('logout') }}'; }" title="Klik untuk keluar akun">
                        <div class="avatar small">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                        <span>{{ Auth::user()->name }}</span>
                        <span class="role-badge {{ $roleClass }}" style="font-size: 9px; padding: 2px 6px;">{{ Auth::user()->role }}</span>
                        <b style="color: #ef4444; margin-left: 4px; font-size: 11px;">Keluar ↗</b>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar Nasabah</a>
                @endif
            </div>
        </header>

        <section class="page-content">
            @if(session('success'))
                <div class="flash-container">
                    <div class="flash-msg success">
                        <span>✓ {{ session('success') }}</span>
                        <button type="button" class="close-flash" onclick="this.parentElement.parentElement.remove()">✕</button>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="flash-container">
                    <div class="flash-msg error">
                        <span>⚠ {{ session('error') }}</span>
                        <button type="button" class="close-flash" onclick="this.parentElement.parentElement.remove()">✕</button>
                    </div>
                </div>
            @endif

            @yield('content')
        </section>

        <footer class="footer">© {{ date('Y') }} EcoBank · Sistem Informasi Pengelolaan Bank Sampah Terpadu</footer>
    </main>
</div>
<div class="toast" id="toast" role="status"></div>
<script src="{{ asset('js/ecobank.js') }}?v={{ filemtime(public_path('js/ecobank.js')) }}"></script>
@stack('scripts')
</body>
</html>
