<header class="navbar" role="banner">
    <div class="container nav-wrapper">
        <a href="#home" class="logo" aria-label="Beranda">
            @if (!empty($pengaturan?->logo_url))
                <img src="{{ $pengaturan->logo_url }}" alt="{{ $pengaturan->nama_website ?? 'Logo Website' }}">
            @elseif (!empty($pengaturan?->logo_website))
                <img src="{{ asset('storage/' . $pengaturan->logo_website) }}" alt="{{ $pengaturan->nama_website ?? 'Logo Website' }}">
            @else
                Si<span>Cantik</span>
            @endif
        </a>

        <nav class="nav-menu" id="navMenu" role="navigation" aria-label="Navigasi utama">
            <a href="#home" class="active">Home</a>
            <a href="#kategori">Kategori</a>
            <a href="#menu">Menu</a>
            <a href="#pesanan">Pesanan</a>
            <a href="#alur">Alur</a>
            <a href="#ulasan">Ulasan</a>
            <a href="#kontak">Kontak</a>
        </nav>

        <div class="nav-actions">
            @auth('pelanggan')
                <div class="nav-user">
                    <span class="nav-user-name">{{ Auth::guard('pelanggan')->user()->nama }}</span>
                    <form method="POST" action="{{ route('pelanggan.logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="btn-logout">Keluar</button>
                    </form>
                </div>
            @else
                <a href="{{ route('pelanggan.login') }}" class="btn-admin">Masuk</a>
            @endauth

            <button class="cart-btn" id="cartToggle" aria-label="Keranjang" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span class="cart-badge" id="cartBadge">0</span>
            </button>

            <button class="hamburger" id="hamburger" type="button" aria-label="Toggle menu" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>
</header>
