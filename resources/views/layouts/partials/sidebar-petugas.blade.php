<div class="nav-section">Menu Utama</div>
<div class="nav-item">
    <a href="{{ route('petugas.dashboard') }}" class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2-fill"></i> Dashboard
    </a>
</div>

<div class="nav-section">Perpustakaan</div>
<div class="nav-item">
    <a href="{{ route('petugas.buku.index') }}" class="{{ request()->routeIs('petugas.buku.*') ? 'active' : '' }}">
        <i class="bi bi-book-fill"></i> Data Buku
    </a>
</div>
<div class="nav-item">
    <a href="{{ route('petugas.peminjaman.index') }}" class="{{ request()->routeIs('petugas.peminjaman.*') ? 'active' : '' }}">
        <i class="bi bi-arrow-left-right"></i> Peminjaman
    </a>
</div>

<div class="nav-section">Laporan</div>
<div class="nav-item">
    <a href="{{ route('petugas.laporan.index') }}" class="{{ request()->routeIs('petugas.laporan.*') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-bar-graph-fill"></i> Laporan
    </a>
</div>
