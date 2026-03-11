@extends('layouts.app')
@section('title','Katalog Buku')
@section('page-title','Katalog Buku')
@section('content')

<div class="flex items-center justify-between mb-4 flex-wrap gap-3">
    <form method="GET" class="flex gap-2 flex-wrap items-center">
        <div class="search" style="width:300px;">
            <i class="bi bi-search"></i>
            <input type="text" name="search" placeholder="Cari judul atau pengarang..." value="{{ request('search') }}">
        </div>
        <select name="kategori" class="select" style="width:auto;padding:8px 12px;">
            <option value="">Semua Kategori</option>
            @foreach($kategori as $k)
            <option value="{{ $k }}" {{ request('kategori')===$k?'selected':'' }}>{{ $k }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-ghost"><i class="bi bi-funnel"></i></button>
        @if(request()->hasAny(['search','kategori']))
        <a href="{{ route('peminjam.katalog') }}" class="btn btn-ghost"><i class="bi bi-x"></i> Reset</a>
        @endif
    </form>
</div>

<div class="grid" style="grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px;">
    @forelse($buku as $b)
    @php $colors=[['#eef2ff','#c7d2fe','#6366f1'],['#eff6ff','#bfdbfe','#3b82f6'],['#fdf4ff','#e9d5ff','#8b5cf6'],['#ecfdf5','#a7f3d0','#10b981'],['#fffbeb','#fde68a','#f59e0b'],['#fef2f2','#fecaca','#ef4444']]; $c=$colors[($b->id-1)%6]; @endphp
    <div class="card" style="transition:all .2s;overflow:visible;" onmouseenter="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 40px rgba(99,102,241,.14)'" onmouseleave="this.style.transform='none';this.style.boxShadow=''">
        <div style="height:130px;background:linear-gradient(135deg,{{ $c[0] }},{{ $c[1] }});display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;">
            <div style="position:absolute;right:-20px;bottom:-20px;width:90px;height:90px;border-radius:50%;background:{{ $c[2] }};opacity:.12;"></div>
            @if($b->cover)
            <img src="{{ Storage::url($b->cover) }}" style="width:100%;height:100%;object-fit:cover;">
            @else
            <i class="bi bi-book-fill" style="font-size:38px;color:{{ $c[2] }};opacity:.6;"></i>
            @endif
            @if(!$b->isTersedia())
            <div style="position:absolute;inset:0;background:rgba(0,0,0,.4);display:flex;align-items:center;justify-content:center;">
                <span class="badge b-gray">Tidak Tersedia</span>
            </div>
            @endif
        </div>
<div style="padding:14px;">
            <div class="flex items-start justify-between gap-2 mb-1">
                <div class="font-sem truncate" style="font-size:13px;flex:1;">{{ $b->judul }}</div>
                <button type="button" id="fav-btn-{{ $b->id }}" onclick="toggleFavorit({{ $b->id }})" style="background:none;border:none;cursor:pointer;padding:4px;display:inline-flex;" title="{{ Auth::user()->isFavorit($b) ? 'Hapus dari favorit' : 'Tambah ke favorit' }}">
                    <i id="fav-icon-{{ $b->id }}" class="bi {{ Auth::user()->isFavorit($b) ? 'bi-heart-fill' : 'bi-heart' }}" style="color: {{ Auth::user()->isFavorit($b) ? '#ef4444' : '#94a3b8' }};font-size:18px;"></i>
                </button>
            </div>
            <div class="text-xs text-muted mb-2">{{ $b->pengarang }}</div>
            <div class="flex items-center justify-between mb-3">
                <span class="badge b-purple" style="font-size:9.5px;">{{ $b->kategori }}</span>
                <span class="text-xs" style="color:{{ $b->stok_tersedia>0?'#10b981':'#ef4444' }};font-weight:600;">
                    {{ $b->stok_tersedia }}/{{ $b->stok }} tersedia
                </span>
            </div>
            @if($b->isTersedia())
            <a href="{{ route('peminjam.peminjaman.create',$b->id) }}" class="btn btn-primary w-full" style="justify-content:center;font-size:12.5px;">
                <i class="bi bi-bookmark-plus"></i> Pinjam
            </a>
            @else
            <button class="btn btn-ghost w-full" style="justify-content:center;font-size:12.5px;cursor:not-allowed;opacity:.6;" disabled>Stok Habis</button>
            @endif
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1;">
        <div class="card">
            <div class="empty">
                <div class="empty-icon"><i class="bi bi-search"></i></div>
                <h6>Buku tidak ditemukan</h6>
                <p>Coba kata kunci yang berbeda</p>
            </div>
        </div>
    </div>
    @endforelse
</div>

<script>
function toggleFavorit(bukuId) {
    fetch('{{ route("peminjam.favorit.toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ buku_id: bukuId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const icon = document.getElementById('fav-icon-' + bukuId);
            const btn = document.getElementById('fav-btn-' + bukuId);
            if (data.is_favorit) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                icon.style.color = '#ef4444';
                btn.title = 'Hapus dari favorit';
            } else {
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
                icon.style.color = '#94a3b8';
                btn.title = 'Tambah ke favorit';
            }
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection
