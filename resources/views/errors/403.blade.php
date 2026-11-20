<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 · Akses Dibatasi · EcoBank</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ecobank.css') }}">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f7f9f8;
            padding: 24px;
        }
        .error-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 16px 48px rgba(22, 57, 42, 0.08);
            max-width: 500px;
            width: 100%;
            padding: 40px 32px;
            text-align: center;
        }
        .error-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff4e7;
            color: #bd814b;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .error-title {
            font: 800 24px Manrope, sans-serif;
            color: #1d3028;
            margin: 0 0 10px;
        }
        .error-desc {
            font-size: 12px;
            color: #728279;
            line-height: 1.6;
            margin: 0 0 24px;
        }
        .role-box {
            background: #f5f8f6;
            border: 1px solid #e1ebe5;
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 24px;
            font-size: 11px;
            text-align: left;
        }
        .role-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }
        .role-row:last-child {
            margin-bottom: 0;
        }
    </style>
</head>
<body>

<div class="error-card">
    <div class="error-badge">
        <span>⚠</span> 403 · HAK AKSES TIDAK MENCUKUPI
    </div>

    <h1 class="error-title">Akses Dibatasi</h1>
    <p class="error-desc">
        {{ $message ?? 'Anda tidak memiliki wewenang untuk membuka atau mengelola halaman ini sesuai pembagian peran EcoBank.' }}
    </p>

    <div class="role-box">
        <div class="role-row">
            <span style="color: #84918c;">Peran Anda saat ini:</span>
            <strong style="color: #20372c;">{{ auth()->check() ? auth()->user()->role : 'Tamu (Belum Login)' }}</strong>
        </div>
        <div class="role-row">
            <span style="color: #84918c;">Hak akses yang diizinkan:</span>
            <strong style="color: #16865b;">{{ $requiredRoles ?? 'Admin' }}</strong>
        </div>
    </div>

    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
        @php
            $isNasabah = auth()->check() && strcasecmp(auth()->user()->role, 'Nasabah') === 0;
            $targetUrl = $isNasabah ? route('pengumuman.public') : url('/');
            $targetLabel = $isNasabah ? 'Buka Papan Info Publik' : 'Kembali ke Halaman Utama';
        @endphp
        <a class="btn btn-primary" href="{{ $targetUrl }}" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            <span>{{ $targetLabel }}</span>
        </a>
        
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button class="btn btn-outline" type="submit" style="display: inline-flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                <span>Ganti Akun Lain</span>
            </button>
        </form>
    </div>
</div>

</body>
</html>
