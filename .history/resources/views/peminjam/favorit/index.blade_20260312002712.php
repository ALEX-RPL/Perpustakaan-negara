@extends('layouts.app')
@section('title', 'Buku Favorit')
@section('page-title', 'Buku Favorit')

@section('content')
<div class="flex items-center justify-between mb-4 flex-wrap gap-3">
    <h2 style="font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 700; margin:0;">
        <i class="bi bi-heart-fill" style="color: #ef4444;"></i> Buku Favorit Saya
    </h2>
    <a href="{{ route('peminjam.katalog') }}" class="btn btn-primary">
        <i class="bi bi-book"></i> Lihat Katalog
    </a>
</div>

@if($favorit->isEmpty())
    <div class="card">
        <div class="empty">
            <div class="empty-icon"><i class="bi bi-heart"></i></div>
            <h6>Belum Ada Buku Favorit</h6>
            <p>Silakan tambahkan buku favorit dari katalog.</p>
            <a href="{{ route('peminjam.katalog') }}" class="btn btn-primary mt-2">
                Browse Katalog
            </a>
        </div>
    </div>
@else
    <div class="grid" style="grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px;">
        @foreach($favorit as $b)
        @php $colors=[['#eef2ff','#c7d2fe','#6366f1'],['#eff6ff','#bfdbfe','#3b82f6'],['#fdf4ff','#e9d5ff','#8b5cf6'],['#ecfdf5','#a7f3d0','#10b981'],['#fffbeb','#fde68a','#f59e0b'],['#fef2f2','#fecaca','#ef4444']]; $c=$colors[($b->id-1)%6]; @endphp
        <div class="card" style="transition:all .2s;" onmouseenter="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 40px rgba(99,102,241,.14)'" onmouseleave="this.style.transform='none';this.style.boxShadow=''">
            <div style="height:130px;background:linear-gradient(135deg,{{ $c[0] }},{{ $c[1] }});display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;">
                <div style="position:absolute;right:-20px;bottom:-20px;width:90px;height:90px;border-radius:50%;background:{{ $c[2] }};opacity:.12;"></div>
                @if($b->cover)
                <img src="{{ Storage::url($b->cover) }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                <i class="bi bi-book-fill" style="font-size:38px;color:{{ $c[2] }};opacity:.6;"></i>
                @endif
            </div>
            <div style="padding:14px;">
                <div class="flex items-start justify-between gap-2 mb-1">
                    <div class="font-sem truncate" style="font-size:13px;flex:1;">{{ $b->judul }}</div>
                    <button type="button" id="fav-btn-{{ $b->id }}" onclick="toggleFavorit({{ $b->id }})" title="Hapus dari favorit">
                        <i id="fav-icon-{{ $b->id }}" class="bi bi-heart-fill" style="color:#ef4444;font-size:18px;"></i>
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
        @endforeach
    </div>
@endif

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
            // On favorit page, remove the card if unfavorited
            if (!data.is_favorit) {
                const btn = document.querySelector('#fav-btn-' + bukuId);
                if (btn) {
                    const card = btn.closest('.card');
                    if (card) {
                        card.style.transition = 'opacity 0.3s, transform 0.3s';
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.9)';
                        setTimeout(() => {
                            card.remove();
                            // Check if no more cards
                            const grid = document.querySelector('.grid');
                            const cards = grid.querySelectorAll('.card');
                            if (cards.length === 0) {
                                location.reload();
                            }
                        }, 300);
                    }
                }
            }
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection

