<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function bukuFavorit(): BelongsToMany
    {
        return $this->belongsToMany(Buku::class, 'buku_favorit', 'user_id', 'buku_id')
            ->withTimestamps();
    }

    public function toggleFavorit(Buku $buku): bool
    {
        $exists = $this->bukuFavorit()->where('buku_id', $buku->id)->exists();
        
        if ($exists) {
            $this->bukuFavorit()->detach($buku->id);
            return false;
        } else {
            $this->bukuFavorit()->attach($buku->id);
            return true;
        }
    }

    public function isFavorit(Buku $buku): bool
    {
        return $this->bukuFavorit()->where('buku_id', $buku->id)->exists();
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
