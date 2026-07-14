@extends('layouts.pelanggan')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="pel-welcome">
    <h2>Halo, {{ Auth::guard('pelanggan')->user()->nama }}! 👋</h2>
    <p>Selamat datang di dashboard kamu. Kelola pesanan catering dengan mudah.</p>
</div>

<div class="pel-stats">
    <div class="pel-stat-card">
        <div class="pel-stat-icon green">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <path d="M16 10a4 4 0 0 1-8 0"></path>
            </svg>
        </div>
        <div>
            <h3>{{ $totalPesanan }}</h3>
            <p>Total Pesanan</p>
        </div>
    </div>
    <div class="pel-stat-card">
        <div class="pel-stat-icon yellow">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
        </div>
        <div>
            <h3>{{ $pesananDiproses }}</h3>
            <p>Sedang Diproses</p>
        </div>
    </div>
    <div class="pel-stat-card">
        <div class="pel-stat-icon blue">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        </div>
        <div>
            <h3>{{ $pesananSelesai }}</h3>
            <p>Selesai</p>
        </div>
    </div>
    <div class="pel-stat-card">
        <div class="pel-stat-icon purple">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
            </svg>
        </div>
        <div>
            <h3>{{ number_format($ratingRata, 1) }}</h3>
            <p>Rating Kamu</p>
        </div>
    </div>
</div>

<div class="pel-grid-2">
    <div class="pel-card">
        <div class="pel-card-header">
            <h3>Pesanan Terbaru</h3>
            <a href="{{ route('pelanggan.pesanan') }}" class="pel-card-link">Lihat Semua</a>
        </div>
        <div class="pel-card-body">
            @forelse ($pesananTerbaru as $pesanan)
                <a href="{{ route('pelanggan.pesanan.show', $pesanan->id) }}" class="pel-order-row">
                    <div class="pel-order-row-info">
                        <h4>Pesanan #{{ $pesanan->id }}</h4>
                        <p>{{ $pesanan->tanggal_acara?->format('d M Y') ?? '-' }} · {{ $pesanan->detailPesanans->count() }} menu</p>
                    </div>
                    <div class="pel-order-row-right">
                        <span class="pel-status {{ $pesanan->status }}">{{ $pesanan->status }}</span>
                        <strong>Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>
                    </div>
                </a>
            @empty
                <div class="pel-empty">
                    <p>Belum ada pesanan.</p>
                    <a href="/#menu" class="btn-primary" style="margin-top:12px;">Pesan Sekarang</a>
                </div>
            @endforelse
        </div>
    </div>

    <div class="pel-card">
        <div class="pel-card-header">
            <h3>Aksi Cepat</h3>
        </div>
        <div class="pel-card-body">
            <div class="pel-actions">
                <a href="/#menu" class="pel-action-btn">
                    <span class="pel-action-icon green">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </span>
                    <span>Pesan Menu Baru</span>
                </a>
                <a href="{{ route('pelanggan.pesanan') }}" class="pel-action-btn">
                    <span class="pel-action-icon yellow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                    </span>
                    <span>Cek Pesanan</span>
                </a>
                <a href="{{ route('pelanggan.profil') }}" class="pel-action-btn">
                    <span class="pel-action-icon blue">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </span>
                    <span>Edit Profil</span>
                </a>
                <a href="/" class="pel-action-btn">
                    <span class="pel-action-icon purple">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span>Beranda</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
