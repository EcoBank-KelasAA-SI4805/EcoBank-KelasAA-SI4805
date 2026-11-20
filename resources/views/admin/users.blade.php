@extends('layouts.admin')
@section('title', 'Kelola Pengguna')
@section('breadcrumb', 'Kelola Pengguna')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg>
            FR-01 · MANAJEMEN AKUN & AKSES
        </div>
        <h1>Kelola Pengguna</h1>
        <p>Kelola akun sistem, penetapan hak akses role (Administrator, Petugas, Nasabah), dan status aktivasi.</p>
    </div>
    <button class="btn btn-primary" id="addUserBtn">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>Tambah Pengguna Baru</span>
    </button>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: 20px;">
    <div class="mini-stat" style="background:#fff; border:1px solid var(--line); border-radius:var(--radius); padding:16px; display:flex; align-items:center; gap:12px; box-shadow: 0 1px 3px rgba(15,23,42,0.03);">
        <div class="stat-icon" style="background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; width:40px; height:40px; border-radius:10px; display:grid; place-items:center;"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
        <div><small style="font-size:10.5px; color:#64748b; font-weight:700; letter-spacing:0.3px;">TOTAL PENGGUNA</small><strong id="countAll" style="font-size:21px; color:#0f172a; display:block; font-family:'Manrope',sans-serif;">-</strong></div>
    </div>
    <div class="mini-stat" style="background:#fff; border:1px solid var(--line); border-radius:var(--radius); padding:16px; display:flex; align-items:center; gap:12px; box-shadow: 0 1px 3px rgba(15,23,42,0.03);">
        <div class="stat-icon" style="background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; width:40px; height:40px; border-radius:10px; display:grid; place-items:center;"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
        <div><small style="font-size:10.5px; color:#065f46; font-weight:700; letter-spacing:0.3px;">AKUN AKTIF</small><strong id="countActive" style="font-size:21px; color:#15803d; display:block; font-family:'Manrope',sans-serif;">-</strong></div>
    </div>
    <div class="mini-stat" style="background:#fff; border:1px solid var(--line); border-radius:var(--radius); padding:16px; display:flex; align-items:center; gap:12px; box-shadow: 0 1px 3px rgba(15,23,42,0.03);">
        <div class="stat-icon" style="background:#fff1f2; color:#e11d48; border:1px solid #fecdd3; width:40px; height:40px; border-radius:10px; display:grid; place-items:center;"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg></div>
        <div><small style="font-size:10.5px; color:#9f1239; font-weight:700; letter-spacing:0.3px;">AKUN NONAKTIF</small><strong id="countInactive" style="font-size:21px; color:#be123c; display:block; font-family:'Manrope',sans-serif;">-</strong></div>
    </div>
    <div class="mini-stat" style="background:#fff; border:1px solid var(--line); border-radius:var(--radius); padding:16px; display:flex; align-items:center; gap:12px; box-shadow: 0 1px 3px rgba(15,23,42,0.03);">
        <div class="stat-icon" style="background:#f5f3ff; color:#7c3aed; border:1px solid #ddd6fe; width:40px; height:40px; border-radius:10px; display:grid; place-items:center;"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg></div>
        <div><small style="font-size:10.5px; color:#6d28d9; font-weight:700; letter-spacing:0.3px;">ADMINISTRATOR</small><strong id="countAdmin" style="font-size:21px; color:#6d28d9; display:block; font-family:'Manrope',sans-serif;">-</strong></div>
    </div>
</div>

<div class="panel users-panel">
    <div class="data-toolbar" style="flex-wrap: wrap; gap: 14px;">
        <div>
            <h3>Daftar Pengguna Sistem</h3>
            <p>Informasi akun, tingkatan hak akses, dan status login</p>
        </div>
        <div class="toolbar-actions" style="flex-wrap: wrap;">
            <div class="search-box" style="width: 220px;">
                <input id="userSearch" type="search" placeholder="Cari nama atau email..." class="data-search">
            </div>
            <select id="roleFilter">
                <option value="">Semua Peran (Role)</option>
                <option value="Admin">Admin</option>
                <option value="Petugas">Petugas</option>
                <option value="Nasabah">Nasabah</option>
            </select>
            <select id="statusFilter">
                <option value="">Semua Status</option>
                <option value="Aktif">Aktif</option>
                <option value="Nonaktif">Nonaktif</option>
            </select>
        </div>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>PENGGUNA</th>
                    <th>PERAN (ROLE)</th>
                    <th>TANGGAL BERGABUNG</th>
                    <th>STATUS LOGIN</th>
                    <th class="align-right" style="min-width: 280px; text-align: right;">AKSI</th>
                </tr>
            </thead>
            <tbody id="userTableBody"></tbody>
        </table>
    </div>

    <div class="table-bottom">
        <span id="userCountLabel">Menampilkan pengguna</span>
        <span style="color:#16a34a; font-weight:600;">● Terhubung dengan database EcoBank</span>
    </div>
</div>

