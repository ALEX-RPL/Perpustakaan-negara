<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'kode_peminjaman', 'user_id', 'buku_id',
        'tanggal_pinjam', 'tanggal_kembali_rencana',
        'tanggal_kembali_aktual', 'status', 'denda',
        'catatan', 'approved_by',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Helpers
    public function isOverdue(): bool
    {
        return $this->status === 'dipinjam' &&
               Carbon::now()->greaterThan($this->tanggal_kembali_rencana);
    }

    public function hitungDenda(): int
    {
        if (!$this->isOverdue()) return 0;
        $hariTerlambat = Carbon::now()->diffInDays($this->tanggal_kembali_rencana);
        return $hariTerlambat * 1000; // Rp 1.000/hari
    }

    public static function generateKode(): string
    {
        $last = static::latest()->first();
        $number = $last ? (intval(substr($last->kode_peminjaman, 3)) + 1) : 1;
        return 'PMJ' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'menunggu'    => 'warning',
            'dipinjam'    => 'primary',
            'dikembalikan'=> 'success',
            'terlambat'   => 'danger',
            'ditolak'     => 'secondary',
            default       => 'light',
        };
    }
}
