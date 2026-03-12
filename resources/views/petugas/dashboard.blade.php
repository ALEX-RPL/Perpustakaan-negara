@extends('layouts.app')
@section('title','Dashboard Petugas')
@section('page-title','Dashboard')
@section('content')

<div class="grid gstats mb-4">
    <div class="stat-card ac-amber">
        <div class="flex items-center justify-between mb-3">
            <div class="stat-icon" style="background:rgba(245,158,11,.12);color:#f59e0b;"><i class="bi bi-hourglass-split"></i></div>
            <span class="badge b-amber">Menunggu</span>
        </div>
        <div class="stat-num" data-value="{{ $stats['menunggu'] }}">{{ $stats['menunggu'] }}</div>
        <div class="stat-lbl">Perlu Persetujuan</div>
        <div class="stat-ring" style="background:#f59e0b;"></div>
    </div>
    <div class="stat-card ac-blue">
        <div class="flex items-center justify-between mb-3">
            <div class="stat-icon" style="background:rgba(59,130,246,.12);color:#3b82f6;"><i class="bi bi-book-fill"></i></div>
            <span class="badge b-blue">Aktif</span>
        </div>
        <div class="stat-num" data-value="{{ $stats['dipinjam'] }}">{{ $stats['dipinjam'] }}</div>
        <div class="stat-lbl">Sedang Dipinjam</div>
        <div class="stat-ring" style="background:#3b82f6;"></div>
    </div>
    <div class="stat-card ac-rose">
        <div class="flex items-center justify-between mb-3">
            <div class="stat-icon" style="background:rgba(239,68,68,.12);color:#ef4444;"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <span class="badge b-red">Alert</span>
        </div>
        <div class="stat-num" data-value="{{ $stats['overdue'] }}">{{ $stats['overdue'] }}</div>
        <div class="stat-lbl">Terlambat</div>
        <div class="stat-ring" style="background:#ef4444;"></div>
    </div>
    <div class="stat-card ac-emerald">
        <div class="flex items-center justify-between mb-3">
            <div class="stat-icon" style="background:rgba(16,185,129,.12);color:#10b981;"><i class="bi bi-calendar-check"></i></div>
            <span class="badge b-green">Hari Ini</span>
        </div>
        <div class="stat-num" data-value="{{ $stats['hari_ini'] }}">{{ $stats['hari_ini'] }}</div>
        <div class="stat-lbl">Transaksi Hari Ini</div>
        <div class="stat-ring" style="background:#10b981;"></div>
    </div>
</div>

<div class="grid g2" style="gap:16px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div style="width:8px;height:8px;border-radius:50%;background:#f59e0b;animation:pulseW 1.5s infinite;"></div>
                Antrian Persetujuan
                @if($menungguApproval->count()>0)<span class="badge b-amber">{{ $menungguApproval->count() }}</span>@endif
            </div>
            <a href="{{ route('petugas.peminjaman.index') }}?status=menunggu" class="btn btn-ghost btn-sm">Semua</a>
        </div>
        <div class="tbl-wrap">
            <table class="tbl">
                <thead><tr><th>Peminjam</th><th>Buku</th><th>Tgl</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($menungguApproval->take(6) as $p)
                    <tr>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="avatar" style="width:26px;height:26px;font-size:10px;border-radius:6px;">{{ strtoupper(substr($p->user->name,0,2)) }}</div>
                                <span class="font-sem" style="font-size:12.5px;">{{ Str::limit($p->user->name,18) }}</span>
                            </div>
                        </td>
                        <td class="text-sm truncate" style="max-width:130px;">{{ Str::limit($p->buku->judul,22) }}</td>
                        <td class="text-xs text-muted">{{ $p->tanggal_pinjam->format('d M') }}</td>
                        <td>
                            <div class="flex gap-1">
                                <form method="POST" action="{{ route('petugas.peminjaman.approve',$p->id) }}">
                                    @csrf <button class="btn btn-green btn-icon btn-sm" title="Setujui"><i class="bi bi-check-lg"></i></button>
                                </form>
                                <button class="btn btn-red btn-icon btn-sm" onclick="openReject({{ $p->id }},'petugas')"><i class="bi bi-x-lg"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4">
                        <div class="empty" style="padding:24px;">
                            <div class="empty-icon" style="width:40px;height:40px;font-size:18px;margin-bottom:8px;background:#ecfdf5;color:#10b981;"><i class="bi bi-check-all"></i></div>
                            <p class="text-xs">Tidak ada antrian</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="bi bi-exclamation-triangle-fill" style="color:#ef4444;"></i>
                Keterlambatan
                @if($overdueList->count()>0)<span class="badge b-red">{{ $overdueList->count() }}</span>@endif
            </div>
            <a href="{{ route('petugas.peminjaman.index') }}?status=dipinjam" class="btn btn-ghost btn-sm">Proses</a>
        </div>
        <div class="tbl-wrap">
            <table class="tbl">
                <thead><tr><th>Peminjam</th><th>Buku</th><th>Jatuh Tempo</th></tr></thead>
                <tbody>
                    @forelse($overdueList->take(6) as $p)
                    <tr>
                        <td class="text-sm font-sem">{{ Str::limit($p->user->name,18) }}</td>
                        <td class="text-sm truncate" style="max-width:130px;">{{ Str::limit($p->buku->judul,20) }}</td>
                        <td><span class="badge b-red">{{ $p->tanggal_kembali_rencana->format('d M Y') }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="3">
                        <div class="empty" style="padding:24px;">
                            <div class="empty-icon" style="width:40px;height:40px;font-size:18px;margin-bottom:8px;background:#ecfdf5;color:#10b981;"><i class="bi bi-trophy-fill"></i></div>
                            <p class="text-xs">Semua tepat waktu!</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('components.reject-modal')
<style>@keyframes pulseW{0%,100%{box-shadow:0 0 0 3px rgba(245,158,11,.2);}50%{box-shadow:0 0 0 6px rgba(245,158,11,0);}}</style>
@endsection
