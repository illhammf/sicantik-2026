<section id="kategori" class="section">
    <div class="container">
        <div class="section-title">
            <span>Kategori Menu</span>
            <h2>Pilihan Paket Catering</h2>
            <p>Data kategori berasal dari admin dan dapat berubah otomatis ketika diedit.</p>
        </div>

        <div class="category-grid">
            @forelse ($kategoriMenus as $kategori)
                <div class="category-card">
                    <div class="card-icon">🍽️</div>
                    <h3>{{ $kategori->nama_kategori }}</h3>
                    <p>{{ $kategori->deskripsi ?? 'Kategori menu catering pilihan pelanggan.' }}</p>
                    <small>{{ $kategori->menus_count ?? 0 }} menu tersedia</small>
                </div>
            @empty
                <p class="empty-text">Belum ada kategori menu.</p>
            @endforelse
        </div>
    </div>
</section>
