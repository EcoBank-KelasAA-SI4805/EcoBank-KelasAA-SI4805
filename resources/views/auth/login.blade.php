<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk · EcoBank</title>
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
            background: #f4f7f5;
            padding: 20px;
        }
        .login-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 12px 40px rgba(22, 57, 42, 0.08);
            width: 100%;
            max-width: 440px;
            padding: 36px 32px;
        }
        .login-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #173c2c;
            font-family: Manrope, sans-serif;
            font-weight: 800;
            font-size: 24px;
            letter-spacing: -1px;
            margin-bottom: 24px;
        }
        .login-header h1 {
            font: 800 22px Manrope, sans-serif;
            color: #1d3028;
            margin: 0 0 6px;
        }
        .login-header p {
            font-size: 12px;
            color: #84918c;
            margin: 0 0 24px;
        }
        .demo-roles {
            background: #f7faf8;
            border: 1px solid #e2ebe5;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 22px;
            font-size: 11px;
        }
        .demo-roles strong {
            display: block;
            color: #2e4a3b;
            margin-bottom: 6px;
            font-size: 11px;
        }
        .demo-pills {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        .demo-pill {
            background: #fff;
            border: 1px solid #d2ded7;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 600;
            color: var(--green);
            cursor: pointer;
            transition: .15s;
        }
        .demo-pill:hover {
            background: #eaf6ef;
            border-color: var(--green);
        }
    </style>
</head>
<body>

<div class="login-card">
    <a class="login-brand" href="{{ url('/') }}">
        <span class="brand-mark"><span></span><span></span><span></span></span>
        <span>eco<span class="brand-light">bank</span></span>
    </a>

    <div class="login-header">
        <h1>Selamat Datang Kembali</h1>
        <p>Silakan masuk untuk mengelola atau memantau tabungan sampah Anda.</p>
    </div>

    @if(session('success'))
        <div style="background: #eaf7f0; color: #16865b; border-left: 4px solid #16865b; padding: 10px 14px; border-radius: 6px; font-size: 11px; font-weight: 600; margin-bottom: 18px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Quick Demo Role Clickers (Bagus untuk Uji Coba & Demo Dosen) --}}
    <div class="demo-roles">
        <strong>⚡ Akses Cepat Uji Coba Akun:</strong>
        <div class="demo-pills">
            <span class="demo-pill" onclick="fillLogin('hasbi@ecobank.test')">Admin (Hasbi)</span>
            <span class="demo-pill" onclick="fillLogin('renaldi@ecobank.test')">Admin (Renaldi)</span>
            <span class="demo-pill" onclick="fillLogin('dhafin@ecobank.test')">Petugas (Dhafin)</span>
            <span class="demo-pill" onclick="fillLogin('andi@email.test')">Nasabah (Andi)</span>
        </div>
    </div>

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div style="display: flex; flex-direction: column; gap: 16px;">
            <label class="form-field full">
                <span>Alamat Email</span>
                <input 
                    type="email" 
                    id="emailInput" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="nama@email.com" 
                    required 
                    autofocus
                    style="height: 42px; font-size: 12px;"
                >
                @error('email')
                    <small class="field-error" style="color: #d94c4c; font-size: 10px; margin-top: 3px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field full">
                <span>Kata Sandi (Password)</span>
                <input 
                    type="password" 
                    id="passwordInput" 
                    name="password" 
                    placeholder="••••••••" 
                    required
                    style="height: 42px; font-size: 12px;"
                >
                @error('password')
                    <small class="field-error" style="color: #d94c4c; font-size: 10px; margin-top: 3px;">{{ $message }}</small>
                @enderror
            </label>

            <div style="display: flex; align-items: center; justify-content: space-between; font-size: 11px; color: #76857d;">
                <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Ingat saya</span>
                </label>
                <a href="#" style="color: var(--green); text-decoration: none; font-weight: 600;" onclick="alert('Untuk keperluan praktikum, gunakan password default: password'); return false;">Lupa password?</a>
            </div>

            <button class="btn btn-primary" type="submit" style="height: 44px; font-size: 13px; width: 100%; margin-top: 6px; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                <span>Masuk ke Sistem</span>
            </button>
        </div>
    </form>

    <div style="text-align: center; margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--line); font-size: 11px; color: #8a9690;">
        Belum punya akun nasabah? 
        <a href="{{ route('register') }}" style="color: var(--green); font-weight: 700; text-decoration: none;">Daftar sekarang</a>
    </div>
</div>

<script>
function fillLogin(email) {
    document.getElementById('emailInput').value = email;
    document.getElementById('passwordInput').value = 'password';
}
</script>

</body>
</html>
