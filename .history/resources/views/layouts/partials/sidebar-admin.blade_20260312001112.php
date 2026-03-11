<div class="nav-section">Menu Utama</div>
<div class="nav-item">
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2-fill"></i> Dashboard
    </a>
</div>

<div class="nav-section">Perpustakaan</div>
<div class="nav-item">
    <a href="{{ route('admin.buku.index') }}" class="{{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
        <i class="bi bi-book-fill"></i> Data Buku
    </a>
</div>
<div class="nav-item">
    <a href="{{ route('admin.peminjaman.index') }}" class="{{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
        <i class="bi bi-arrow-left-right"></i> Peminjaman
    </a>
</div>
<div class="nav-item">
    <a href="{{ route('admin.favorit.index') }}" class="{{ request()->routeIs('admin.favorit.*') ? 'active' : '' }}">
        <i class="bi bi-heart-fill"></i> Buku Favorit
    </a>
</div>

<div class="nav-section">Pengguna</div>
<div class="nav-item">
    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <i class="bi bi-people-fill"></i> Manajemen User
    </a>
</div>

<div class="nav-section">Laporan</div>
<div class="nav-item">
    <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-bar-graph-fill"></i> Generate Laporan
    </a>
</div>
