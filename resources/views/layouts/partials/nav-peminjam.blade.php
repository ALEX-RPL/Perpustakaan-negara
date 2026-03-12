<div class="sb-section">Menu</div>
<div class="sb-item">
    <a href="{{ route('peminjam.dashboard') }}" class="sb-link {{ request()->routeIs('peminjam.dashboard') ? 'active' : '' }}">
        <div class="sb-link-icon"><i class="bi bi-grid-1x2-fill"></i></div>
        <span class="sb-link-txt">Beranda</span>
    </a>
</div>
<div class="sb-section">Buku</div>
<div class="sb-item">
    <a href="{{ route('peminjam.katalog') }}" class="sb-link {{ request()->routeIs('peminjam.katalog') ? 'active' : '' }}">
        <div class="sb-link-icon"><i class="bi bi-collection-fill"></i></div>
        <span class="sb-link-txt">Katalog Buku</span>
    </a>
</div>
<div class="sb-item">
    <a href="{{ route('peminjam.favorit.index') }}" class="sb-link {{ request()->routeIs('peminjam.favorit.*') ? 'active' : '' }}">
        <div class="sb-link-icon"><i class="bi bi-heart-fill"></i></div>
        <span class="sb-link-txt">Buku Favorit</span>
    </a>
</div>
<div class="sb-item">
    <a href="{{ route('peminjam.peminjaman.index') }}" class="sb-link {{ request()->routeIs('peminjam.peminjaman.*') ? 'active' : '' }}">
        <div class="sb-link-icon"><i class="bi bi-clock-history"></i></div>
        <span class="sb-link-txt">Peminjaman Saya</span>
        @php $aktif = \App\Models\Peminjaman::where('user_id',auth()->id())->whereIn('status',['menunggu','dipinjam'])->count(); @endphp
        @if($aktif > 0) <span class="sb-badge">{{ $aktif }}</span> @endif
    </a>
</div>
