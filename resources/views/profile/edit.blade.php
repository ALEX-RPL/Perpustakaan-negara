@extends('layouts.app')
@section('page-title', 'Profile')

@section('content')
<div class="grid" style="grid-template-columns: 280px 1fr; gap: 20px;">
    <!-- Profile Card -->
    <div class="card" style="height: fit-content;">
        <div class="card-body" style="text-align: center; padding: 30px 20px;">
            <div style="width: 90px; height: 90px; border-radius: 50%; background: linear-gradient(135deg, var(--brand-400), var(--brand-600)); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; color: #fff; font-size: 28px; font-weight: 700; font-family: 'Outfit', sans-serif;">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <h3 style="font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 700; margin-bottom: 4px;">{{ Auth::user()->name }}</h3>
            <p style="color: var(--text-3); font-size: 13px; margin-bottom: 12px;">{{ Auth::user()->email }}</p>
            <span class="role-tag rt-{{ Auth::user()->role }}" style="display: inline-block;">{{ ucfirst(Auth::user()->role) }}</span>
        </div>
    </div>

    <!-- Forms -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        <!-- Update Profile -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="bi bi-person"></i> Informasi Profile</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')
                    
                    <div class="fg">
                        <label class="lbl">Nama Lengkap</label>
                        <input type="text" name="name" class="input" value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name') <p class="err">{{ $message }}</p> @enderror
                    </div>

                    <div class="fg">
                        <label class="lbl">Email</label>
                        <input type="email" name="email" class="input" value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email') <p class="err">{{ $message }}</p> @enderror
                    </div>

                    <div class="fg">
                        <label class="lbl">No. Telepon</label>
                        <input type="text" name="no_telepon" class="input" value="{{ old('no_telepon', Auth::user()->no_telepon) }}">
                        @error('no_telepon') <p class="err">{{ $message }}</p> @enderror
                    </div>

                    <div class="fg">
                        <label class="lbl">Alamat</label>
                        <textarea name="alamat" class="textarea" rows="3">{{ old('alamat', Auth::user()->alamat) }}</textarea>
                        @error('alamat') <p class="err">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Simpan Perubahan</button>
                </form>
            </div>
        </div>

        <!-- Update Password -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="bi bi-key"></i> Ubah Password</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="fg">
                        <label class="lbl">Password Saat Ini</label>
                        <input type="password" name="current_password" class="input" required>
                        @error('current_password') <p class="err">{{ $message }}</p> @enderror
                    </div>

                    <div class="fg">
                        <label class="lbl">Password Baru</label>
                        <input type="password" name="password" class="input" required>
                        @error('password') <p class="err">{{ $message }}</p> @enderror
                    </div>

                    <div class="fg">
                        <label class="lbl">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="input" required>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Update Password</button>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="card" style="border-color: var(--red-b);">
            <div class="card-header" style="border-color: var(--red-b);">
                <h4 class="card-title" style="color: var(--red);"><i class="bi bi-exclamation-triangle"></i> Zona Berbahaya</h4>
            </div>
            <div class="card-body">
                <p style="margin-bottom: 16px; color: var(--text-2);">Jika Anda menghapus akun ini, semua data akan hilang secara permanen.</p>
                <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('delete')
                    
                    <div class="fg">
                        <label class="lbl">Konfirmasi Password</label>
                        <input type="password" name="password" class="input" placeholder="Masukkan password untuk konfirmasi" required>
                        @error('password', 'userDeletion') <p class="err">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn btn-red"><i class="bi bi-trash"></i> Hapus Akun Saya</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

