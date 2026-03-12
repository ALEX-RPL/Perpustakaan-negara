@extends('layouts.app')
@section('title', isset($user) ? 'Edit User' : 'Tambah User')
@section('page-title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna Baru')
@section('content')
@php
$action = isset($user) ? route('admin.users.update',$user->id) : route('admin.users.store');
@endphp

<div style="max-width:640px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="bi bi-person-{{ isset($user)?'gear':'plus-fill' }}" style="color:#6366f1;"></i>
                {{ isset($user) ? 'Edit Data Pengguna' : 'Tambah Pengguna Baru' }}
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ $action }}">
                @csrf @if(isset($user)) @method('PUT') @endif

                <div class="grid g2" style="gap:14px;margin-bottom:14px;">
                    <div class="fg">
                        <label class="lbl">Nama Lengkap <span class="req">*</span></label>
                        <input type="text" name="name" class="input {{ $errors->has('name')?'invalid':'' }}"
                            value="{{ old('name',$user->name??'') }}" required>
                        @error('name')<div class="err">{{ $message }}</div>@enderror
                    </div>
                    <div class="fg">
                        <label class="lbl">Email <span class="req">*</span></label>
                        <input type="email" name="email" class="input {{ $errors->has('email')?'invalid':'' }}"
                            value="{{ old('email',$user->email??'') }}" required>
                        @error('email')<div class="err">{{ $message }}</div>@enderror
                    </div>
                    <div class="fg">
                        <label class="lbl">Password {{ isset($user)?'(kosongkan jika tidak diubah)':'' }} <span class="req">{{ isset($user)?'':'*' }}</span></label>
                        <input type="password" name="password" class="input" {{ isset($user)?'':'required' }} minlength="8">
                        @error('password')<div class="err">{{ $message }}</div>@enderror
                    </div>
                    <div class="fg">
                        <label class="lbl">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="input">
                    </div>
                    <div class="fg">
                        <label class="lbl">Role <span class="req">*</span></label>
                        <select name="role" class="select" required>
                            <option value="peminjam" {{ old('role',$user->role??'peminjam')==='peminjam'?'selected':'' }}>Peminjam</option>
                            <option value="petugas" {{ old('role',$user->role??'')==='petugas'?'selected':'' }}>Petugas</option>
                            <option value="administrator" {{ old('role',$user->role??'')==='administrator'?'selected':'' }}>Administrator</option>
                        </select>
                    </div>
                    <div class="fg">
                        <label class="lbl">No. Telepon</label>
                        <input type="text" name="no_telepon" class="input" value="{{ old('no_telepon',$user->no_telepon??'') }}" placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="fg" style="grid-column:1/-1;">
                        <label class="lbl">Alamat</label>
                        <textarea name="alamat" class="textarea" rows="2">{{ old('alamat',$user->alamat??'') }}</textarea>
                    </div>
                    @if(isset($user))
                    <div class="fg" style="grid-column:1/-1;">
                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                            <input type="checkbox" name="is_active" value="1" {{ ($user->is_active??true)?'checked':'' }}
                                style="width:16px;height:16px;accent-color:#6366f1;">
                            <span class="lbl" style="margin-bottom:0;">Akun Aktif</span>
                        </label>
                    </div>
                    @endif
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> {{ isset($user)?'Update':'Simpan' }}</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
