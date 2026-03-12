<div class="sb-section">Menu</div>
<div class="sb-item">
    <a href="{{ route('admin.dashboard') }}" class="sb-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <div class="sb-link-icon"><i class="bi bi-grid-1x2-fill"></i></div>
        <span class="sb-link-txt">Dashboard</span>
    </a>
</div>
<div class="sb-section">Perpustakaan</div>
<div class="sb-item">
    <a href="{{ route('admin.buku.index') }}" class="sb-link {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
        <div class="sb-link-icon"><i class="bi bi-book-fill"></i></div>
        <span class="sb-link-txt">Koleksi Buku</span>
    </a>
</div>
<div class="sb-item">
    <a href="{{ route('admin.favorit.index') }}" class="sb-link {{ request()->routeIs('admin.favorit.*') ? 'active' : '' }}">
        <div class="sb-link-icon"><i class="bi bi-heart-fill"></i></div>
        <span class="sb-link-txt">Buku Favorit</span>
    </a>
</div>
<div class="sb-item">
    <a href="{{ route('admin.peminjaman.index') }}" class="sb-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
        <div class="sb-link-icon"><i class="bi bi-arrow-left-right"></i></div>
        <span class="sb-link-txt">Peminjaman</span>
        @php $menunggu = \App\Models\Peminjaman::where('status','menunggu')->count(); @endphp
        @if($menunggu > 0) <span class="sb-badge">{{ $menunggu }}</span> @endif
    </a>
</div>
<div class="sb-section">Pengguna</div>
<div class="sb-item">
    <a href="{{ route('admin.users.index') }}" class="sb-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <div class="sb-link-icon"><i class="bi bi-people-fill"></i></div>
        <span class="sb-link-txt">Manajemen User</span>
    </a>
</div>
<div class="sb-section">Analitik</div>
<div class="sb-item">
    <a href="{{ route('admin.laporan.index') }}" class="sb-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
        <div class="sb-link-icon"><i class="bi bi-bar-chart-fill"></i></div>
        <span class="sb-link-txt">Laporan</span>
    </a>
</div>
