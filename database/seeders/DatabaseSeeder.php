<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── 1. Users ────────────────────────────────────────────
        // Administrator
        $admin = User::create([
            'name'       => 'Administrator',
            'email'      => 'admin@perpustakaan.com',
            'password'   => Hash::make('password123'),
            'role'       => 'administrator',
            'no_telepon' => '081234567890',
            'alamat'     => 'Kantor Perpustakaan, Jl. Pendidikan No. 1',
        ]);

        // Petugas
        $petugas1 = User::create([
            'name'       => 'Petugas Perpustakaan',
            'email'      => 'petugas@perpustakaan.com',
            'password'   => Hash::make('password123'),
            'role'       => 'petugas',
            'no_telepon' => '082345678901',
            'alamat'     => 'Jl. Guru No. 5',
        ]);

        $petugas2 = User::create([
            'name'       => 'Ahmad Fauzi',
            'email'      => 'ahmad@perpustakaan.com',
            'password'   => Hash::make('password123'),
            'role'       => 'petugas',
            'no_telepon' => '085678901234',
            'alamat'     => 'Jl. Masjid No. 12',
        ]);

        // Peminjam
        $peminjam1 = User::create([
            'name'       => 'Budi Santoso',
            'email'      => 'budi@gmail.com',
            'password'   => Hash::make('password123'),
            'role'       => 'peminjam',
            'no_telepon' => '083456789012',
            'alamat'     => 'Jl. Mawar No. 10, Surabaya',
        ]);

        $peminjam2 = User::create([
            'name'       => 'Siti Rahayu',
            'email'      => 'siti@gmail.com',
            'password'   => Hash::make('password123'),
            'role'       => 'peminjam',
            'no_telepon' => '084567890123',
            'alamat'     => 'Jl. Melati No. 3, Surabaya',
        ]);

        $peminjam3 = User::create([
            'name'       => 'Ahmad Wijaya',
            'email'      => 'ahmadwijaya@gmail.com',
            'password'   => Hash::make('password123'),
            'role'       => 'peminjam',
            'no_telepon' => '085678901345',
            'alamat'     => 'Jl. Kenanga No. 8, Sidoarjo',
        ]);

        $peminjam4 = User::create([
            'name'       => 'Dewi Lestari',
            'email'      => 'dewi@gmail.com',
            'password'   => Hash::make('password123'),
            'role'       => 'peminjam',
            'no_telepon' => '086789012456',
            'alamat'     => 'Jl. Dahlia No. 15, Surabaya',
        ]);

        $peminjam5 = User::create([
            'name'       => 'Rudi Hermawan',
            'email'      => 'rudi@gmail.com',
            'password'   => Hash::make('password123'),
            'role'       => 'peminjam',
            'no_telepon' => '087890123567',
            'alamat'     => 'Jl. Orchid No. 22, Gresik',
        ]);

        // ─── 2. Buku ─────────────────────────────────────────────
        $bukuData = [
            ['judul' => 'Clean Code', 'pengarang' => 'Robert C. Martin', 'penerbit' => 'Prentice Hall', 'tahun_terbit' => 2008, 'isbn' => '978-0-13-235088-4', 'kategori' => 'Teknologi', 'stok' => 3],
            ['judul' => 'Laravel: Up and Running', 'pengarang' => 'Matt Stauffer', 'penerbit' => "O'Reilly", 'tahun_terbit' => 2022, 'isbn' => '978-1-098-12133-9', 'kategori' => 'Teknologi', 'stok' => 2],
            ['judul' => 'Design Patterns', 'pengarang' => 'Gang of Four', 'penerbit' => 'Addison-Wesley', 'tahun_terbit' => 1994, 'isbn' => '978-0-201-63361-0', 'kategori' => 'Teknologi', 'stok' => 2],
            ['judul' => 'Bumi Manusia', 'pengarang' => 'Pramoedya Ananta Toer', 'penerbit' => 'Hasta Mitra', 'tahun_terbit' => 1980, 'isbn' => '978-979-419-019-7', 'kategori' => 'Fiksi', 'stok' => 4],
            ['judul' => 'Laskar Pelangi', 'pengarang' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => 2005, 'isbn' => '979-3062-79-7', 'kategori' => 'Fiksi', 'stok' => 5],
            ['judul' => 'Sapiens', 'pengarang' => 'Yuval Noah Harari', 'penerbit' => 'Harper Collins', 'tahun_terbit' => 2011, 'isbn' => '978-0-06-231609-7', 'kategori' => 'Sejarah', 'stok' => 2],
            ['judul' => 'The Alchemist', 'pengarang' => 'Paulo Coelho', 'penerbit' => 'HarperOne', 'tahun_terbit' => 1988, 'isbn' => '978-0-06-112241-5', 'kategori' => 'Fiksi', 'stok' => 3],
            ['judul' => 'Atomic Habits', 'pengarang' => 'James Clear', 'penerbit' => 'Avery', 'tahun_terbit' => 2018, 'isbn' => '978-0-7352-1129-2', 'kategori' => 'Non-Fiksi', 'stok' => 3],
            ['judul' => 'Python Crash Course', 'pengarang' => 'Eric Matthes', 'penerbit' => 'No Starch Press', 'tahun_terbit' => 2019, 'isbn' => '978-1-59327-928-8', 'kategori' => 'Teknologi', 'stok' => 4],
            ['judul' => 'Harry Potter and the Sorcerer\'s Stone', 'pengarang' => 'J.K. Rowling', 'penerbit' => 'Scholastic', 'tahun_terbit' => 1997, 'isbn' => '978-0-590-35340-3', 'kategori' => 'Fiksi', 'stok' => 5],
            ['judul' => 'The Great Gatsby', 'pengarang' => 'F. Scott Fitzgerald', 'penerbit' => 'Scribner', 'tahun_terbit' => 1925, 'isbn' => '978-0-7432-7356-5', 'kategori' => 'Fiksi', 'stok' => 3],
            ['judul' => 'Rich Dad Poor Dad', 'pengarang' => 'Robert Kiyosaki', 'penerbit' => 'Warner Books', 'tahun_terbit' => 1997, 'isbn' => '978-1-61263-123-6', 'kategori' => 'Non-Fiksi', 'stok' => 4],
        ];

        foreach ($bukuData as $index => $data) {
            $manualCode = 'BKU' . str_pad($index + 1, 5, '0', STR_PAD_LEFT);
            Buku::create(array_merge($data, [
                'kode_buku'     => $manualCode,
                'stok_tersedia' => $data['stok'],
                'created_by'    => $admin->id,
            ]));
        }

        // ─── 3. Peminjaman Transactions (Complete Data) ─────────

        // Get all books
        $buku1 = Buku::where('kode_buku', 'BKU00001')->first();  // Clean Code
        $buku2 = Buku::where('kode_buku', 'BKU00002')->first();  // Laravel
        $buku3 = Buku::where('kode_buku', 'BKU00003')->first();  // Design Patterns
        $buku4 = Buku::where('kode_buku', 'BKU00004')->first();  // Bumi Manusia
        $buku5 = Buku::where('kode_buku', 'BKU00005')->first();  // Laskar Pelangi
        $buku6 = Buku::where('kode_buku', 'BKU00006')->first();  // Sapiens
        $buku7 = Buku::where('kode_buku', 'BKU00007')->first();  // The Alchemist
        $buku8 = Buku::where('kode_buku', 'BKU00008')->first();  // Atomic Habits
        $buku9 = Buku::where('kode_buku', 'BKU00009')->first();  // Python
        $buku10 = Buku::where('kode_buku', 'BKU00010')->first(); // Harry Potter

        // ─── 3.1 PEMINJAMAN STATUS: MENUNGGU (Pending) ─────────

        // PMJ001: Peminjaman menunggu persetujuan - Budi
        Peminjaman::create([
            'kode_peminjaman'         => 'PMJ' . date('Ymd') . '001',
            'user_id'                 => $peminjam1->id,
            'buku_id'                 => $buku9->id,
            'tanggal_pinjam'          => Carbon::now()->addDays(1),
            'tanggal_kembali_rencana' => Carbon::now()->addDays(8),
            'status'                  => 'menunggu',
            'catatan'                 => 'Pengajuan peminjaman baru',
        ]);

        // PMJ002: Peminjaman menunggu persetujuan - Siti
        Peminjaman::create([
            'kode_peminjaman'         => 'PMJ' . date('Ymd') . '002',
            'user_id'                 => $peminjam2->id,
            'buku_id'                 => $buku10->id,
            'tanggal_pinjam'          => Carbon::now()->addDays(2),
            'tanggal_kembali_rencana' => Carbon::now()->addDays(9),
            'status'                  => 'menunggu',
            'catatan'                 => 'Mohon approve buku Harry Potter',
        ]);

        // ─── 3.2 PEMINJAMAN STATUS: DIPINJAM (Currently Borrowed) ─

        // PMJ003: Sedang dipinjam - Budi (3 hari lalu)
        Peminjaman::create([
            'kode_peminjaman'         => 'PMJ' . date('Ymd') . '003',
            'user_id'                 => $peminjam1->id,
            'buku_id'                 => $buku1->id,
            'tanggal_pinjam'          => Carbon::now()->subDays(3),
            'tanggal_kembali_rencana' => Carbon::now()->addDays(4),
            'status'                  => 'dipinjam',
            'approved_by'             => $petugas1->id,
            'catatan'                 => 'Buku Clean Code dipinjam untuk belajar programming',
        ]);
        $buku1->decrement('stok_tersedia');

        // PMJ004: Sedang dipinjam - Dewi (5 hari lalu)
        Peminjaman::create([
            'kode_peminjaman'         => 'PMJ' . date('Ymd') . '004',
            'user_id'                 => $peminjam4->id,
            'buku_id'                 => $buku6->id,
            'tanggal_pinjam'          => Carbon::now()->subDays(5),
            'tanggal_kembali_rencana' => Carbon::now()->addDays(2),
            'status'                  => 'dipinjam',
            'approved_by'             => $petugas2->id,
            'catatan'                 => 'Buku Sapiens untuk tugas sejarah',
        ]);
        $buku6->decrement('stok_tersedia');

        // ─── 3.3 PEMINJAMAN STATUS: DIKEMBALIKAN (Returned On Time) ─

        // PMJ005: Dikembalikan tepat waktu - Ahmad Wijaya
        Peminjaman::create([
            'kode_peminjaman'         => 'PMJ' . date('Ymd') . '005',
            'user_id'                 => $peminjam3->id,
            'buku_id'                 => $buku2->id,
            'tanggal_pinjam'          => Carbon::now()->subDays(10),
            'tanggal_kembali_rencana' => Carbon::now()->subDays(3),
            'tanggal_kembali_aktual'   => Carbon::now()->subDays(3),
            'status'                  => 'dikembalikan',
            'denda'                   => 0,
            'approved_by'             => $petugas1->id,
            'catatan'                 => 'Buku dikembalikan tepat waktu, kondisi baik',
        ]);
        $buku2->increment('stok_tersedia');

        // PMJ006: Dikembalikan tepat waktu - Rudi
        Peminjaman::create([
            'kode_peminjaman'         => 'PMJ' . date('Ymd') . '006',
            'user_id'                 => $peminjam5->id,
            'buku_id'                 => $buku8->id,
            'tanggal_pinjam'          => Carbon::now()->subDays(15),
            'tanggal_kembali_rencana' => Carbon::now()->subDays(8),
            'tanggal_kembali_aktual'   => Carbon::now()->subDays(9),
            'status'                  => 'dikembalikan',
            'denda'                   => 0,
            'approved_by'             => $petugas2->id,
            'catatan'                 => 'Buku Atomic Habits sangat membantu',
        ]);
        $buku8->increment('stok_tersedia');

        // ─── 3.4 PEMINJAMAN STATUS: TERLAMBAT (Late Return WITH FINES) ─

        // PMJ007: Terlambat 3 hari - Siti (denda Rp 15.000)
        Peminjaman::create([
            'kode_peminjaman'         => 'PMJ' . date('Ymd') . '007',
            'user_id'                 => $peminjam2->id,
            'buku_id'                 => $buku4->id,
            'tanggal_pinjam'          => Carbon::now()->subDays(15),
            'tanggal_kembali_rencana' => Carbon::now()->subDays(8),
            'tanggal_kembali_aktual'  => Carbon::now()->subDays(5),
            'status'                  => 'terlambat',
            'denda'                   => 15000,
            'approved_by'             => $petugas1->id,
            'catatan'                 => 'Terlambat 3 hari, denda Rp 15.000 sudah dibayar',
        ]);
        $buku4->increment('stok_tersedia');

        // PMJ008: Terlambat 5 hari - Budi (denda Rp 25.000)
        Peminjaman::create([
            'kode_peminjaman'         => 'PMJ' . date('Ymd') . '008',
            'user_id'                 => $peminjam1->id,
            'buku_id'                 => $buku5->id,
            'tanggal_pinjam'          => Carbon::now()->subDays(20),
            'tanggal_kembali_rencana' => Carbon::now()->subDays(13),
            'tanggal_kembali_aktual'  => Carbon::now()->subDays(8),
            'status'                  => 'terlambat',
            'denda'                   => 25000,
            'approved_by'             => $petugas2->id,
            'catatan'                 => 'Terlambat 5 hari karena kepentingan keluarga, denda lunas',
        ]);
        $buku5->increment('stok_tersedia');

        // PMJ009: Terlambat 2 hari - Rudi (denda Rp 10.000)
        Peminjaman::create([
            'kode_peminjaman'         => 'PMJ' . date('Ymd') . '009',
            'user_id'                 => $peminjam5->id,
            'buku_id'                 => $buku7->id,
            'tanggal_pinjam'          => Carbon::now()->subDays(12),
            'tanggal_kembali_rencana' => Carbon::now()->subDays(5),
            'tanggal_kembali_aktual'  => Carbon::now()->subDays(3),
            'status'                  => 'terlambat',
            'denda'                   => 10000,
            'approved_by'             => $petugas1->id,
            'catatan'                 => 'Terlambat 2 hari, denda Rp 10.000 sudah dibayar',
        ]);
        $buku7->increment('stok_tersedia');

        // PMJ010: Terlambat 4 hari - Ahmad Wijaya (denda Rp 20.000)
        Peminjaman::create([
            'kode_peminjaman'         => 'PMJ' . date('Ymd') . '010',
            'user_id'                 => $peminjam3->id,
            'buku_id'                 => $buku3->id,
            'tanggal_pinjam'          => Carbon::now()->subDays(18),
            'tanggal_kembali_rencana' => Carbon::now()->subDays(11),
            'tanggal_kembali_aktual'  => Carbon::now()->subDays(7),
            'status'                  => 'terlambat',
            'denda'                   => 20000,
            'approved_by'             => $petugas2->id,
            'catatan'                 => 'Terlambat 4 hari karena sakit, denda lunas',
        ]);
        $buku3->increment('stok_tersedia');

        // ─── 3.5 PEMINJAMAN STATUS: DITOLAK (Rejected) ───────────

        // PMJ011: Peminjaman ditolak - Budi (stok tidak cukup)
        Peminjaman::create([
            'kode_peminjaman'         => 'PMJ' . date('Ymd') . '011',
            'user_id'                 => $peminjam1->id,
            'buku_id'                 => $buku8->id,
            'tanggal_pinjam'          => Carbon::now()->subDays(7),
            'tanggal_kembali_rencana' => Carbon::now(),
            'status'                  => 'ditolak',
            'approved_by'             => $petugas1->id,
            'catatan'                 => 'Ditolak: Stok buku Atomic Habits sedang habis',
        ]);

        // PMJ012: Peminjaman ditolak - Dewi (melebihi batas peminjaman)
        Peminjaman::create([
            'kode_peminjaman'         => 'PMJ' . date('Ymd') . '012',
            'user_id'                 => $peminjam4->id,
            'buku_id'                 => $buku9->id,
            'tanggal_pinjam'          => Carbon::now()->subDays(4),
            'tanggal_kembali_rencana' => Carbon::now()->addDays(3),
            'status'                  => 'ditolak',
            'approved_by'             => $petugas2->id,
            'catatan'                 => 'Ditolak: Peminjam masih memiliki peminjaman aktif yang belum dikembalikan',
        ]);

        // ─── 4. Output Informasi ─────────────────────────────────
        $this->command->info('✅ Database Seeder sukses dijalankan!');

        $this->command->info("\n📚 Total Data:");
        $this->command->info('   - Users: ' . User::count());
        $this->command->info('   - Buku: ' . Buku::count());
        $this->command->info('   - Peminjaman: ' . Peminjaman::count());

        $this->command->info("\n📊 Status Peminjaman:");
        $statuses = ['menunggu', 'dipinjam', 'dikembalikan', 'terlambat', 'ditolak'];
        foreach ($statuses as $status) {
            $count = Peminjaman::where('status', $status)->count();
            $this->command->info("   - $status: $count");
        }

        $totalDenda = Peminjaman::where('status', 'terlambat')->sum('denda');
        $this->command->info("\n💰 Total Denda: Rp " . number_format($totalDenda, 0, ',', '.'));

        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Administrator', 'admin@perpustakaan.com', 'password123'],
                ['Petugas', 'petugas@perpustakaan.com', 'password123'],
                ['Petugas', 'ahmad@perpustakaan.com', 'password123'],
                ['Peminjam', 'budi@gmail.com', 'password123'],
                ['Peminjam', 'siti@gmail.com', 'password123'],
                ['Peminjam', 'ahmadwijaya@gmail.com', 'password123'],
                ['Peminjam', 'dewi@gmail.com', 'password123'],
                ['Peminjam', 'rudi@gmail.com', 'password123'],
            ]
        );
    }
}

