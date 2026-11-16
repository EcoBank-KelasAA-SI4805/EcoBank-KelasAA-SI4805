# EcoBank — Sistem Manajemen Bank Sampah Digital

EcoBank adalah aplikasi berbasis web untuk membantu digitalisasi pengelolaan bank sampah. Sistem dirancang untuk mengelola data nasabah, setoran sampah, saldo, penarikan, katalog jenis dan harga sampah, serta pelaporan secara terpusat.

Proyek ini dikembangkan oleh **Kelompok A — SI4805** sebagai bagian dari Praktikum Pengembangan Perangkat Lunak (PPL), dengan mengacu pada proposal *EcoBank: Sistem Manajemen Bank Sampah Digital*.

---

## 1. Identitas Tim Pengembang

**Kelompok:** A — SI4805  
**Produk:** EcoBank — Sistem Manajemen Bank Sampah Digital  
**Metode pengembangan:** Agile Scrum

| No. | NIM | Nama | Peran dan tanggung jawab PBI |
|---:|---|---|---|
| 1 | 102022400354 | Muhamad Malik Zhafran Badarudin | Feature Developer — Sprint 1: P-09 Jadwal Pengumpulan dan P-10 Wilayah/RW; Sprint 2: P-15 Setoran |
| 2 | 102022400331 | Gracia Gebriella Sianturi | Feature Developer — Sprint 1: P-11 Reward dan P-12 Metode Penarikan; Sprint 2: P-16 Penarikan Saldo |
| 3 | 102022400168 | Hasbi Muhammad Fawaz | Feature Developer — Sprint 1: P-07 Pengepul dan P-08 Kendaraan; Sprint 2: P-18 Penukaran Reward |
| 4 | 102022400174 | Muhammad Dhafin Razaqa | Feature Developer dan Koordinator Repositori — Sprint 1: P-01 Nasabah dan P-02 Lokasi Drop Point; Sprint 2: P-19 Inventaris Stok |
| 5 | 102022400307 | Aisyah Khairunnisa | Feature & QA Developer — Sprint 1: P-03 Jenis Sampah dan Harga serta P-04 Promo; Sprint 2: P-20 Pengangkutan |
| 6 | 102022430057 | Naila Zahra | Feature & QA Developer — Sprint 1: P-05 Jenis Residu dan P-06 Pencatatan Residu; Sprint 2: P-21 Kegiatan Penyuluhan |
| 7 | 102022400120 | Renaldi | Feature & QA Developer — Sprint 1: P-13 Pengeluaran dan P-14 Pengumuman; Sprint 2: P-17 Penjualan ke Pengepul |

Setiap anggota bertanggung jawab mengembangkan PBI yang ditugaskan dari sisi antarmuka (frontend), logika dan basis data (backend), validasi, serta pengujian Laravel Dusk. Pekerjaan pendukung repositori, proyek Laravel, board Jira, migration, seeder, dokumentasi final, dan deployment dikoordinasikan oleh Muhammad Dhafin Razaqa. Fondasi autentikasi dan pembatasan akses (FR-01 dan FR-02) disiapkan oleh Aisyah Khairunnisa. Proposal juga memiliki tabel pembagian fitur F-01 sampai F-14 per Sprint; tabel di atas secara khusus mengikuti bagian **Tim Pengembang (Tabel 5.5)** yang membagi PBI P-01 sampai P-21.

> Catatan: tabel di atas mengikuti bagian **Tim Pengembang (Tabel 5.5)** pada proposal. PBI yang tercantum merupakan pembagian tanggung jawab pengembangan, bukan pernyataan bahwa seluruh PBI sudah tersedia pada setiap branch.

---

## 2. Tentang EcoBank

EcoBank merupakan sistem informasi berbasis web yang menjadi pusat pencatatan dan pengelolaan aktivitas bank sampah. Sistem ini ditujukan untuk menggantikan pencatatan manual yang berisiko menimbulkan kesalahan perhitungan, kehilangan catatan, keterlambatan pembaruan harga, serta kesulitan dalam penyusunan laporan.

