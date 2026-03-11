<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoritController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ───────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Administrator Routes ─────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:administrator'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // Manajemen Buku
    Route::resource('buku', BukuController::class);

    // Manajemen User
    Route::resource('users', UserController::class)->except(['show']);

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan', [LaporanController::class, 'generate'])->name('laporan.generate');

    // Peminjaman (admin juga bisa lihat & kelola)
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
    Route::post('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
});

// ─── Petugas Routes ───────────────────────────────────────────────
Route::prefix('petugas')->name('petugas.')->middleware(['auth', 'role:petugas'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'petugas'])->name('dashboard');

    // Petugas: kelola peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
    Route::post('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');

    // Petugas: lihat & tambah data buku
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');
    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');

    // Laporan (petugas bisa generate laporan)
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan', [LaporanController::class, 'generate'])->name('laporan.generate');
});

// ─── Peminjam Routes ──────────────────────────────────────────────
Route::prefix('peminjam')->name('peminjam.')->middleware(['auth', 'role:peminjam'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'peminjam'])->name('dashboard');

    // Katalog buku
    Route::get('/katalog', [BukuController::class, 'catalog'])->name('katalog');

    // Favorit
    Route::get('/favorit', [FavoritController::class, 'index'])->name('favorit.index');
    Route::post('/favorit/toggle', [FavoritController::class, 'toggle'])->name('favorit.toggle');

    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'myPeminjaman'])->name('peminjaman.index');
    Route::get('/peminjaman/create/{buku}', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
});
