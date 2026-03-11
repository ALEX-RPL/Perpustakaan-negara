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
        $last = static::latest()->first();
        $number = $last ? (intval(substr($last->kode_buku, 3)) + 1) : 1;
        return 'BKU' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }
}