Melalui EcoBank, petugas dapat mencatat data nasabah dan setoran sampah, sistem menghitung nilai setoran berdasarkan berat dan harga per kilogram, sedangkan nasabah dapat memantau saldo serta riwayat transaksi. Admin dapat mengelola akun, katalog jenis dan harga sampah, dashboard, serta laporan.

### Tujuan

- Mendigitalisasi pencatatan data nasabah, setoran sampah, saldo, dan penarikan.
- Memberikan akses kepada nasabah untuk memantau saldo, riwayat transaksi, dan harga sampah.
- Membantu petugas dan admin menyusun laporan sampah dan keuangan.
- Menyediakan informasi jenis dan volume sampah sebagai bahan pengambilan keputusan.
- Mendukung **Sustainable Development Goal (SDG) 12 — Konsumsi dan Produksi yang Bertanggung Jawab**, khususnya pengurangan sampah melalui pemilahan, daur ulang, dan penggunaan kembali.

### Cakupan dan batasan

- Aplikasi berbasis web dan responsif untuk desktop maupun perangkat seluler; bukan aplikasi mobile native.
- Penimbangan sampah dilakukan secara manual oleh petugas, kemudian hasilnya dimasukkan ke sistem.
- Penarikan saldo dicatat di sistem dan dilakukan secara tunai; tidak terdapat integrasi payment gateway atau e-wallet.
- Cakupan awal ditujukan untuk satu bank sampah (*single-tenant*) dan penggunaan data uji.

---

## 3. Aktor & Hak Akses Sistem

EcoBank memiliki tiga aktor utama. Hak akses dibatasi berdasarkan peran (*Role-Based Access Control/RBAC*).

| Aktor | Deskripsi | Hak akses utama |
|---|---|---|
| **Nasabah** | Warga yang menyetorkan sampah dan memiliki tabungan di bank sampah. | Login/logout; melihat saldo dan riwayat setoran serta penarikan miliknya; melihat daftar harga sampah; mengajukan penarikan saldo; mengubah profil sendiri. |
| **Petugas** | Pengelola operasional harian bank sampah. | Login/logout; mendaftarkan dan memperbarui data nasabah; mencatat setoran; memproses dan mencatat penarikan; melihat daftar harga; melihat dashboard dan laporan operasional sesuai kewenangannya. |
| **Admin** | Pengurus atau penanggung jawab bank sampah. | Seluruh akses petugas; mengelola akun dan peran pengguna; mengelola jenis serta harga sampah; mengoreksi data setoran; melihat dashboard; membuat dan mengunduh laporan rekap sampah dan keuangan. |

Nasabah hanya dapat melihat data miliknya sendiri. Petugas dan admin dapat mengakses data operasional sesuai kewenangannya, sedangkan pengelolaan akun dan katalog harga berada pada admin.

---

## 4. Modul & Kebutuhan Fungsional

Daftar berikut merangkum modul pengembangan dan kebutuhan fungsional (FR) yang ditetapkan dalam proposal.

