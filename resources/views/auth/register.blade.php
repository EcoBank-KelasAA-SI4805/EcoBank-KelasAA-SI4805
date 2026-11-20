<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Nasabah Baru · EcoBank</title>
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
            padding: 30px 20px;
        }
        .register-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 12px 40px rgba(22, 57, 42, 0.08);
            width: 100%;
            max-width: 520px;
            padding: 36px 32px;
        }
        .register-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #173c2c;
            font-family: Manrope, sans-serif;
            font-weight: 800;
            font-size: 24px;
            letter-spacing: -1px;
            margin-bottom: 20px;
        }
        .register-header h1 {
            font: 800 22px Manrope, sans-serif;
            color: #1d3028;
            margin: 0 0 6px;
        }
        .register-header p {
            font-size: 12px;
            color: #84918c;
            margin: 0 0 24px;
        }
    </style>
</head>
<body>

<div class="register-card">
    <a class="register-brand" href="{{ url('/') }}">
        <span class="brand-mark"><span></span><span></span><span></span></span>
        <span>eco<span class="brand-light">bank</span></span>
    </a>

    <div class="register-header">
        <h1>Pendaftaran Nasabah Baru</h1>
        <p>Bergabunglah bersama EcoBank untuk mengonversi sampah bernilai ekonomi menjadi tabungan.</p>
    </div>

    <form method="POST" action="{{ route('register.post') }}">
        @csrf

        <div class="form-grid" style="gap: 14px;">
            <label class="form-field full">
                <span>Nama Lengkap Sesuai KTP <b style="color: #d94c4c;">*</b></span>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Rahmat Hidayat" required>
                @error('name')
                    <small class="field-error" style="color: #d94c4c; font-size: 10px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field full">
                <span>Alamat Email <b style="color: #d94c4c;">*</b></span>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                @error('email')
                    <small class="field-error" style="color: #d94c4c; font-size: 10px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                <span>NIK (16 Digit)</span>
                <input type="text" name="nik" value="{{ old('nik') }}" placeholder="3201xxxxxxxxxxxx" maxlength="16" inputmode="numeric">
                @error('nik')
                    <small class="field-error" style="color: #d94c4c; font-size: 10px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                <span>Nomor HP (WhatsApp)</span>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
                @error('no_hp')
                    <small class="field-error" style="color: #d94c4c; font-size: 10px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                <span>RW Domisili</span>
                <input type="text" name="rw" value="{{ old('rw') }}" placeholder="Contoh: 05">
                @error('rw')
                    <small class="field-error" style="color: #d94c4c; font-size: 10px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field full">
                <span>Alamat Domisili</span>
                <input type="text" name="alamat" value="{{ old('alamat') }}" placeholder="Jl. Mawar No. 12, RT 01 / RW 05">
                @error('alamat')
                    <small class="field-error" style="color: #d94c4c; font-size: 10px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                <span>Kata Sandi <b style="color: #d94c4c;">*</b></span>
                <input type="password" name="password" placeholder="Minimal 6 karakter" required>
                @error('password')
                    <small class="field-error" style="color: #d94c4c; font-size: 10px;">{{ $message }}</small>
                @enderror
            </label>

            <label class="form-field">
                <span>Ulangi Kata Sandi <b style="color: #d94c4c;">*</b></span>
                <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi" required>
            </label>
        </div>

        <button class="btn btn-primary" type="submit" style="width: 100%; height: 44px; margin-top: 20px; font-size: 13px; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
            <span>Daftar Akun Baru</span>
        </button>
    </form>

    <div style="text-align: center; margin-top: 22px; padding-top: 18px; border-top: 1px solid var(--line); font-size: 11px; color: #8a9690;">
        Sudah memiliki akun? 
        <a href="{{ route('login') }}" style="color: var(--green); font-weight: 700; text-decoration: none;">Masuk di sini</a>
    </div>
</div>

</body>
</html>
