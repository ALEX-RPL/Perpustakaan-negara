<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'no_telepon', 'alamat', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function bukuDibuat()
    {
        return $this->hasMany(Buku::class, 'created_by');
    }

    // Role Helpers
    public function isAdministrator(): bool
    {
        return $this->role === 'administrator';
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function isPeminjam(): bool
    {
        return $this->role === 'peminjam';
    }

    public function isStaff(): bool
    {
        return in_array($this->role, ['administrator', 'petugas']);
    }
}
