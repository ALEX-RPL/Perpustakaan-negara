@extends('layouts.app')
@section('title','Koleksi Buku')
@section('page-title','Koleksi Buku')
@section('content')
@php $prefix = auth()->user()->isAdministrator() ? 'admin' : 'petugas'; @endphp

<div class="flex items-center justify-between mb-4 flex-wrap gap-3" style="flex-wrap:wrap;">
    <form method="GET" class="flex gap-2 items-center flex-wrap" style="flex-wrap:wrap;">
        <div class="search" style="width:min(300px,100%)">
            <i class="bi bi-search"></i>
            <input type="text" name="search" placeholder="Cari judul, pengarang, kode..." value="{{ request('search') }}">
        </div>
        <select name="kategori" class="select" style="width:auto;padding:8px 12px;">
            <option value="">Semua Kategori</option>
            @foreach($kategori as $k)
                <option value="{{ $k }}" {{ request('kategori')===$k?'selected':'' }}>{{ $k }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-ghost"><i class="bi bi-funnel"></i> Filter</button>
        @if(request()->hasAny(['search','kategori']))
        <a href="{{ route($prefix.'.buku.index') }}" class="btn btn-ghost"><i class="bi bi-x"></i></a>
        @endif
    </form>
    <a href="{{ route($prefix.'.buku.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Buku
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="bi bi-book" style="color:#6366f1;"></i> Daftar Koleksi</div>
        <span class="text-muted text-sm">{{ $buku->total() }} buku ditemukan</span>
    </div>
    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Buku</th><th>Pengarang</th><th>Kategori</th>
                    <th>Stok</th><th>Tersedia</th><th>Status</th><th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($buku as $b)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div style="width:38px;height:50px;border-radius:6px;background:linear-gradient(135deg,{{ ['#eef2ff','#eff6ff','#fdf4ff','#ecfdf5','#fffbeb'][($b->id-1)%5] }},{{ ['#e0e7ff','#dbeafe','#f3e8ff','#d1fae5','#fde68a'][($b->id-1)%5] }});display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-book-fill" style="font-size:14px;color:{{ ['#6366f1','#3b82f6','#8b5cf6','#10b981','#f59e0b'][($b->id-1)%5] }};"></i>
                            </div>
                            <div>
                                <div class="font-sem truncate" style="max-width:200px;">{{ $b->judul }}</div>
                                <div class="text-xs text-muted">{{ $b->kode_buku }} · {{ $b->penerbit }}, {{ $b->tahun_terbit }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-sm">{{ $b->pengarang }}</td>
                    <td><span class="badge b-purple">{{ $b->kategori }}</span></td>
                    <td class="font-sem">{{ $b->stok }}</td>
                    <td>
                        <span class="badge {{ $b->stok_tersedia > 0 ? 'b-green' : 'b-red' }}">
                            {{ $b->stok_tersedia }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $b->is_active ? 'b-green' : 'b-gray' }}">
                            {{ $b->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex gap-1">
                            <a href="{{ route($prefix.'.buku.edit',$b->id) }}"
                               class="btn btn-ghost btn-icon btn-sm" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if(auth()->user()->isAdministrator())
                            <form method="POST" action="{{ route('admin.buku.destroy',$b->id) }}"
                                onsubmit="return confirm('Hapus buku ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-red btn-icon btn-sm" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7">
                    <div class="empty">
                        <div class="empty-icon"><i class="bi bi-book"></i></div>
                        <h6>Belum ada buku</h6>
                        <p>Tambahkan koleksi buku pertama Anda</p>
                        <a href="{{ route($prefix.'.buku.create') }}" class="btn btn-primary" style="margin-top:12px;">
                            <i class="bi bi-plus-lg"></i> Tambah Buku
                        </a>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($buku->hasPages())
    <div style="padding:12px 16px;border-top:1px solid #f1f5f9;">
        {{ $buku->links() }}
    </div>
    @endif
</div>
@endsection
