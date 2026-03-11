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
