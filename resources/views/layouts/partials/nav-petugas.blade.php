<div class="sb-section">Menu</div>
<div class="sb-item">
    <a href="{{ route('petugas.dashboard') }}" class="sb-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
        <div class="sb-link-icon"><i class="bi bi-grid-1x2-fill"></i></div>
        <span class="sb-link-txt">Dashboard</span>
    </a>
</div>
<div class="sb-section">Perpustakaan</div>
<div class="sb-item">
    <a href="{{ route('petugas.buku.index') }}" class="sb-link {{ request()->routeIs('petugas.buku.*') ? 'active' : '' }}">
        <div class="sb-link-icon"><i class="bi bi-book-fill"></i></div>
        <span class="sb-link-txt">Koleksi Buku</span>
    </a>
</div>
<div class="sb-item">
    <a href="{{ route('petugas.peminjaman.index') }}" class="sb-link {{ request()->routeIs('petugas.peminjaman.*') ? 'active' : '' }}">
        <div class="sb-link-icon"><i class="bi bi-arrow-left-right"></i></div>
        <span class="sb-link-txt">Peminjaman</span>
        @php $menunggu = \App\Models\Peminjaman::where('status','menunggu')->count(); @endphp
        @if($menunggu > 0) <span class="sb-badge">{{ $menunggu }}</span> @endif
    </a>
</div>
<div class="sb-section">Analitik</div>
<div class="sb-item">
    <a href="{{ route('petugas.laporan.index') }}" class="sb-link {{ request()->routeIs('petugas.laporan.*') ? 'active' : '' }}">
        <div class="sb-link-icon"><i class="bi bi-bar-chart-fill"></i></div>
        <span class="sb-link-txt">Laporan</span>
    </a>
</div>