| Modul | Kebutuhan fungsional | Ringkasan fungsi |
|---|---|---|
| **F-01 — Kelola Akun Pengguna** | FR-03 | Admin menambah, mengubah, menonaktifkan akun, dan mengatur peran pengguna. |
| **F-02 — Pendaftaran dan Data Nasabah** | FR-04, FR-05, FR-06 | Nasabah mengubah profil sendiri; petugas/admin mendaftarkan nasabah dan memperbarui datanya. |
| **F-03 — Katalog Jenis Sampah** | FR-07 | Admin menambah, mengubah, dan menonaktifkan jenis sampah. |
| **F-04 — Harga Sampah** | FR-08, FR-09 | Admin memperbarui harga per kilogram; seluruh peran dapat melihat daftar harga terbaru. |
| **F-05 — Input Setoran dan Penambahan Saldo** | FR-10, FR-11, FR-12 | Petugas mencatat jenis dan berat sampah; sistem menghitung nilai setoran dan menambah saldo nasabah. |
| **F-06 — Pengajuan dan Status Penarikan** | FR-16, FR-17 | Nasabah mengajukan penarikan; sistem memvalidasi nominal dan menampilkan status pengajuan. |
| **F-07 — Saldo dan Riwayat Transaksi** | FR-14, FR-15 | Nasabah melihat saldo serta riwayat transaksi miliknya; petugas/admin dapat melihat data nasabah sesuai kewenangan. |
| **F-08 — Koreksi Setoran** | FR-13 | Admin mengubah atau menghapus data setoran yang salah dan sistem menyesuaikan saldo. |
| **F-09 — Proses Penarikan dan Pengurangan Saldo** | FR-18, FR-19 | Petugas memproses pengajuan, mencatat penarikan tunai, dan sistem mengurangi saldo jika penarikan selesai. |
| **F-10 — Dashboard Admin** | FR-20 | Admin melihat ringkasan total sampah per jenis, jumlah setoran, dan perputaran saldo. |
| **F-11 — Dashboard Petugas** | FR-24 | Petugas melihat ringkasan kegiatan harian, termasuk berat dan nilai setoran, antrean penarikan, serta jumlah nasabah. |
| **F-12 — Laporan Rekap Sampah dan Keuangan** | FR-21 | Admin menghasilkan laporan berdasarkan periode yang dipilih. |
| **F-13 — Unduh Laporan** | FR-22 | Admin mengunduh laporan rekap dalam format PDF atau Excel. |
| **F-14 — Laporan Operasional Petugas** | FR-23 | Petugas melihat rekap setoran dan penarikan yang dicatat atau diproses olehnya. |

### Kebutuhan fungsional pendukung

- **FR-01 — Login dan logout:** nasabah, petugas, dan admin masuk serta keluar menggunakan akun masing-masing.
- **FR-02 — Pembatasan akses berdasarkan peran:** sistem menampilkan menu dan data sesuai peran pengguna.

### Catatan implementasi

README ini mendokumentasikan rancangan produk dan pembagian modul berdasarkan proposal. Snapshot UI yang menjadi dasar dokumentasi awal README berfokus pada **F-01 Kelola Akun Pengguna** dan **F-10 Dashboard Admin**. Pada snapshot tersebut, kedua halaman masih menggunakan dummy data di browser; backend CRUD, penyimpanan database, dan autentikasi sungguhan belum terhubung. Karena itu, daftar modul di atas tidak boleh dianggap sebagai bukti bahwa seluruh kebutuhan fungsional telah selesai diimplementasikan.

---

## 5. Arsitektur & Teknologi

### Arsitektur sistem

EcoBank menggunakan arsitektur berlapis **3-Tier** dengan pola **Model–View–Controller (MVC)**.

1. **Presentation Tier (Client):** pengguna mengakses antarmuka web melalui browser pada komputer, tablet, atau ponsel. Antarmuka menggunakan HTML, CSS, dan JavaScript serta dirancang responsif.
2. **Application Tier (Web Server):** aplikasi Laravel menjalankan pola MVC. Routing dan middleware mengatur rute, autentikasi, serta otorisasi; controller memproses logika bisnis dan validasi; Blade menampilkan halaman; model dan Eloquent ORM berinteraksi dengan basis data.
3. **Data Tier (Database Server):** MySQL menyimpan data akun, profil nasabah, katalog jenis sampah, transaksi setoran, detail setoran, riwayat harga, dan penarikan.

**Alur singkat:** Browser mengirim request ke web server → routing/middleware memeriksa rute dan hak akses → controller menjalankan logika aplikasi → model/Eloquent mengakses MySQL bila diperlukan → hasil diproses menjadi tampilan Blade dan dikirim kembali ke browser.

### Teknologi dan perangkat pendukung

| Komponen | Teknologi |
|---|---|
| Bahasa pemrograman backend | PHP |
| Framework backend | Laravel |
| Arsitektur aplikasi | MVC dan 3-Tier |
| Frontend | HTML, CSS, JavaScript, Blade |
| Styling UI | Bootstrap atau Tailwind CSS sesuai implementasi antarmuka |
| Database rancangan | MySQL (proposal juga menyebut PostgreSQL sebagai alternatif) |
| ORM | Eloquent ORM |
| Code editor | Visual Studio Code |
| Lingkungan lokal | XAMPP atau Laragon |
| Version control dan kolaborasi | Git dan GitHub |
| Pengujian | Laravel Dusk; Postman bila menggunakan REST API |

