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
