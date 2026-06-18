# Aplikasi Antrian Pitching Kewirausahaan

Aplikasi ini dibangun berdasarkan Bab I–III dokumen *Progress Report Proyek Terapan* (Masterplan: digitalisasi proses pendaftaran *pitching* kewirausahaan di Biro Pelayanan Akademik/BPA, Universitas Telkom). Aplikasi menggantikan proses verifikasi berkas fisik dan antrean manual dengan sistem digital yang menyediakan:

- **Antrean verifikasi berkas** otomatis (FCFS / First-Come First-Served) sehingga mahasiswa tidak perlu menunggu fisik di depan ruangan.
- **Live monitoring** posisi antrean & sisa kuota jadwal (auto-refresh, tanpa perlu install layanan websocket).
- **Unlock pemilihan jadwal** otomatis hanya setelah petugas menekan "Verifikasi Lengkap".
- **E-Receipt digital (PDF)** berisi Nomor Kelompok, Jadwal, dan Data Kelompok setelah konfirmasi akhir petugas.

## 1. Arsitektur & Alur Sistem

```
Peserta                                  Petugas BPA (Admin)
--------                                 --------------------
Daftar akun & isi data kelompok    --->  Masuk ke Antrean Verifikasi (FCFS)
Unggah berkas (PDF)                      Lihat & "Panggil" kelompok
Pantau posisi antrean (live)             Verifikasi Lengkap  -> ATAU ->  Tolak (+catatan revisi)
                                          (jika lengkap) Pilih Jadwal di-unlock otomatis
Pilih jadwal yang tersedia          --->  Konfirmasi Akhir (sinkronisasi data + jadwal)
                                          Terbitkan Nomor Kelompok + E-Receipt
Unduh E-Receipt (PDF)               <---
```

Status pendaftaran kelompok (`kelompoks.status`):

| Status | Keterangan |
|---|---|
| `menunggu_verifikasi` | Baru daftar / baru unggah ulang berkas, masuk antrean FCFS |
| `revisi` | Berkas ditolak petugas, peserta wajib unggah ulang |
| `siap_pilih_jadwal` | Berkas dinyatakan lengkap, peserta bisa pilih jadwal |
| `menunggu_konfirmasi` | Jadwal sudah dipilih, menunggu konfirmasi akhir petugas |
| `terjadwal` | Dikonfirmasi petugas, Nomor Kelompok & E-Receipt terbit |

## 2. Struktur Database

- `users` (+ kolom `role`: `peserta` / `admin`)
- `kelompoks` — data kelompok, status, nomor antrean, nomor kelompok, relasi ke `jadwal`
- `anggota_kelompoks` — daftar anggota per kelompok
- `berkas` — riwayat berkas yang diunggah (mendukung revisi berulang)
- `jadwals` — slot tanggal/jam/ruangan/kuota pitching

## 3. Prasyarat

- PHP >= 8.2
- Composer
- MySQL/MariaDB (disarankan via **Laragon**, sesuai disebutkan pada dokumen Bab III) atau database lain yang didukung Laravel
- Node.js **tidak wajib** — tampilan menggunakan Bootstrap 5 via CDN agar instalasi tetap ringan

## 4. Langkah Instalasi

```bash
# 1. Buat project Laravel baru
composer create-project laravel/laravel antrian-pitching
cd antrian-pitching

# 2. Salin seluruh folder app/, database/, resources/, routes/ dari paket ini
#    ke folder project (timpa file routes/web.php dan app/Models/User.php yang sudah ada)

# 3. Install paket PDF generator untuk E-Receipt
composer require barryvdh/laravel-dompdf

# 4. Generate APP_KEY & konfigurasi database
cp .env.example .env
php artisan key:generate
```

Edit `.env`, sesuaikan koneksi database (contoh untuk Laragon MySQL):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=antrian_pitching
DB_USERNAME=root
DB_PASSWORD=
```

Agar nama bulan/hari tampil dalam Bahasa Indonesia, ubah di `config/app.php`:

```php
'locale' => 'id',
```

### Daftarkan middleware role (Laravel 11/12)

Buka `bootstrap/app.php`, tambahkan alias middleware di dalam `->withMiddleware()`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        'peserta' => \App\Http\Middleware\EnsureUserIsPeserta::class,
    ]);
})
```

### Migrasi, seeding, dan storage

```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Buka `http://127.0.0.1:8000`.

## 5. Akun Default

| Role | Email | Password |
|---|---|---|
| Petugas BPA (Admin) | `admin@bpa.telkomuniversity.ac.id` | `password123` |
| Peserta | Daftar sendiri lewat halaman **Register** | - |

> Setelah login pertama kali sebagai admin, buat jadwal pitching dahulu di menu **Kelola Jadwal** agar peserta memiliki opsi jadwal untuk dipilih.

## 6. Daftar Fitur

**Peserta**
- Registrasi & login akun kelompok
- Mengisi data kelompok + daftar anggota (dinamis, bisa tambah baris)
- Unggah berkas persyaratan (PDF, validasi tipe & ukuran maksimal 5MB)
- Pantau status & posisi antrean verifikasi secara real-time (polling tiap 10 detik)
- Unggah ulang berkas jika diminta revisi, beserta catatan dari petugas
- Pilih jadwal pitching dari daftar slot yang masih memiliki kuota
- Unduh E-Receipt (PDF) setelah dikonfirmasi petugas

**Admin / Petugas BPA**
- Dashboard ringkasan statistik status pendaftaran & jadwal mendatang
- Antrean verifikasi terurut FCFS berdasarkan nomor antrean
- Tombol "Panggil" untuk menandai kelompok sedang diproses
- Verifikasi berkas: tandai "Lengkap" atau "Tolak" dengan catatan revisi wajib
- Kelola jadwal pitching (tambah/ubah/hapus tanggal, jam, ruangan, kuota)
- Konfirmasi akhir pendaftaran -> menerbitkan Nomor Kelompok resmi & E-Receipt
- Pratinjau berkas yang diunggah peserta langsung dari detail kelompok

## 7. Pengembangan Lanjutan (Saran untuk Bab IV/V)

- Tambahkan log riwayat durasi pelayanan per kelompok (waktu panggil → waktu konfirmasi) untuk laporan statistik UAT.
- Notifikasi email/WhatsApp otomatis saat status berubah.
- Role tambahan untuk membagi 3 petugas BPA secara paralel (filter "kelompok yang saya proses").
- Audit trail / log aktivitas verifikasi untuk kebutuhan Black Box Testing pada Bab IV.

## 8. Struktur Folder yang Disertakan

```
app/
  Models/ (User, Kelompok, AnggotaKelompok, Berkas, Jadwal)
  Http/Controllers/ (Auth, PesertaController, Admin/*, Api/StatusController)
  Http/Middleware/ (EnsureUserIsAdmin, EnsureUserIsPeserta)
database/
  migrations/
  seeders/ (AdminSeeder, DatabaseSeeder)
resources/views/
  layouts/, auth/, peserta/, admin/
routes/
  web.php
```