Metode pengembangan tim adalah **Agile Scrum**, dengan pembagian pekerjaan ke dalam Sprint dan Product Backlog Item (PBI). Proposal menetapkan pengujian otomatis menggunakan Laravel Dusk sebagai bagian dari proses penyelesaian fitur.

---

## 6. Panduan Menjalankan Sistem (Local Setup)

Panduan ini ditujukan untuk menjalankan snapshot project Laravel/UI yang didokumentasikan pada README awal. Snapshot tersebut menggunakan dummy data di browser dan belum memerlukan koneksi database untuk demonstrasi halaman F-01 dan F-10.

### Prasyarat

- PHP 8.2 atau versi yang kompatibel dengan `composer.json` project.
- Composer.
- Git (jika mengambil project dari repository).
- Node.js dan npm jika perlu memasang dependensi frontend.
- XAMPP atau Laragon dapat digunakan sebagai lingkungan lokal.

### Langkah instalasi

1. Clone repository atau ekstrak folder project.

```bash
git clone <URL_REPOSITORY>
cd <NAMA_FOLDER_PROJECT>
```

Jika project sudah tersedia secara lokal, cukup buka terminal pada folder project Laravel.

2. Pasang dependensi PHP.

```bash
composer install
```

3. Siapkan file environment. Pada Windows Command Prompt:

```bat
copy .env.example .env
```

Pada macOS/Linux atau terminal Git Bash:

```bash
cp .env.example .env
```

4. Buat application key.

```bash
php artisan key:generate
```

5. Pasang dependensi JavaScript bila diperlukan oleh project.

```bash
npm install
```

6. Jalankan server pengembangan Laravel.

```bash
php artisan serve
```

7. Buka aplikasi melalui browser:

```text
http://127.0.0.1:8000
```

### Halaman yang tersedia pada snapshot UI

- Dashboard Admin: `http://127.0.0.1:8000/admin/dashboard`
- Kelola Pengguna: `http://127.0.0.1:8000/admin/users`

Asset CSS dan JavaScript pada snapshot UI tersedia di folder `public/css` dan `public/js`, sehingga Vite tidak diperlukan untuk menjalankan tampilan tersebut.

### Pengujian manual UI

**Dashboard Admin**

- Ubah pilihan periode dan periksa perubahan kartu ringkasan.
- Pilih tanggal awal dan akhir, lalu tekan tombol Terapkan.
- Periksa tampilan grafik komposisi sampah dan perputaran saldo.

**Kelola Pengguna**

- Tambahkan akun dengan email unik.
- Uji penolakan ketika email yang sama digunakan kembali.
- Ubah nama, email, peran, dan status akun.
- Gunakan pencarian nama/email serta filter peran dan status.
- Nonaktifkan dan aktifkan kembali akun melalui tombol aksi.

### Catatan penting

- Data transaksi, nama pengguna, dan statistik pada snapshot UI merupakan **dummy data untuk demonstrasi**, bukan data operasional bank sampah.
- Perubahan akun pada snapshot UI berjalan di sisi browser dan akan hilang ketika halaman di-refresh.
- Snapshot ini belum menyediakan backend CRUD, autentikasi sungguhan, atau penyimpanan database untuk halaman yang dijelaskan di atas.
- Karena belum ada integrasi database pada snapshot tersebut, perintah `php artisan migrate` dan konfigurasi kredensial database tidak diperlukan untuk menjalankan demo UI ini. Jika branch/repository yang digunakan sudah memiliki implementasi backend dan migration, ikuti konfigurasi `.env` serta instruksi database pada branch tersebut.

---

## Referensi

Dokumentasi ini disusun dengan mengacu pada **Proposal Pengembangan Produk — EcoBank: Sistem Manajemen Bank Sampah Digital, Kelompok A SI4805**, khususnya bagian Deskripsi Produk, Kebutuhan Sistem, Rancangan Sistem, Arsitektur Sistem, dan Tim Pengembang.
