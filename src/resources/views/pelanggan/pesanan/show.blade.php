@extends('layouts.pelanggan')

@section('title', 'Pesanan #' . $pesanan->id)
@section('page-title', 'Pesanan #' . $pesanan->id)

@section('content')
<div class="pel-grid-2">
    <div class="pel-card">
        <div class="pel-card-header">
            <h3>Detail Pesanan</h3>
            <span class="pel-status {{ $pesanan->status }}">{{ $pesanan->status }}</span>
        </div>
        <div class="pel-card-body pel-detail-list">
            <div class="pel-detail-item">
                <span>Tanggal Acara</span>
                <strong>{{ $pesanan->tanggal_acara?->format('d M Y') ?? '-' }}</strong>
            </div>
            <div class="pel-detail-item">
                <span>Tanggal Pesan</span>
                <strong>{{ $pesanan->created_at->format('d M Y H:i') }}</strong>
            </div>
            <div class="pel-detail-item">
                <span>Alamat Pengiriman</span>
                <strong>{{ $pesanan->alamat_pengiriman ?? '-' }}</strong>
            </div>
            @if ($pesanan->catatan)
            <div class="pel-detail-item">
                <span>Catatan</span>
                <strong>{{ $pesanan->catatan }}</strong>
            </div>
            @endif
            <div class="pel-detail-item">
                <span>Total Harga</span>
                <strong class="pel-total">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>
            </div>
        </div>
    </div>

    <div class="pel-card">
        <div class="pel-card-header">
            <h3>Status Pesanan</h3>
        </div>
        <div class="pel-card-body">
            <div class="pel-timeline">
                <div class="pel-timeline-item {{ in_array($pesanan->status, ['Baru', 'Diproses', 'Selesai']) ? 'done' : '' }}">
                    <div class="pel-timeline-dot"></div>
                    <div>
                        <strong>Pesanan Dibuat</strong>
                        <p>{{ $pesanan->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                <div class="pel-timeline-item {{ in_array($pesanan->status, ['Diproses', 'Selesai']) ? 'done' : '' }}">
                    <div class="pel-timeline-dot"></div>
                    <div>
                        <strong>Diproses Admin</strong>
                        <p>Admin sedang memproses pesanan kamu</p>
                    </div>
                </div>
                <div class="pel-timeline-item {{ $pesanan->status == 'Selesai' ? 'done' : '' }}">
                    <div class="pel-timeline-dot"></div>
                    <div>
                        <strong>Selesai</strong>
                        <p>Pesanan telah selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="pel-card" style="margin-top:20px;">
    <div class="pel-card-header">
        <h3>Menu Dipesan</h3>
    </div>
    <div class="pel-card-body">
        <div class="pel-order-items">
            @foreach ($pesanan->detailPesanans as $detail)
                <div class="pel-order-item">
                    <div class="pel-order-item-img">
                        @if ($detail->menu?->gambar)
                            <img src="{{ asset('storage/' . $detail->menu->gambar) }}" alt="{{ $detail->menu->nama_menu }}">
                        @else
                            🍛
                        @endif
                    </div>
                    <div class="pel-order-item-info">
                        <h4>{{ $detail->menu->nama_menu ?? 'Menu' }}</h4>
                        <p>Rp{{ number_format($detail->harga, 0, ',', '.') }} × {{ $detail->jumlah }}</p>
                    </div>
                    <strong>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</strong>
                </div>
            @endforeach
        </div>
        <div class="pel-order-total">
            <span>Total</span>
            <strong>Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>
        </div>
    </div>
</div>

<div class="pel-actions-bottom">
    <a href="{{ route('pelanggan.pesanan') }}" class="btn-outline">Kembali</a>
    @if (!empty($pengaturan?->whatsapp))
        <a href="{{ $pengaturan->whatsapp }}" target="_blank" class="btn-primary">Hubungi Admin</a>
    @endif
</div>
@endsection
