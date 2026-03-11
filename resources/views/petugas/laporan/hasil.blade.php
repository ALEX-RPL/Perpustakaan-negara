@extends('layouts.app')
@section('title','Hasil Laporan')
@section('page-title','Hasil Laporan')
@section('content')
@php
$prefix = auth()->user()->isAdministrator() ? 'admin' : 'petugas';
$titles = ['peminjaman'=>'Laporan Peminjaman','keterlambatan'=>'Laporan Keterlambatan & Denda','buku_populer'=>'Buku Paling Populer','anggota'=>'Statistik Anggota'];
@endphp

<div class="flex items-center justify-between mb-4 flex-wrap gap-3">
    <div>
        <h2 style="font-family:'Outfit',sans-serif;font-size:18px;font-weight:700;margin-bottom:3px;">{{ $titles[$jenis] }}</h2>
        <p class="text-sm text-muted">Periode {{ $tanggal_mulai->format('d M Y') }} — {{ $tanggal_akhir->format('d M Y') }}</p>
    </div>
    <div class="flex gap-2">
        <button onclick="window.print()" class="btn btn-ghost btn-sm"><i class="bi bi-printer"></i> Print</button>
        <a href="{{ route($prefix.'.laporan.index') }}" class="btn btn-ghost btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
</div>

@if(isset($stats))
<div class="grid gstats mb-4">
    @foreach($stats as $key => $val)
    <div class="stat-card ac-indigo">
        <div class="stat-num" style="font-size:{{ str_contains($key,'denda')?'16px':'24px' }};">
            {{ str_contains($key,'denda') ? 'Rp '.number_format($val,0,',','.') : number_format($val,0) }}
        </div>
        <div class="stat-lbl">{{ ucwords(str_replace('_',' ',$key)) }}</div>
        <div class="stat-ring"></div>
    </div>
    @endforeach
</div>
@endif

<div class="card">
    <div class="tbl-wrap">
        @if(in_array($jenis,['peminjaman','keterlambatan']))
        <table class="tbl">
            <thead>
                <tr>
                    <th>Kode</th><th>Peminjam</th><th>Buku</th><th>Pinjam</th><th>Jatuh Tempo</th>
                    @if($jenis==='keterlambatan')<th>Denda</th>@endif<th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php $sc=['menunggu'=>'b-amber','dipinjam'=>'b-blue','dikembalikan'=>'b-green','terlambat'=>'b-red','ditolak'=>'b-gray']; @endphp
                @foreach($peminjaman as $p)
                <tr>
                    <td><span class="code">{{ $p->kode_peminjaman }}</span></td>
                    <td>{{ $p->user->name??'-' }}</td>
                    <td><span class="truncate" style="max-width:160px;display:block;">{{ $p->buku->judul??'-' }}</span></td>
                    <td class="text-sm">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                    <td class="text-sm">{{ $p->tanggal_kembali_rencana->format('d M Y') }}</td>
                    @if($jenis==='keterlambatan')
                    <td style="color:#ef4444;font-weight:600;">Rp {{ number_format($p->denda,0,',','.') }}</td>
                    @endif
                    <td><span class="badge {{ $sc[$p->status]??'b-gray' }}">{{ ucfirst($p->status) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @elseif($jenis==='buku_populer')
        <table class="tbl">
            <thead><tr><th>#</th><th>Judul</th><th>Pengarang</th><th>Kategori</th><th>Dipinjam</th><th>Stok</th></tr></thead>
            <tbody>
                @foreach($buku as $i => $b)
                <tr>
                    <td>
                        <div style="width:24px;height:24px;border-radius:6px;background:{{ $i<3?'linear-gradient(135deg,#f59e0b,#d97706)':'#f1f5f9' }};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:{{ $i<3?'#fff':'#64748b' }};">
                            {{ $i+1 }}
                        </div>
                    </td>
                    <td><span class="font-sem">{{ $b->judul }}</span></td>
                    <td class="text-sm text-muted">{{ $b->pengarang }}</td>
                    <td><span class="badge b-purple">{{ $b->kategori }}</span></td>
                    <td>
                        <div class="flex items-center gap-2">
                            <div style="height:6px;background:#eef2ff;border-radius:3px;width:60px;overflow:hidden;">
                                <div style="height:100%;background:#6366f1;width:{{ min(100,($b->peminjaman_count/max(1,$buku->max('peminjaman_count')))*100) }}%;"></div>
                            </div>
                            <span class="badge b-indigo" style="background:#eef2ff;color:#6366f1;">{{ $b->peminjaman_count }} kali</span>
                        </div>
                    </td>
                    <td class="text-sm">{{ $b->stok_tersedia }}/{{ $b->stok }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @elseif($jenis==='anggota')
        <table class="tbl">
            <thead><tr><th>#</th><th>Nama</th><th>Email</th><th>Bergabung</th><th>Total Pinjam</th><th>Status</th></tr></thead>
            <tbody>
                @foreach($anggota as $i => $a)
                <tr>
                    <td class="text-muted text-sm">{{ $i+1 }}</td>
                    <td>
                        <div class="flex items-center gap-2">
                            <div class="avatar" style="width:26px;height:26px;font-size:10px;border-radius:6px;">{{ strtoupper(substr($a->name,0,2)) }}</div>
                            <span class="font-sem">{{ $a->name }}</span>
                        </div>
                    </td>
                    <td class="text-sm text-muted">{{ $a->email }}</td>
                    <td class="text-sm">{{ $a->created_at->format('d M Y') }}</td>
                    <td><span class="badge b-blue">{{ $a->peminjaman_count }} buku</span></td>
                    <td><span class="badge {{ $a->is_active?'b-green':'b-gray' }}">{{ $a->is_active?'Aktif':'Nonaktif' }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

@push('styles')
<style>
@media print {
    .sb,.topbar,.btn,.tb-right,.flex.items-center.justify-between.mb-4{display:none!important;}
    .main{margin-left:0!important;} .content{padding:0!important;}
}
</style>
@endpush
@endsection
