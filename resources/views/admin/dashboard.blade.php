@extends('layouts.app')
@section('title','Dashboard Admin')
@section('page-title','Dashboard')

@section('content')

{{-- Stat Cards --}}
<div class="grid gstats mb-4">
    <div class="stat-card ac-indigo">
        <div class="flex items-center justify-between mb-3">
            <div class="stat-icon" style="background:rgba(99,102,241,.12);color:#6366f1;">
                <i class="bi bi-book-fill"></i>
            </div>
            <span class="badge b-purple">Koleksi</span>
        </div>
        <div class="stat-num" data-value="{{ $stats['total_buku'] }}">{{ $stats['total_buku'] }}</div>
        <div class="stat-lbl">Total Buku</div>
        <div class="stat-ring"></div>
    </div>

    <div class="stat-card ac-blue">
        <div class="flex items-center justify-between mb-3">
            <div class="stat-icon" style="background:rgba(59,130,246,.12);color:#3b82f6;">
                <i class="bi bi-people-fill"></i>
            </div>
            <span class="badge b-blue">Anggota</span>
        </div>
        <div class="stat-num" data-value="{{ $stats['total_anggota'] }}">{{ $stats['total_anggota'] }}</div>
        <div class="stat-lbl">Total Anggota</div>
        <div class="stat-ring" style="background:#3b82f6;"></div>
    </div>

    <div class="stat-card ac-amber">
        <div class="flex items-center justify-between mb-3">
            <div class="stat-icon" style="background:rgba(245,158,11,.12);color:#f59e0b;">
                <i class="bi bi-arrow-left-right"></i>
            </div>
            <span class="badge b-amber">Aktif</span>
        </div>
        <div class="stat-num" data-value="{{ $stats['peminjaman_aktif'] }}">{{ $stats['peminjaman_aktif'] }}</div>
        <div class="stat-lbl">Peminjaman Aktif</div>
        <div class="stat-ring" style="background:#f59e0b;"></div>
    </div>

    <div class="stat-card ac-rose">
        <div class="flex items-center justify-between mb-3">
            <div class="stat-icon" style="background:rgba(239,68,68,.12);color:#ef4444;">
                <i class="bi bi-cash-coin"></i>
            </div>
            <span class="badge b-red">Denda</span>
        </div>
        <div class="stat-num" style="font-size:20px;">Rp {{ number_format($stats['total_denda'],0,',','.') }}</div>
        <div class="stat-lbl">Total Denda Terkumpul</div>
        <div class="stat-ring" style="background:#ef4444;"></div>
    </div>
</div>

