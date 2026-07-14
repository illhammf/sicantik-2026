@extends('layouts.pelanggan')

@section('title', 'Pesanan Saya')
@section('page-title', 'Pesanan Saya')

@section('content')
<div class="pel-card">
    <div class="pel-card-header">
        <h3>Semua Pesanan</h3>
        <div class="pel-filter-status">
            <a href="{{ route('pelanggan.pesanan') }}" class="pel-filter-btn {{ !request('status') ? 'active' : '' }}">Semua</a>
            <a href="{{ route('pelanggan.pesanan', ['status' => 'Baru']) }}" class="pel-filter-btn {{ request('status') == 'Baru' ? 'active' : '' }}">Baru</a>
            <a href="{{ route('pelanggan.pesanan', ['status' => 'Diproses']) }}" class="pel-filter-btn {{ request('status') == 'Diproses' ? 'active' : '' }}">Diproses</a>
            <a href="{{ route('pelanggan.pesanan', ['status' => 'Selesai']) }}" class="pel-filter-btn {{ request('status') == 'Selesai' ? 'active' : '' }}">Selesai</a>
        </div>
    </div>
    <div class="pel-card-body">
        @forelse ($pesanans as $pesanan)
            <a href="{{ route('pelanggan.pesanan.show', $pesanan->id) }}" class="pel-order-row">
                <div class="pel-order-row-info">
                    <h4>Pesanan #{{ $pesanan->id }}</h4>
                    <p>
                        {{ $pesanan->tanggal_acara?->format('d M Y') ?? '-' }}
                        ·
                        {{ $pesanan->detailPesanans->count() }} menu
                        ·
                        {{ $pesanan->created_at->format('d M Y H:i') }}
                    </p>
                </div>
                <div class="pel-order-row-right">
                    <span class="pel-status {{ $pesanan->status == 'Baru' ? 'Baru' : ($pesanan->status == 'Diproses' ? 'Diproses' : ($pesanan->status == 'Selesai' ? 'Selesai' : 'Dibatalkan')) }}">
                        {{ $pesanan->status }}
                    </span>
                    <strong>Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>
                </div>
            </a>
        @empty
            <div class="pel-empty">
                <p>Belum ada pesanan.</p>
                <a href="/#menu" class="btn-primary" style="margin-top:12px;display:inline-flex;">Pesan Sekarang</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
