<section id="menu" class="section menu-section">
    <div class="container">
        <div class="section-title">
            <span>Menu Catering</span>
            <h2>Menu Andalan SiCantik</h2>
            <p>Klik "Tambah" untuk memasukkan menu ke keranjang pesanan kamu.</p>
        </div>

        <div class="menu-filters">
            <button class="menu-filter active" data-filter="all">Semua</button>
            @foreach ($kategoriMenus as $kategori)
                <button class="menu-filter" data-filter="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</button>
            @endforeach
        </div>

        <div class="menu-grid" id="menuGrid">
            @forelse ($menus as $menu)
                <div class="menu-card" data-menu-id="{{ $menu->id }}" data-menu-name="{{ $menu->nama_menu }}" data-menu-price="{{ $menu->harga }}" data-menu-image="{{ $menu->gambar ? asset('storage/' . $menu->gambar) : '' }}" data-category="{{ $menu->kategori_menu_id }}">
                    <div class="menu-image">
                        @if (!empty($menu->gambar))
                            <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}" loading="lazy">
                        @else
                            <span>🍛</span>
                        @endif
                    </div>

                    <div class="menu-content">
                        <div class="menu-top">
                            <span>{{ $menu->kategoriMenu->nama_kategori ?? 'Catering' }}</span>
                            <small class="{{ $menu->status == 'Tersedia' ? 'available' : 'not-available' }}">
                                {{ $menu->status }}
                            </small>
                        </div>

                        <h3>{{ $menu->nama_menu }}</h3>
                        <p>{{ $menu->deskripsi ?? 'Menu catering pilihan dengan rasa terbaik.' }}</p>

                        <div class="menu-bottom">
                            <strong>Rp{{ number_format($menu->harga, 0, ',', '.') }}</strong>
                            @if ($menu->status == 'Tersedia')
                                <button class="add-to-cart-btn" data-menu-id="{{ $menu->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    Tambah
                                </button>
                            @else
                                <button class="btn-disabled" disabled>Tidak Tersedia</button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="empty-text">Belum ada menu catering.</p>
            @endforelse
        </div>
    </div>
</section>
