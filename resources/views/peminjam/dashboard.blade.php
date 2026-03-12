@extends('layouts.app')
@section('title','Beranda')
@section('page-title','Beranda')
@section('content')

{{-- Welcome banner --}}
<div class="card mb-4" style="background:linear-gradient(135deg,#4338ca,#6366f1,#8b5cf6);border:none;padding:26px 28px;position:relative;overflow:hidden;">
    <div style="position:absolute;right:-30px;top:-30px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.06);"></div>
    <div style="position:absolute;right:80px;bottom:-50px;width:150px;height:150px;border-radius:50%;background:rgba(255,255,255,.04);"></div>
    <div class="flex items-center justify-between flex-wrap gap-3" style="position:relative;">
        <div>
            <div style="font-size:11px;font-weight:600;color:rgba(255,255,255,.6);letter-spacing:.06em;text-transform:uppercase;margin-bottom:6px;">Selamat datang kembali</div>
            <h2 style="font-family:'Outfit',sans-serif;color:#fff;font-size:22px;font-weight:750;letter-spacing:-.02em;margin-bottom:6px;">{{ auth()->user()->name }} 👋</h2>
            <p style="color:rgba(255,255,255,.6);font-size:13px;">Temukan dan pinjam buku favoritmu hari ini</p>
        </div>
        <a href="{{ route('peminjam.katalog') }}" class="btn" style="background:rgba(255,255,255,.12);color:#fff;border:1px solid rgba(255,255,255,.2);backdrop-filter:blur(8px);">
            <i class="bi bi-search"></i> Cari Buku
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="grid gstats mb-4">
    <div class="stat-card ac-indigo">
        <div class="flex items-center justify-between mb-3">
            <div class="stat-icon" style="background:rgba(99,102,241,.12);color:#6366f1;"><i class="bi bi-journal-bookmark-fill"></i></div>
        </div>
        <div class="stat-num" data-value="{{ $stats['total'] }}">{{ $stats['total'] }}</div>
        <div class="stat-lbl">Total Peminjaman</div>
        <div class="stat-ring"></div>
    </div>
    <div class="stat-card ac-amber">
        <div class="flex items-center justify-between mb-3">
            <div class="stat-icon" style="background:rgba(245,158,11,.12);color:#f59e0b;"><i class="bi bi-book-fill"></i></div>
        </div>
        <div class="stat-num" data-value="{{ $stats['aktif'] }}">{{ $stats['aktif'] }}</div>
        <div class="stat-lbl">Sedang Dipinjam</div>
        <div class="stat-ring" style="background:#f59e0b;"></div>
    </div>
    <div class="stat-card ac-emerald">
        <div class="flex items-center justify-between mb-3">
            <div class="stat-icon" style="background:rgba(16,185,129,.12);color:#10b981;"><i class="bi bi-check-circle-fill"></i></div>
        </div>
        <div class="stat-num" data-value="{{ $stats['selesai'] }}">{{ $stats['selesai'] }}</div>
        <div class="stat-lbl">Buku Dikembalikan</div>
        <div class="stat-ring" style="background:#10b981;"></div>
    </div>
    <div class="stat-card ac-rose">
        <div class="flex items-center justify-between mb-3">
            <div class="stat-icon" style="background:rgba(239,68,68,.12);color:#ef4444;"><i class="bi bi-cash-coin"></i></div>
        </div>
        <div class="stat-num" style="font-size:18px;">Rp {{ number_format($stats['total_denda'],0,',','.') }}</div>
        <div class="stat-lbl">Total Denda</div>
        <div class="stat-ring" style="background:#ef4444;"></div>
    </div>
</div>

<div class="grid g2" style="gap:16px;">
    {{-- My borrows --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="bi bi-clock-history" style="color:#6366f1;"></i> Peminjaman Aktif</div>
            <a href="{{ route('peminjam.peminjaman.index') }}" class="btn btn-ghost btn-sm">Riwayat</a>
        </div>
        <div class="tbl-wrap">
            <table class="tbl">
                <thead><tr><th>Buku</th><th>Jatuh Tempo</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($peminjaman as $p)
                    @php $sc=['menunggu'=>'b-amber','dipinjam'=>'b-blue','dikembalikan'=>'b-green','terlambat'=>'b-red','ditolak'=>'b-gray']; @endphp
                    <tr>
                        <td>
                            <div class="font-sem truncate" style="max-width:160px;font-size:13px;">{{ $p->buku->judul }}</div>
                            <div class="text-xs text-muted">{{ $p->tanggal_pinjam->format('d M Y') }}</div>
                        </td>
                        <td class="text-sm">{{ $p->tanggal_kembali_rencana->format('d M Y') }}</td>
                        <td><span class="badge {{ $sc[$p->status]??'b-gray' }}">{{ ucfirst($p->status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="3">
                        <div class="empty" style="padding:24px;">
                            <div class="empty-icon" style="width:40px;height:40px;font-size:18px;margin-bottom:8px;"><i class="bi bi-book"></i></div>
                            <p class="text-xs">Belum ada peminjaman</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Book recommendations --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="bi bi-stars" style="color:#f59e0b;"></i> Buku Terbaru</div>
            <a href="{{ route('peminjam.katalog') }}" class="btn btn-ghost btn-sm">Katalog</a>
        </div>
        <div style="padding:8px 12px;">
            @foreach($bukuTerbaru as $b)
            <div class="flex items-center gap-3" style="padding:10px 8px;border-radius:10px;transition:background .15s;cursor:default;" onmouseenter="this.style.background='#f8fafc'" onmouseleave="this.style.background='transparent'">
                <div style="width:36px;height:48px;border-radius:7px;background:linear-gradient(135deg,{{ ['#eef2ff','#eff6ff','#fdf4ff','#ecfdf5','#fffbeb','#fef2f2'][($b->id-1)%6] }},{{ ['#c7d2fe','#bfdbfe','#e9d5ff','#a7f3d0','#fde68a','#fecaca'][($b->id-1)%6] }});display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-book-fill" style="font-size:13px;color:{{ ['#6366f1','#3b82f6','#8b5cf6','#10b981','#f59e0b','#ef4444'][($b->id-1)%6] }};"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="font-sem truncate" style="font-size:13px;">{{ Str::limit($b->judul,28) }}</div>
                    <div class="text-xs text-muted">{{ $b->pengarang }}</div>
                </div>
                @if($b->isTersedia())
                <a href="{{ route('peminjam.peminjaman.create',$b->id) }}" class="btn btn-primary btn-sm" style="flex-shrink:0;">
                    <i class="bi bi-plus-lg"></i>
                </a>
                @else
                <span class="badge b-gray">Habis</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