{{-- Modal Tambah / Edit Pengguna --}}
<div class="modal-backdrop" id="userModal" aria-hidden="true">
    <div class="modal-card">
        <div class="modal-head">
            <div>
                <h2 id="modalTitle">Tambah Pengguna</h2>
                <p>Lengkapi informasi identitas dan peran akun pengguna.</p>
            </div>
            <button class="modal-close" data-close="userModal">×</button>
        </div>
        <form id="userForm">
            <input type="hidden" id="editUserId">
            <div class="form-grid">
                <label class="form-field full">
                    Nama Lengkap <span style="color:#ef4444;">*</span>
                    <input id="userName" required maxlength="100" placeholder="Masukkan nama lengkap">
                </label>
                <label class="form-field full">
                    Alamat Email <span style="color:#ef4444;">*</span>
                    <input id="userEmail" type="email" required placeholder="nama@email.com">
                </label>
                <label class="form-field">
                    Peran / Hak Akses <span style="color:#ef4444;">*</span>
                    <select id="userRole" required>
                        <option value="Nasabah">Nasabah (Pengguna)</option>
                        <option value="Petugas">Petugas (Operasional)</option>
                        <option value="Admin">Admin (Kelola Penuh)</option>
                    </select>
                </label>
                <label class="form-field">
                    Status Akun <span style="color:#ef4444;">*</span>
                    <select id="userStatus">
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                </label>
                <label class="form-field" id="passwordField">
                    Kata Sandi (Password) <span style="color:#ef4444;">*</span>
                    <input id="userPassword" type="password" minlength="6" placeholder="Minimal 6 karakter">
                </label>
                <label class="form-field" id="confirmField">
                    Konfirmasi Password <span style="color:#ef4444;">*</span>
                    <input id="userConfirm" type="password" minlength="6" placeholder="Ulangi password">
                </label>
            </div>
            <div class="form-note" id="formNote">
                Password default demo: <code>password</code>. Pengguna dengan status Nonaktif tidak dapat login ke sistem.
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-outline" data-close="userModal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Data Akun</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Detail Pengguna --}}
<div class="modal-backdrop" id="userDetailModal" aria-hidden="true">
    <div class="modal-card" style="max-width: 480px;">
        <div class="modal-head">
            <div>
                <h2>Detail Informasi Pengguna</h2>
                <p>Data profil dan hak akses pengguna sistem.</p>
            </div>
            <button class="modal-close" data-close="userDetailModal">×</button>
        </div>
        <div style="padding: 20px 24px;">
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:20px; padding-bottom:16px; border-bottom:1px solid #f1f5f9;">
                <div id="detailAvatar" class="avatar" style="width:52px; height:52px; font-size:18px; font-weight:800; border-radius:12px; background:linear-gradient(135deg, #10b981, #059669); color:#fff; display:grid; place-items:center;">-</div>
                <div>
                    <h3 id="detailName" style="font-size:17px; font-weight:800; color:#0f172a; margin:0 0 4px;">-</h3>
                    <div id="detailEmail" style="font-size:13px; color:#64748b;">-</div>
                </div>
            </div>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:14px; margin-bottom:16px;">
                <div style="background:#f8fafc; padding:12px 14px; border-radius:10px; border:1px solid #e2e8f0;">
                    <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">Peran / Hak Akses</span>
                    <span id="detailRole" class="role-badge">-</span>
                </div>
                <div style="background:#f8fafc; padding:12px 14px; border-radius:10px; border:1px solid #e2e8f0;">
                    <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">Status Akun</span>
                    <div id="detailStatus"><span class="status-badge-modern active"><span class="badge-dot green"></span><span>Aktif</span></span></div>
                </div>
                <div style="background:#f8fafc; padding:12px 14px; border-radius:10px; border:1px solid #e2e8f0; grid-column: span 2;">
                    <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">Tanggal Terdaftar / Bergabung</span>
                    <strong id="detailJoined" style="font-size:13px; color:#0f172a;">-</strong>
                </div>
            </div>
        </div>
        <div class="modal-actions" style="padding: 14px 24px; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" class="btn btn-outline" data-close="userDetailModal">Tutup</button>
            <button type="button" class="btn btn-primary" id="detailEditBtn">Edit Pengguna Ini</button>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Status --}}
<div class="modal-backdrop" id="confirmModal" aria-hidden="true">
    <div class="modal-card confirm-card" style="max-width: 420px; text-align: center;">
        <div class="confirm-symbol" style="width: 48px; height: 48px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: grid; place-items: center; margin: 0 auto 14px; font-size: 22px; font-weight: 800;">!</div>
        <h2 id="confirmTitle" style="font: 800 18px 'Manrope', sans-serif; color: #0f172a; margin-bottom: 6px;">Ubah status akun?</h2>
        <p id="confirmText" style="font-size: 13px; color: #64748b; margin-bottom: 20px;">Akun akan dinonaktifkan dari sistem.</p>
        <div class="modal-actions" style="justify-content: center; gap: 12px; border: 0; padding: 0;">
            <button class="btn btn-outline" data-close="confirmModal">Batal</button>
            <button class="btn btn-danger" id="confirmAction">Ya, Lanjutkan</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
@if(!empty($dbUsers) && count($dbUsers) > 0)
users = @json($dbUsers);
@endif
document.addEventListener('DOMContentLoaded', () => initUsers());
</script>
@endpush
