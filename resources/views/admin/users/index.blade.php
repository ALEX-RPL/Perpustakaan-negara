@extends('layouts.app')
@section('title','Manajemen User')
@section('page-title','Manajemen User')
@section('content')

<div class="flex items-center justify-between mb-4 flex-wrap gap-3">
    <form method="GET" class="flex gap-2 flex-wrap items-center">
        <div class="search" style="width:280px;">
            <i class="bi bi-search"></i>
            <input type="text" name="search" placeholder="Cari nama atau email..." value="{{ request('search') }}">
        </div>
        <select name="role" class="select" style="width:auto;padding:8px 12px;">
            <option value="">Semua Role</option>
            <option value="administrator" {{ request('role')==='administrator'?'selected':'' }}>Administrator</option>
            <option value="petugas" {{ request('role')==='petugas'?'selected':'' }}>Petugas</option>
            <option value="peminjam" {{ request('role')==='peminjam'?'selected':'' }}>Peminjam</option>
        </select>
        <button type="submit" class="btn btn-ghost"><i class="bi bi-funnel"></i></button>
        @if(request()->hasAny(['search','role']))
        <a href="{{ route('admin.users.index') }}" class="btn btn-ghost"><i class="bi bi-x"></i></a>
        @endif
    </form>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Tambah User</a>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="bi bi-people-fill" style="color:#6366f1;"></i> Daftar Pengguna</div>
        <span class="text-muted text-sm">{{ $users->total() }} pengguna</span>
    </div>
    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr><th>Pengguna</th><th>Role</th><th>Telepon</th><th>Status</th><th>Bergabung</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                @php $rc=['administrator'=>['b-red','rt-admin'],'petugas'=>['b-amber','rt-petugas'],'peminjam'=>['b-blue','rt-peminjam']]; @endphp
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="avatar">{{ strtoupper(substr($u->name,0,2)) }}</div>
                            <div>
                                <div class="font-sem">{{ $u->name }}</div>
                                <div class="text-xs text-muted">{{ $u->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="role-tag {{ $rc[$u->role][1]??'' }}">{{ ucfirst($u->role) }}</span>
                    </td>
                    <td class="text-sm text-muted">{{ $u->no_telepon??'—' }}</td>
                    <td>
                        <span class="badge {{ $u->is_active?'b-green':'b-gray' }}">
                            {{ $u->is_active?'Aktif':'Nonaktif' }}
                        </span>
                    </td>
                    <td class="text-sm text-muted">{{ $u->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="flex gap-1">
                            <a href="{{ route('admin.users.edit',$u->id) }}" class="btn btn-ghost btn-icon btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                            @if($u->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy',$u->id) }}" onsubmit="return confirm('Hapus user ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-red btn-icon btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6">
                    <div class="empty">
                        <div class="empty-icon"><i class="bi bi-people"></i></div>
                        <h6>Tidak ada pengguna</h6>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div style="padding:12px 16px;border-top:1px solid #f1f5f9;">{{ $users->links() }}</div>
    @endif
</div>
@endsection
