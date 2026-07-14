@extends('layouts.pelanggan')

@section('title', 'Profil')
@section('page-title', 'Profil Saya')

@section('content')
<div class="pel-grid-2">
    <div class="pel-card">
        <div class="pel-card-header">
            <h3>Data Diri</h3>
        </div>
        <div class="pel-card-body">
            <form method="POST" action="{{ route('pelanggan.profil.update') }}" class="pel-form">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="auth-alert error">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if (session('profile_updated'))
                    <div class="pel-alert success">Profil berhasil diperbarui!</div>
                @endif

                <div class="pel-form-field">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $pelanggan->nama) }}" required>
                </div>
                <div class="pel-form-field">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $pelanggan->email) }}" required>
                </div>
                <div class="pel-form-field">
                    <label for="no_hp">Nomor HP</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $pelanggan->no_hp) }}" required>
                </div>
                <div class="pel-form-field">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3" required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
                </div>

                <button type="submit" class="auth-submit">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <div class="pel-card">
        <div class="pel-card-header">
            <h3>Ganti Password</h3>
        </div>
        <div class="pel-card-body">
            <form method="POST" action="{{ route('pelanggan.password.update') }}" class="pel-form">
                @csrf
                @method('PUT')

                @if (session('password_updated'))
                    <div class="pel-alert success">Password berhasil diganti!</div>
                @endif

                <div class="pel-form-field">
                    <label for="current_password">Password Saat Ini</label>
                    <input type="password" name="current_password" id="current_password" required>
                </div>
                <div class="pel-form-field">
                    <label for="new_password">Password Baru</label>
                    <input type="password" name="new_password" id="new_password" minlength="6" required>
                </div>
                <div class="pel-form-field">
                    <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" required>
                </div>

                <button type="submit" class="auth-submit">Ganti Password</button>
            </form>
        </div>
    </div>
</div>

<div class="pel-card" style="margin-top:20px;">
    <div class="pel-card-header">
        <h3>Akun Saya</h3>
    </div>
    <div class="pel-card-body">
        <div class="pel-detail-list">
            <div class="pel-detail-item">
                <span>Bergabung Sejak</span>
                <strong>{{ $pelanggan->created_at->format('d M Y') }}</strong>
            </div>
            <div class="pel-detail-item">
                <span>Total Pesanan</span>
                <strong>{{ $totalPesanan }}</strong>
            </div>
            <div class="pel-detail-item">
                <span>Total Ulasan</span>
                <strong>{{ $totalUlasan }}</strong>
            </div>
        </div>
    </div>
</div>
@endsection
