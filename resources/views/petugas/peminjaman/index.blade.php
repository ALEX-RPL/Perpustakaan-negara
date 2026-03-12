@extends('layouts.app')
@section('title','Manajemen Peminjaman')
@section('page-title','Peminjaman')
@section('content')
@php $prefix = auth()->user()->isAdministrator() ? 'admin' : 'petugas'; @endphp

<div class="flex items-center justify-between mb-4 flex-wrap gap-3">
    <form method="GET" class="flex gap-2 flex-wrap items-center">
        <div class="search" style="width:280px;">
            <i class="bi bi-search"></i>
            <input type="text" name="search" placeholder="Cari nama, buku, kode..." value="{{ request('search') }}">
        </div>
        <select name="status" class="select" style="width:auto;padding:8px 12px;">
            <option value="">Semua Status</option>
            @foreach(['menunggu','dipinjam','dikembalikan','terlambat','ditolak'] as $s)
            <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-ghost"><i class="bi bi-funnel"></i></button>
        @if(request()->hasAny(['search','status']))
        <a href="{{ url()->current() }}" class="btn btn-ghost"><i class="bi bi-x"></i></a>
        @endif
    </form>
</div>

{{-- Quick stats strip --}}
<div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(110px,1fr));gap:8px;margin-bottom:16px;">
    @php
    $statuses = ['menunggu'=>['b-amber','clock'],'dipinjam'=>['b-blue','book'],'dikembalikan'=>['b-green','check-circle'],'terlambat'=>['b-red','exclamation-triangle']];
    @endphp
    @foreach($statuses as $s => [$cls,$icon])
    <a href="{{ url()->current() }}?status={{ $s }}" style="text-decoration:none;">
        <div class="card" style="padding:12px 14px;transition:all .2s;{{ request('status')===$s?'border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12);':'' }}">
            <div class="flex items-center gap-2">
                <i class="bi bi-{{ $icon }}" style="font-size:13px;"></i>
                <span class="text-xs font-sem">{{ ucfirst($s) }}</span>
            </div>
            <div style="font-family:'Outfit',sans-serif;font-size:20px;font-weight:700;margin-top:4px;">
                {{ \App\Models\Peminjaman::where('status',$s)->count() }}
            </div>
        </div>
    </a>
    @endforeach
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="bi bi-arrow-left-right" style="color:#6366f1;"></i> Daftar Peminjaman</div>
        <span class="text-muted text-sm">{{ $peminjaman->total() }} transaksi</span>
    </div>
    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr><th>Kode</th><th>Peminjam</th><th>Buku</th><th>Pinjam</th><th>Jatuh Tempo</th><th>Status</th><th>Denda</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $p)
                @php
                $sc=['menunggu'=>'b-amber','dipinjam'=>'b-blue','dikembalikan'=>'b-green','terlambat'=>'b-red','ditolak'=>'b-gray'];
                @endphp
                <tr>
                    <td><span class="code">{{ $p->kode_peminjaman }}</span></td>
                    <td>
                        <div class="flex items-center gap-2">
                            <div class="avatar" style="width:28px;height:28px;font-size:10px;border-radius:7px;">{{ strtoupper(substr($p->user->name??'?',0,2)) }}</div>
                            <div>
                                <div class="font-sem" style="font-size:12.5px;">{{ $p->user->name }}</div>
                                <div class="text-xs text-muted">{{ $p->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="truncate font-sem" style="max-width:150px;font-size:12.5px;">{{ $p->buku->judul }}</div>
                        <div class="text-xs text-muted">{{ $p->buku->kode_buku }}</div>
                    </td>
                    <td class="text-sm text-muted">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                    <td>
                        <span style="font-size:12.5px;">{{ $p->tanggal_kembali_rencana->format('d M Y') }}</span>
                        @if($p->isOverdue())
                        <div><span class="badge b-red" style="font-size:9px;">Terlambat</span></div>
                        @endif
                    </td>
                    <td><span class="badge {{ $sc[$p->status]??'b-gray' }}">{{ ucfirst($p->status) }}</span></td>
                    <td>
                        @if($p->denda > 0)
                        <span class="text-sm" style="color:#ef4444;font-weight:600;">Rp {{ number_format($p->denda,0,',','.') }}</span>
                        @else<span class="text-muted">—</span>@endif
                    </td>
                    <td>
                        <div class="flex gap-1">
                            @if($p->status==='menunggu')
                            <form method="POST" action="{{ route($prefix.'.peminjaman.approve',$p->id) }}">
                                @csrf
                                <button class="btn btn-green btn-icon btn-sm" title="Setujui"><i class="bi bi-check-lg"></i></button>
                            </form>
                            <button class="btn btn-red btn-icon btn-sm" title="Tolak" onclick="openReject({{ $p->id }},'{{ $prefix }}')">
                                <i class="bi bi-x-lg"></i>
                            </button>
                            @endif
                            @if($p->status==='dipinjam')
                            <form method="POST" action="{{ route($prefix.'.peminjaman.kembalikan',$p->id) }}"
                                onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                                @csrf
                                <button class="btn btn-primary btn-sm" title="Proses Pengembalian">
                                    <i class="bi bi-arrow-return-left"></i> Kembalikan
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8">
                    <div class="empty">
                        <div class="empty-icon"><i class="bi bi-inbox"></i></div>
                        <h6>Tidak ada data</h6>
                        <p>Coba ubah filter pencarian</p>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($peminjaman->hasPages())
    <div style="padding:12px 16px;border-top:1px solid #f1f5f9;">{{ $peminjaman->links() }}</div>
    @endif
</div>

@include('components.reject-modal')
@endsection
