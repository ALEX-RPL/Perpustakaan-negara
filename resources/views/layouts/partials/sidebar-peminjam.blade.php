<div class="nav-section">Menu Utama</div>
<div class="nav-item">
    <a href="{{ route('peminjam.dashboard') }}" class="{{ request()->routeIs('peminjam.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2-fill"></i> Dashboard
    </a>
</div>

<div class="nav-section">Buku</div>
<div class="nav-item">
    <a href="{{ route('peminjam.katalog') }}" class="{{ request()->routeIs('peminjam.katalog') ? 'active' : '' }}">
        <i class="bi bi-book-fill"></i> Katalog Buku
    </a>
</div>
<div class="nav-item">
    <a href="{{ route('peminjam.favorit.index') }}" class="{{ request()->routeIs('peminjam.favorit.*') ? 'active' : '' }}">
        <i class="bi bi-heart-fill"></i> Buku Favorit
    </a>
</div>
<div class="nav-item">
    <a href="{{ route('peminjam.peminjaman.index') }}" class="{{ request()->routeIs('peminjam.peminjaman.*') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i> Riwayat Peminjaman
    </a>
</div>
