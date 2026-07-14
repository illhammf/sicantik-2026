<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - {{ $pengaturan?->nama_website ?? 'SiCantik Catering' }}</title>

    @if (!empty($pengaturan?->favicon_url))
        <link rel="icon" href="{{ $pengaturan->favicon_url }}">
    @elseif (!empty($pengaturan?->favicon_website))
        <link rel="icon" href="{{ asset('storage/' . $pengaturan->favicon_website) }}">
    @endif

    @vite(['resources/css/front.css', 'resources/js/front.js'])
</head>
<body>
    <div class="pelanggan-layout">
        {{-- Sidebar --}}
        <aside class="pel-sidebar" id="pelSidebar">
            <div class="pel-sidebar-header">
                <a href="/" class="pel-sidebar-logo">
                    @if (!empty($pengaturan?->logo_url))
                        <img src="{{ $pengaturan->logo_url }}" alt="Logo">
                    @else
                        Si<span>Cantik</span>
                    @endif
                </a>
                <button class="pel-sidebar-close" id="pelSidebarClose" aria-label="Tutup menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="pel-sidebar-user">
                <div class="pel-user-avatar">{{ substr(Auth::guard('pelanggan')->user()->nama, 0, 1) }}</div>
                <div class="pel-user-info">
                    <h4>{{ Auth::guard('pelanggan')->user()->nama }}</h4>
                    <p>{{ Auth::guard('pelanggan')->user()->email }}</p>
                </div>
            </div>

            <nav class="pel-sidebar-nav">
                <a href="{{ route('pelanggan.dashboard') }}" class="pel-nav-item {{ request()->routeIs('pelanggan.dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('pelanggan.pesanan') }}" class="pel-nav-item {{ request()->routeIs('pelanggan.pesanan*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    Pesanan Saya
                </a>
                <a href="{{ route('pelanggan.profil') }}" class="pel-nav-item {{ request()->routeIs('pelanggan.profil') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Profil
                </a>
            </nav>

            <div class="pel-sidebar-footer">
                <a href="/" class="pel-nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    Beranda
                </a>
                <form method="POST" action="{{ route('pelanggan.logout') }}">
                    @csrf
                    <button type="submit" class="pel-nav-item pel-nav-logout">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Overlay --}}
        <div class="pel-overlay" id="pelOverlay"></div>

        {{-- Main Content --}}
        <main class="pel-main">
            {{-- Top bar --}}
            <div class="pel-topbar">
                <button class="pel-hamburger" id="pelHamburger" aria-label="Buka menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <h2 class="pel-topbar-title">@yield('page-title', 'Dashboard')</h2>
                <div class="pel-topbar-right">
                    <button class="cart-btn" id="cartToggle2" aria-label="Keranjang" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <span class="cart-badge" id="cartBadge2">0</span>
                    </button>
                </div>
            </div>

            {{-- Flash --}}
            @if (session('success'))
                <div class="flash-message" style="margin:16px auto 0;width:96%;">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Content --}}
            <div class="pel-content">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Cart sidebar (reused from layout) --}}
    @include('layouts._cart')

    @stack('scripts')

    <script>
        // Sidebar toggle for mobile
        document.getElementById('pelHamburger')?.addEventListener('click', () => {
            document.getElementById('pelSidebar')?.classList.add('active');
            document.getElementById('pelOverlay')?.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        document.getElementById('pelSidebarClose')?.addEventListener('click', () => {
            document.getElementById('pelSidebar')?.classList.remove('active');
            document.getElementById('pelOverlay')?.classList.remove('active');
            document.body.style.overflow = '';
        });
        document.getElementById('pelOverlay')?.addEventListener('click', () => {
            document.getElementById('pelSidebar')?.classList.remove('active');
            document.getElementById('pelOverlay')?.classList.remove('active');
            document.body.style.overflow = '';
        });

        // Cart toggle in topbar
        document.getElementById('cartToggle2')?.addEventListener('click', () => {
            document.getElementById('cartSidebar')?.classList.add('active');
            document.getElementById('cartOverlay')?.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    </script>
</body>
</html>
