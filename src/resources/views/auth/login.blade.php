@extends('layouts.front')

@section('title', 'Masuk - ' . ($pengaturan->nama_website ?? 'SiCantik Catering'))

@section('content')
<div class="auth-section">
    <div class="container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="/" class="auth-logo">
                    @if (!empty($pengaturan?->logo_url))
                        <img src="{{ $pengaturan->logo_url }}" alt="{{ $pengaturan->nama_website ?? 'Logo' }}" style="height:44px;">
                    @else
                        Si<span>Cantik</span>
                    @endif
                </a>
                <h2>Masuk</h2>
                <p>Masuk ke akun kamu untuk memesan catering</p>
            </div>

            <form method="POST" action="{{ route('pelanggan.login') }}" class="auth-form">
                @csrf

                @if ($errors->any())
                    <div class="auth-alert error">
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <div class="auth-field">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="email@contoh.com" required autofocus>
                </div>

                <div class="auth-field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan password" required>
                </div>

                <div class="auth-field checkbox">
                    <label>
                        <input type="checkbox" name="remember">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="auth-submit">Masuk</button>
            </form>

            <div class="auth-footer">
                <p>Belum punya akun? <a href="{{ route('pelanggan.register') }}">Daftar</a></p>
                <a href="/">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection
