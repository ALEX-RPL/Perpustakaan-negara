<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'kode_buku', 'judul', 'pengarang', 'penerbit',
        'tahun_terbit', 'isbn', 'kategori', 'stok',
        'stok_tersedia', 'deskripsi', 'cover',
        'is_active', 'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tahun_terbit' => 'integer',
    ];

    // Relationships
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Helper
    public function isTersedia(): bool
    {
        return $this->stok_tersedia > 0 && $this->is_active;
    }

    // Generate kode buku otomatis
    public static function generateKode(): string
    {
        // Retry up to 10 times to handle concurrent requests
        for ($i = 0; $i < 10; $i++) {
            // Get the highest kode_buku number from database
            $last = static::orderByRaw("CAST(SUBSTRING(kode_buku, 4) AS UNSIGNED) DESC")->first();
            $number = $last ? (intval(substr($last->kode_buku, 3)) + 1) : 1;
            $kode = 'BKU' . str_pad($number, 5, '0', STR_PAD_LEFT);

            // Check if kode already exists
            if (!static::where('kode_buku', $kode)->exists()) {
                return $kode;
            }
        }

        // Fallback: use timestamp-based unique code
        return 'BKU' . str_pad(time() % 100000, 5, '0', STR_PAD_LEFT);
    }

    // Generate ISBN-13 otomatis
    public static function generateISBN(): string
    {
        // Retry up to 10 times to find unique ISBN
        for ($i = 0; $i < 10; $i++) {
            // Format: 978 + 2 digit category code + 8 digit unique number + check digit
            // Menggunakan prefix 978 (Indonesia/Asia)
            $category = str_pad(rand(1, 99), 2, '0', STR_PAD_LEFT);
            $uniqueNum = str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT);

            $partial = '978' . $category . $uniqueNum;

            // Hitung check digit untuk ISBN-13
            $sum = 0;
            for ($j = 0; $j < 12; $j++) {
                $sum += (int)$partial[$j] * ($j % 2 === 0 ? 1 : 3);
            }

            $checkDigit = (10 - ($sum % 10)) % 10;
            $isbn = $partial . $checkDigit;

            // Check if ISBN already exists
            if (!static::where('isbn', $isbn)->exists()) {
                return $isbn;
            }
        }

        // Fallback: use timestamp-based unique ISBN
        $timestamp = time();
        $partial = '978' . str_pad($timestamp % 10000000000, 10, '0', STR_PAD_LEFT);
        $sum = 0;
        for ($j = 0; $j < 12; $j++) {
            $sum += (int)$partial[$j] * ($j % 2 === 0 ? 1 : 3);
        }
        $checkDigit = (10 - ($sum % 10)) % 10;
        return $partial . $checkDigit;
    }
}
