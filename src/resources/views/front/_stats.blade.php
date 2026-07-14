<section class="stats">
    <div class="container stats-wrapper">
        <div class="stat-card">
            <h2>{{ $jumlahKategori ?? ($kategoriMenus->count() ?? 0) }}+</h2>
            <p>Kategori</p>
        </div>
        <div class="stat-card">
            <h2>{{ $jumlahMenu ?? 0 }}+</h2>
            <p>Menu Catering</p>
        </div>
        <div class="stat-card">
            <h2>{{ $jumlahPesanan ?? 0 }}+</h2>
            <p>Total Pesanan</p>
        </div>
        <div class="stat-card">
            <h2>{{ $jumlahPelanggan ?? 0 }}+</h2>
            <p>Pelanggan</p>
        </div>
        <div class="stat-card">
            <h2>{{ number_format($ratingRataRata ?? 0, 1) }}</h2>
            <p>Rating</p>
        </div>
    </div>
</section>
