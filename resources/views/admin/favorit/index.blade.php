@extends('layouts.app')
@section('title', 'Data Buku Favorit')
@section('page-title', 'Data Buku Favorit')

@section('content')
<div class="flex items-center justify-between mb-4 flex-wrap gap-3">
    <form method="GET" class="flex gap-2 flex-wrap items-center">
        <div class="search" style="width:300px;">
            <i class="bi bi-search"></i>
            <input type="text" name="search" placeholder="Cari judul buku..." value="{{ $search }}">
        </div>
        <button type="submit" class="btn btn-ghost"><i class="bi bi-funnel"></i></button>
        @if($search)
        <a href="{{ route('admin.favorit.index') }}" class="btn btn-ghost"><i class="bi bi-x"></i> Reset</a>
        @endif
    </form>
    <span class="text-muted text-sm">{{ $users->total() }} user</span>
</div>

<div class="card">
    <div class="card-body" style="padding:0;overflow:hidden;">
        <div class="tbl-wrap">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Buku Favorit</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $index }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="avatar" style="width:32px;height:32px;font-size:10px;">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <span class="font-sem">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td><span class="role-tag rt-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                        <td>
                            @forelse($user->bukuFavorit->take(3) as $buku)
                            <div class="text-sm truncate" style="max-width:200px;">{{ $buku->judul }}</div>
                            @empty
                            <span class="text-muted">-</span>
                            @endforelse
                            @if($user->bukuFavorit->count() > 3)
                            <div class="text-xs text-muted">+{{ $user->bukuFavorit->count() - 3 }} lagi</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge b-purple">{{ $user->bukuFavorit->count() }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;">
                            <div class="empty">
                                <div class="empty-icon"><i class="bi bi-heart"></i></div>
                                <h6>Belum Ada Data Favorit</h6>
                                <p>Belum ada user yang menambahkan buku favorit</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($users->hasPages())
<div class="mt-4 flex justify-end">{{ $users->links() }}</div>
@endif
@endsection

