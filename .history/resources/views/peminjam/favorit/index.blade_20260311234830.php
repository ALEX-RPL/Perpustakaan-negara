@extends('layouts.app')
@section('title', 'Buku Favorit')
@section('page-title', 'Buku Favorit')

@section('content')
<div class="flex items-center justify-between mb-4 flex-wrap gap-3">
    <h2 style="font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 700; margin:0;">
        <i class="bi bi-heart-fill" style="color: #ef4444;"></i> Buku Favorit Saya
    </h2>
            <i class="bi bi-book"></i> Lihat Katalog
        </a>
    </div>

    @if($favorit->isEmpty())
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-heart display-1"></i>
            <h4 class="mt-3">Belum Ada Buku Favorit</h4>
            <p class="text-muted">Silakan tambahkan buku favorit dari katalog.</p>
            <a href="{{ route('peminjam.katalog') }}" class="btn btn-primary mt-2">
                Browse Katalog
            </a>
        </div>
    @else
        <div class="row">
            @foreach($favorit as $buku)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-truncate">{{ $buku->judul }}</h5>
                            <p class="text-muted small mb-1">{{ $buku->pengarang }}</p>
                            <p class="small mb-2">
                                <span class="badge bg-secondary">{{ $buku->kategori }}</span>
                            </p>
                            <p class="small text-muted">
                                <i class="bi bi-building"></i> {{ $buku->penerbit }}<br>
                                <i class="bi bi-calendar"></i> {{ $buku->tahun_terbit }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge {{ $buku->stok_tersedia > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $buku->stok_tersedia > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                                <small class="text-muted">Stok: {{ $buku->stok_tersedia }}/{{ $buku->stok }}</small>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <div class="d-grid gap-2">
                                @if($buku->stok_tersedia > 0)
                                    <a href="{{ route('peminjam.peminjaman.create', $buku) }}" class="btn btn-success btn-sm">
                                        <i class="bi bi-book"></i> Pinjam Buku
                                    </a>
                                @endif
                                <button class="btn btn-outline-danger btn-sm btn-unfavorit" data-buku-id="{{ $buku->id }}">
                                    <i class="bi bi-heart-fill"></i> Hapus dari Favorit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $favorit->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
document.querySelectorAll('.btn-unfavorit').forEach(button => {
    button.addEventListener('click', function() {
        const bukuId = this.dataset.bukuId;
        
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
                location.reload();
            }
        });
    });
});
</script>
@endpush
@endsection

