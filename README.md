# 🚀 Website Manajemen & Absensi Siswa (Laravel 12 + Bootstrap 5)

Project website pendataan siswa dan pencatatan absensi harian sekolah menggunakan **Laravel 12** dan **Bootstrap 5**. Project ini dirancang dengan sistem **Absensi Mandiri oleh Siswa**, di mana Admin hanya bertindak sebagai pemantau harian.

---

## 📊 Konsep Relasi Database (5 Tabel)

Website ini menggunakan sistem relasi database **Eloquent ORM** yang menghubungkan 5 tabel:

1. **`users`**: Digunakan untuk login/autentikasi sistem (Login & Logout admin).
   - Kolom: `id`, `username`, `password`, `role`
2. **`jurusans`**: Menyimpan data jurusan (program keahlian) sekolah.
   - Kolom: `id`, `nama_jurusan`
   - Relasi: Memiliki banyak Kelas (`hasMany`)
3. **`kelas`**: Menyimpan data kelas.
   - Kolom: `id`, `nama_kelas`, `jurusan_id`
   - Relasi: Milik Jurusan (`belongsTo`), Memiliki banyak Siswa (`hasMany`)
4. **`siswas`**: Menyimpan data profil siswa.
   - Kolom: `id`, `nis`, `nama`, `alamat`, `jenis_kelamin`, `kelas_id`
   - Relasi: Milik Kelas (`belongsTo`), Memiliki banyak Absensi (`hasMany`)
5. **`absensis`**: Menyimpan catatan kehadiran harian siswa.
   - Kolom: `id`, `siswa_id`, `tanggal_absen`, `status` (Hadir, Sakit, Izin, Alpa), `keterangan`
   - Relasi: Milik Siswa (`belongsTo`)

---

## 🔑 Kredensial Login Sistem (Default Seeder)

Aplikasi telah dilengkapi dengan data awal (*seeder*) lengkap yang mencakup 1 akun admin dan 40 akun siswa kelas **XI RPL 1**:

### 1. Akun Admin
*   **Username:** `admin`
*   **Password:** `admin123`
*   **Role:** `admin`

### 2. Akun Siswa (40 Siswa Kelas XI RPL 1)
*   **Username (NIS):** `1` sampai dengan `40` (pilih salah satu, misal: `1` untuk Adinda, `2` untuk Agung, dll.)
*   **Password:** `siswa123`
*   **Role:** `siswa`

---

## 📁 Struktur Folder Project Penting

Berikut adalah file-file penting yang telah dibuat dan dikonfigurasi pada project ini:

```text
absensi_humma/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php            # Controller Login/Logout & Validasi
│   │       ├── DashboardController.php       # Controller Dashboard (Statistik & Redireksi)
│   │       ├── SiswaDashboardController.php  # Controller Dashboard Khusus Siswa & Absen Mandiri
│   │       ├── JurusanController.php         # CRUD Resource Jurusan (Admin)
│   │       ├── KelasController.php           # CRUD Resource Kelas (Admin)
│   │       ├── SiswaController.php           # CRUD Resource Siswa & Detail Profil (Admin)
│   │       └── AbsensiController.php         # RESTRICTED Controller: Hanya melihat absen hari ini (Admin)
│   └── Models/
│       ├── User.php                          # Model User Autentikasi
│       ├── Jurusan.php                       # Model Jurusan (Relasi hasMany Kelas)
│       ├── Kelas.php                         # Model Kelas (Relasi belongsTo Jurusan & hasMany Siswa)
│       ├── Siswa.php                         # Model Siswa (Relasi belongsTo Kelas & hasMany Absensi)
│       └── Absensi.php                       # Model Absensi (Relasi belongsTo Siswa)
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2026_05_21_002956_create_jurusans_table.php
│   │   ├── 2026_05_21_002957_create_kelas_table.php
│   │   ├── 2026_05_21_002957_create_siswas_table.php
│   │   └── 2026_05_21_002958_create_absensis_table.php
│   └── seeders/
│       └── DatabaseSeeder.php                # Seeder 40 Akun Siswa & 1 Akun Admin
├── routes/
│   └── web.php                               # Kumpulan Route & Pengamanan Middleware Auth
└── resources/
    └── views/
        ├── layouts/
        │   └── admin.blade.php               # Master Layout (Responsive Sidebar dengan Hak Akses Role)
        ├── auth/
        │   └── login.blade.php               # Halaman Login Multi-Role (Admin & Siswa)
        ├── admin/
        │   ├── jurusan/                      # Views CRUD Jurusan (index, create, edit)
        │   ├── kelas/                        # Views CRUD Kelas (index, create, edit)
        │   ├── siswa/                        # Views CRUD Siswa (index, create, edit, show)
        │   └── absensi/                      # View Daftar Absensi Hari Ini (index - VIEW ONLY)
        ├── siswa/
        │   └── dashboard.blade.php           # Halaman Dashboard Mandiri & Riwayat Kehadiran Siswa
        └── dashboard.blade.php               # Tampilan Dashboard Utama Admin
```

---

## 🛠️ Detail Pembatasan Hak Akses Absensi

- **Absensi Mandiri oleh Siswa**: Siswa login dan mengirimkan absensi hariannya secara mandiri melalui tombol opsi **Hadir**, **Sakit**, atau **Izin** pada dashboard mereka.
- **Batasan Akses Admin (View-Only)**:
  - Admin **tidak dapat** mencatat absensi baru, mengedit absensi lama, maupun menghapus riwayat absensi. Rute `create`, `store`, `edit`, `update`, dan `destroy` pada `AbsensiController` telah dilindungi dengan status respon `403 (Forbidden)`.
  - Halaman absensi admin (`absensi/index.blade.php`) telah dibersihkan dari tombol aksi (tambah/edit/hapus).
  - Tampilan daftar absensi di sisi admin difilter secara ketat agar **hanya menampilkan catatan kehadiran pada hari ini** (`tanggal_absen = hari ini`), sesuai dengan kebutuhan pemantauan harian sekolah.
- **Pencarian Terbatas**: Admin dapat melakukan pencarian data kehadiran siswa hari ini berdasarkan nama siswa, NIS, atau status tertentu.

---

## 💻 Cara Menjalankan Project di Komputer Lokal

### Langkah 1: Jalankan Server Laravel
Buka terminal (PowerShell / Command Prompt) di direktori `c:\absensi_humma` dan ketik perintah berikut:
```bash
php artisan serve
```
Aplikasi dapat diakses melalui browser pada alamat:
👉 **[http://localhost:8000](http://localhost:8000)**

### Langkah 2: Jalankan Asset Compiler (Vite)
Buka terminal baru di folder yang sama, lalu jalankan perintah berikut untuk meng-compile asset CSS/JS:
```bash
npm run dev
```

### Langkah 3: Database & Seeding (Opsional)
Jika Anda ingin menyetel ulang database kembali ke data awal default seeder (mengisi 40 siswa kelas XI RPL 1 dan akun login mereka):
```bash
php artisan migrate:fresh --seed
```
