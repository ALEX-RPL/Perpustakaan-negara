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
        // ─── Users ────────────────────────────────────────────
        $admin = User::create([
            'name'       => 'Administrator',
            'email'      => 'admin@perpustakaan.com',
            'password'   => Hash::make('password123'),
            'role'       => 'administrator',
            'no_telepon' => '081234567890',
            'alamat'     => 'Kantor Perpustakaan, Jl. Pendidikan No. 1',
        ]);

        $petugas = User::create([
            'name'       => 'Petugas Perpustakaan',
            'email'      => 'petugas@perpustakaan.com',
            'password'   => Hash::make('password123'),
            'role'       => 'petugas',
            'no_telepon' => '082345678901',
            'alamat'     => 'Jl. Guru No. 5',
        ]);

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

        // ─── Buku ─────────────────────────────────────────────
        $bukuData = [
            ['judul' => 'Clean Code', 'pengarang' => 'Robert C. Martin', 'penerbit' => 'Prentice Hall', 'tahun_terbit' => 2008, 'isbn' => '978-0-13-235088-4', 'kategori' => 'Teknologi', 'stok' => 3],
            ['judul' => 'Laravel: Up and Running', 'pengarang' => 'Matt Stauffer', 'penerbit' => "O'Reilly", 'tahun_terbit' => 2022, 'isbn' => '978-1-098-12133-9', 'kategori' => 'Teknologi', 'stok' => 2],
            ['judul' => 'Design Patterns', 'pengarang' => 'Gang of Four', 'penerbit' => 'Addison-Wesley', 'tahun_terbit' => 1994, 'isbn' => '978-0-201-63361-0', 'kategori' => 'Teknologi', 'stok' => 2],
            ['judul' => 'Bumi Manusia', 'pengarang' => 'Pramoedya Ananta Toer', 'penerbit' => 'Hasta Mitra', 'tahun_terbit' => 1980, 'isbn' => '978-979-419-019-7', 'kategori' => 'Fiksi', 'stok' => 4],
            ['judul' => 'Laskar Pelangi', 'pengarang' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => 2005, 'isbn' => '979-3062-79-7', 'kategori' => 'Fiksi', 'stok' => 5],
            ['judul' => 'Sapiens', 'pengarang' => 'Yuval Noah Harari', 'penerbit' => 'Harper Collins', 'tahun_terbit' => 2011, 'isbn' => '978-0-06-231609-7', 'kategori' => 'Sejarah', 'stok' => 2],
            ['judul' => 'The Alchemist', 'pengarang' => 'Paulo Coelho', 'penerbit' => 'HarperOne', 'tahun_terbit' => 1988, 'isbn' => '978-0-06-112241-5', 'kategori' => 'Fiksi', 'stok' => 3],
            ['judul' => 'Atomic Habits', 'pengarang' => 'James Clear', 'penerbit' => 'Avery', 'tahun_terbit' => 2018, 'isbn' => '978-0-7352-1129-2', 'kategori' => 'Non-Fiksi', 'stok' => 3],
        ];

        foreach ($bukuData as $data) {
            Buku::create(array_merge($data, [
                'kode_buku'     => Buku::generateKode(),
                'stok_tersedia' => $data['stok'],
                'created_by'    => $admin->id,
            ]));
        }

        // ─── Sample Peminjaman ────────────────────────────────
        $buku1 = Buku::first();
        $buku2 = Buku::skip(1)->first();

        Peminjaman::create([
            'kode_peminjaman'         => Peminjaman::generateKode(),
            'user_id'                 => $peminjam1->id,
            'buku_id'                 => $buku1->id,
            'tanggal_pinjam'          => Carbon::now()->subDays(3),
            'tanggal_kembali_rencana' => Carbon::now()->addDays(4),
            'status'                  => 'dipinjam',
            'approved_by'             => $petugas->id,
        ]);
        $buku1->decrement('stok_tersedia');

        Peminjaman::create([
            'kode_peminjaman'         => Peminjaman::generateKode(),
            'user_id'                 => $peminjam2->id,
            'buku_id'                 => $buku2->id,
            'tanggal_pinjam'          => Carbon::now(),
            'tanggal_kembali_rencana' => Carbon::now()->addDays(7),
            'status'                  => 'menunggu',
        ]);

        $this->command->info('✅ Seeder berhasil!');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Administrator', 'admin@perpustakaan.com', 'password123'],
                ['Petugas', 'petugas@perpustakaan.com', 'password123'],
                ['Peminjam', 'budi@gmail.com', 'password123'],
                ['Peminjam', 'siti@gmail.com', 'password123'],
            ]
        );
    }
}