<div class="grid g2 mb-4" style="gap:16px;">
    {{-- Antrian Persetujuan --}}
    <div class="card" style="min-width:0;">
        <div class="card-header">
            <div class="card-title">
                <div style="width:8px;height:8px;border-radius:50%;background:#f59e0b;box-shadow:0 0 0 3px rgba(245,158,11,.2);animation:pulseB 1.5s infinite;"></div>
                Menunggu Persetujuan
                @if($menungguApproval->count() > 0)
                <span class="badge b-amber">{{ $menungguApproval->count() }}</span>
                @endif
            </div>
            <a href="{{ route('admin.peminjaman.index') }}?status=menunggu" class="btn btn-ghost btn-sm">Lihat semua</a>
        </div>
        <div class="tbl-wrap">
            <table class="tbl">
                <thead>
                    <tr><th>Peminjam</th><th>Buku</th><th>Tgl</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($menungguApproval->take(5) as $p)
                    <tr>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="avatar" style="width:28px;height:28px;font-size:10px;border-radius:7px;">{{ strtoupper(substr($p->user->name,0,2)) }}</div>
                                <div class="font-sem truncate" style="max-width:110px;">{{ $p->user->name }}</div>
                            </div>
                        </td>
                        <td><span class="truncate" style="display:block;max-width:130px;font-size:12.5px;">{{ $p->buku->judul }}</span></td>
                        <td class="text-muted text-xs">{{ $p->tanggal_pinjam->format('d M') }}</td>
                        <td>
                            <div class="flex gap-1">
                                <form method="POST" action="{{ route('admin.peminjaman.approve',$p->id) }}">
                                    @csrf
                                    <button class="btn btn-green btn-icon btn-sm" title="Setujui">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                <button class="btn btn-red btn-icon btn-sm" title="Tolak"
                                    onclick="openReject({{ $p->id }},'admin')">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4">
                        <div class="empty" style="padding:24px;">
                            <div class="empty-icon" style="width:40px;height:40px;font-size:18px;margin-bottom:8px;"><i class="bi bi-inbox"></i></div>
                            <p class="text-xs">Tidak ada antrian</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Overdue --}}
    <div class="card" style="min-width:0;">
        <div class="card-header">
            <div class="card-title">
                <i class="bi bi-exclamation-triangle-fill" style="color:#ef4444;"></i>
                Terlambat Kembali
                @if($overdueList->count() > 0)
                <span class="badge b-red">{{ $overdueList->count() }}</span>
                @endif
            </div>
        </div>
        <div class="tbl-wrap">
            <table class="tbl">
                <thead><tr><th>Peminjam</th><th>Buku</th><th>Jatuh Tempo</th></tr></thead>
                <tbody>
                    @forelse($overdueList->take(5) as $p)
                    <tr>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="avatar" style="width:28px;height:28px;font-size:10px;border-radius:7px;background:linear-gradient(135deg,#ef4444,#dc2626);">{{ strtoupper(substr($p->user->name,0,2)) }}</div>
                                <span class="truncate" style="max-width:110px;font-size:12.5px;">{{ $p->user->name }}</span>
                            </div>
                        </td>
                        <td><span class="truncate" style="display:block;max-width:120px;font-size:12.5px;">{{ $p->buku->judul }}</span></td>
                        <td><span class="badge b-red">{{ $p->tanggal_kembali_rencana->format('d M Y') }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="3">
                        <div class="empty" style="padding:24px;">
                            <div class="empty-icon" style="width:40px;height:40px;font-size:18px;margin-bottom:8px;color:#10b981;background:#ecfdf5;"><i class="bi bi-check-all"></i></div>
                            <p class="text-xs">Semua tepat waktu 🎉</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Recent Activity --}}
<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="bi bi-activity" style="color:#6366f1;"></i> Aktivitas Terbaru</div>
        <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-ghost btn-sm">Lihat semua <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr><th>Kode</th><th>Peminjam</th><th>Buku</th><th>Dipinjam</th><th>Jatuh Tempo</th><th>Status</th></tr>
            </thead>
            <tbody>
                @foreach($recentPeminjaman as $p)
                <tr>
                    <td><span class="code">{{ $p->kode_peminjaman }}</span></td>
                    <td>
                        <div class="flex items-center gap-2">
                            <div class="avatar" style="width:28px;height:28px;font-size:10px;border-radius:7px;">{{ strtoupper(substr($p->user->name,0,2)) }}</div>
                            <span>{{ $p->user->name }}</span>
                        </div>
                    </td>
                    <td><span style="max-width:160px;display:block;" class="truncate">{{ $p->buku->judul }}</span></td>
                    <td class="text-muted text-sm">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                    <td class="text-sm">{{ $p->tanggal_kembali_rencana->format('d M Y') }}</td>
                    <td>
                        @php
                        $bc = ['menunggu'=>'b-amber','dipinjam'=>'b-blue','dikembalikan'=>'b-green','terlambat'=>'b-red','ditolak'=>'b-gray'];
                        @endphp
                        <span class="badge {{ $bc[$p->status] ?? 'b-gray' }}">{{ ucfirst($p->status) }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Reject Modal --}}
@include('components.reject-modal')

@push('scripts')
<script>
@keyframes pulseB{0%,100%{box-shadow:0 0 0 3px rgba(245,158,11,.2);}50%{box-shadow:0 0 0 6px rgba(245,158,11,0);}}
</script>
<style>
@keyframes pulseB{0%,100%{box-shadow:0 0 0 3px rgba(245,158,11,.2);}50%{box-shadow:0 0 0 6px rgba(245,158,11,0);}}
</style>
@endpush

@endsection
