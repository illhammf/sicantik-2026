<section id="pesanan" class="section order-section">
    <div class="container">
        <div class="section-title">
            <span>Data Pesanan</span>
            <h2>Pesanan Terbaru</h2>
            <p>Pesanan yang dibuat admin akan tampil sebagai informasi terbaru di website.</p>
        </div>

        <div class="order-grid">
            @forelse (($pesanans ?? collect())->take(6) as $pesanan)
                <div class="order-card">
                    <div class="order-head">
                        <h3>{{ $pesanan->pelanggan->nama ?? 'Pelanggan' }}</h3>
                        <span>{{ $pesanan->status }}</span>
                    </div>

                    <p>📅 Acara: {{ optional($pesanan->tanggal_acara)->format('d M Y') ?? '-' }}</p>
                    <p>📍 {{ \Illuminate\Support\Str::limit($pesanan->alamat_pengiriman ?? '-', 45) }}</p>
                    <strong>Rp{{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</strong>

                    <small>
                        Item:
                        {{ $pesanan->detailPesanans_count ?? ($pesanan->detailPesanans->count() ?? 0) }}
                        menu
                    </small>
                </div>
            @empty
                <p class="empty-text">Belum ada pesanan.</p>
            @endforelse
        </div>
    </div>
</section>
