# 📚 Aplikasi Perpustakaan Digital
### Laravel 11 + MySQL | OOP | Role-Based Access Control

---

## 🎯 Fitur Utama

| Fitur | Administrator | Petugas | Peminjam |
|-------|:---:|:---:|:---:|
| Login | ✅ | ✅ | ✅ |
| Logout | ✅ | ✅ | ✅ |
| Registrasi | ✅ (buat user) | - | ✅ |
| Pendataan Buku | ✅ (CRUD) | ✅ (CRUD) | - |
| Peminjaman | ✅ (kelola) | ✅ (kelola) | ✅ (ajukan) |
| Generate Laporan | ✅ | ✅ | - |
| Manajemen User | ✅ | - | - |

---

## 🚀 Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js (opsional, untuk frontend build)

### Langkah Instalasi

```bash
# 1. Clone / download project
git clone https://github.com/username/perpustakaan-digital.git
cd perpustakaan-digital

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
# DB_DATABASE=perpustakaan_digital
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 5. Buat database MySQL
mysql -u root -p -e "CREATE DATABASE perpustakaan_digital CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 6. Jalankan migrasi & seeder
php artisan migrate --seed

# 7. Buat symlink storage
php artisan storage:link

# 8. Jalankan server
php artisan serve
```

Akses: **http://localhost:8000**

---

## 👤 Akun Default (Setelah Seeder)

| Role | Email | Password |
|------|-------|----------|
| Administrator | admin@perpustakaan.com | password123 |
| Petugas | petugas@perpustakaan.com | password123 |
| Peminjam | budi@gmail.com | password123 |

---

## 🏗️ Struktur Proyek

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php       # Login, Logout, Register
│   │   ├── BukuController.php       # CRUD Buku + Katalog
│   │   ├── PeminjamanController.php # Peminjaman flow
│   │   ├── LaporanController.php    # Generate laporan
│   │   ├── DashboardController.php  # Dashboard per role
│   │   └── UserController.php       # Manajemen user (admin)
│   └── Middleware/
│       └── RoleMiddleware.php        # Proteksi route per role
├── Models/
│   ├── User.php        # Role: administrator/petugas/peminjam
│   ├── Buku.php        # Data koleksi buku
│   └── Peminjaman.php  # Transaksi peminjaman + denda
database/
├── migrations/         # Skema tabel
└── seeders/            # Data awal
resources/views/
├── auth/               # Login & Register
├── layouts/            # Master template + sidebar
├── admin/              # Views khusus administrator
├── petugas/            # Views khusus petugas
└── peminjam/           # Views khusus peminjam
routes/web.php          # Semua route dengan middleware role
```

---

## 📊 Database Schema

### Tabel `users`
- id, name, email, password
- **role**: `administrator` | `petugas` | `peminjam`
- no_telepon, alamat, is_active

### Tabel `buku`
- id, kode_buku (auto: BKU00001), judul, pengarang
- penerbit, tahun_terbit, isbn, kategori
- stok, stok_tersedia, deskripsi, cover

### Tabel `peminjaman`
- id, kode_peminjaman (auto: PMJ000001)
- user_id → users, buku_id → buku
- tanggal_pinjam, tanggal_kembali_rencana, tanggal_kembali_aktual
- **status**: `menunggu` | `dipinjam` | `dikembalikan` | `terlambat` | `ditolak`
- denda (Rp 1.000/hari keterlambatan), approved_by → users

---

## 🔒 Sistem Privilege (RBAC)

Route dilindungi middleware `role`:
```php
->middleware(['auth', 'role:administrator'])          // hanya admin
->middleware(['auth', 'role:petugas'])                // hanya petugas  
->middleware(['auth', 'role:peminjam'])               // hanya peminjam
->middleware(['auth', 'role:administrator,petugas'])  // admin & petugas
```

---

## 🎨 UI/UX

- **Framework**: Bootstrap 5.3
- **Icons**: Bootstrap Icons
- **Font**: Inter (Google Fonts)
- **Design**: Sidebar navigation, responsive, dark sidebar + light content
- Warna status dengan badge berwarna
- Tabel responsif dengan filter & search
- Form validasi sisi server dengan pesan error inline

---

## ⚙️ Teknologi

- **Backend**: Laravel 11 (PHP 8.2+)
- **Database**: MySQL 8
- **Frontend**: Bootstrap 5, Blade Templates
- **Pattern**: MVC, OOP, Eloquent ORM
- **Auth**: Laravel Auth (session-based)
- **File upload**: Laravel Storage (covers buku)

---

## 📝 Laporan yang Tersedia

1. **Laporan Peminjaman** — semua transaksi per periode
2. **Laporan Keterlambatan & Denda** — kasus overdue
3. **Buku Paling Populer** — ranking buku berdasarkan frekuensi pinjam
4. **Statistik Anggota** — data peminjam dan aktivitas

---

## 🧪 Testing

```bash
php artisan test
```

---

> Dibuat untuk memenuhi tugas **Aplikasi Perpustakaan Digital** — Paket I
