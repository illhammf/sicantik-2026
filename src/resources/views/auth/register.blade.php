@extends('layouts.front')

@section('title', 'Daftar - ' . ($pengaturan->nama_website ?? 'SiCantik Catering'))

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
                <h2>Daftar Akun</h2>
                <p>Daftar untuk mulai memesan catering</p>
            </div>

            <form method="POST" action="{{ route('pelanggan.register') }}" class="auth-form">
                @csrf

                @if ($errors->any())
                    <div class="auth-alert error">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="auth-field">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" placeholder="Nama lengkap" required>
                </div>

                <div class="auth-field">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="email@contoh.com" required>
                </div>

                <div class="auth-field">
                    <label for="no_hp">Nomor HP</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" placeholder="0812-3456-7890" required>
                </div>

                <div class="auth-field">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="2" placeholder="Alamat lengkap" required>{{ old('alamat') }}</textarea>
                </div>

                <div class="auth-field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Minimal 6 karakter" required>
                </div>

                <div class="auth-field">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password" required>
                </div>

                <button type="submit" class="auth-submit">Daftar</button>
            </form>

            <div class="auth-footer">
                <p>Sudah punya akun? <a href="{{ route('pelanggan.login') }}">Masuk</a></p>
                <a href="/">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection
