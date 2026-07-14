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
                <div class="nav-user-dropdown">
                    <button class="nav-user-btn" id="userDropdownBtn" aria-haspopup="true">
                        <span class="nav-user-avatar">{{ substr(Auth::guard('pelanggan')->user()->nama, 0, 1) }}</span>
                        <span class="nav-user-name">{{ Auth::guard('pelanggan')->user()->nama }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="nav-dropdown" id="userDropdown">
                        <a href="{{ route('pelanggan.dashboard') }}" class="nav-dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('pelanggan.pesanan') }}" class="nav-dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                            Pesanan Saya
                        </a>
                        <a href="{{ route('pelanggan.profil') }}" class="nav-dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Profil
                        </a>
                        <div class="nav-dropdown-divider"></div>
                        <form method="POST" action="{{ route('pelanggan.logout') }}">
                            @csrf
                            <button type="submit" class="nav-dropdown-item nav-dropdown-logout">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
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
