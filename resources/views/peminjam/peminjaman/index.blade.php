@extends('layouts.app')
@section('title','Peminjaman Saya')
@section('page-title','Peminjaman Saya')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="bi bi-clock-history" style="color:#6366f1;"></i> Riwayat Peminjaman</div>
        <a href="{{ route('peminjam.katalog') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Pinjam Buku</a>
    </div>
    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr><th>Kode</th><th>Buku</th><th>Dipinjam</th><th>Jatuh Tempo</th><th>Dikembalikan</th><th>Status</th><th>Denda</th></tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $p)
                @php $sc=['menunggu'=>'b-amber','dipinjam'=>'b-blue','dikembalikan'=>'b-green','terlambat'=>'b-red','ditolak'=>'b-gray']; @endphp
                <tr>
                    <td><span class="code">{{ $p->kode_peminjaman }}</span></td>
                    <td>
                        <div class="font-sem truncate" style="max-width:180px;">{{ $p->buku->judul }}</div>
                        <div class="text-xs text-muted">{{ $p->buku->pengarang }}</div>
                    </td>
                    <td class="text-sm text-muted">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                    <td>
                        <span class="text-sm">{{ $p->tanggal_kembali_rencana->format('d M Y') }}</span>
                        @if($p->isOverdue())<div><span class="badge b-red" style="font-size:9px;">Terlambat!</span></div>@endif
                    </td>
                    <td class="text-sm">{{ $p->tanggal_kembali_aktual ? $p->tanggal_kembali_aktual->format('d M Y') : '—' }}</td>
                    <td><span class="badge {{ $sc[$p->status]??'b-gray' }}">{{ ucfirst($p->status) }}</span></td>
                    <td>
                        @if($p->denda>0)<span style="color:#ef4444;font-weight:600;font-size:13px;">Rp {{ number_format($p->denda,0,',','.') }}</span>
                        @else<span class="text-muted">—</span>@endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7">
                    <div class="empty">
                        <div class="empty-icon"><i class="bi bi-bookmark"></i></div>
                        <h6>Belum ada riwayat</h6>
                        <p>Mulai pinjam buku dari katalog kami</p>
                        <a href="{{ route('peminjam.katalog') }}" class="btn btn-primary" style="margin-top:12px;">
                            <i class="bi bi-collection"></i> Lihat Katalog
                        </a>
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
@endsection
