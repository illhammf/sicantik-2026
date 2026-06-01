<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $pengaturan->nama_website ?? 'SiCantik Catering' }}</title>

    @if (!empty($pengaturan?->favicon_url))
        <link rel="icon" href="{{ $pengaturan->favicon_url }}">
    @elseif (!empty($pengaturan?->favicon_website))
        <link rel="icon" href="{{ asset('storage/' . $pengaturan->favicon_website) }}">
    @endif

    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
</head>
<body>

<header class="navbar">
    <div class="container nav-wrapper">
        <a href="#home" class="logo">
            @if (!empty($pengaturan?->logo_url))
                <img src="{{ $pengaturan->logo_url }}" alt="{{ $pengaturan->nama_website ?? 'Logo Website' }}">
            @elseif (!empty($pengaturan?->logo_website))
                <img src="{{ asset('storage/' . $pengaturan->logo_website) }}" alt="{{ $pengaturan->nama_website ?? 'Logo Website' }}">
            @else
                Si<span>Cantik</span>
            @endif
        </a>

        <nav class="nav-menu" id="navMenu">
            <a href="#home">Home</a>
            <a href="#kategori">Kategori</a>
            <a href="#menu">Menu</a>
            <a href="#pesanan">Pesanan</a>
            <a href="#alur">Alur</a>
            <a href="#ulasan">Ulasan</a>
            <a href="#kontak">Kontak</a>

            @if (Route::has('filament.admin.auth.login'))
                @auth
                    <a href="{{ route('filament.admin.pages.dashboard') }}" class="btn-admin">Dashboard</a>
                @else
                    <a href="{{ route('filament.admin.auth.login') }}" class="btn-admin">Admin</a>
                @endauth
            @endif
        </nav>

        <button class="hamburger" id="hamburger" type="button">☰</button>
    </div>
</header>

@if (session('success'))
    <div class="flash-message">
        {{ session('success') }}
    </div>
@endif

<section id="home" class="hero">
    <div class="container hero-wrapper">
        <div class="hero-content">
            <span class="badge">
                {{ $pengaturan->badge_hero ?? 'Catering Lezat Untuk Setiap Acara' }}
            </span>

            <h1>
                {{ $pengaturan->judul_hero ?? 'Solusi Catering Praktis, Enak, dan Terpercaya' }}
            </h1>

            <p>
                {{ $pengaturan->deskripsi_hero ?? 'SiCantik Catering menyediakan nasi box, snack box, dan paket prasmanan untuk acara kampus, kantor, keluarga, seminar, dan kegiatan organisasi.' }}
            </p>

            <div class="hero-buttons">
                <a href="#menu" class="btn-primary">Lihat Menu</a>
                <a href="#kontak" class="btn-outline">Hubungi Kami</a>
            </div>

            <div class="hero-mini-info">
                <span>✅ Menu dinamis dari admin</span>
                <span>✅ Pesan kontak masuk Filament</span>
                <span>✅ Ulasan pelanggan tersimpan</span>
            </div>
        </div>

        <div class="hero-visual">
            @if (!empty($pengaturan?->gambar_hero))
                <img src="{{ asset('storage/' . $pengaturan->gambar_hero) }}" alt="Hero">
            @endif
        </div>

        <div class="hero-card">
            <span>Paket Favorit</span>
            <h3>{{ $menuFavorit->nama_menu ?? 'Nasi Box Ayam Bakar' }}</h3>
            <p>{{ $menuFavorit->deskripsi ?? 'Ayam bakar, nasi, sambal dan lalapan' }}</p>
            <strong>Rp{{ number_format($menuFavorit->harga ?? 25000, 0, ',', '.') }}</strong>
        </div>
    </div>

    
</section>

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

<section id="menu" class="section menu-section">
    <div class="container">
        <div class="section-title">
            <span>Menu Catering</span>
            <h2>Menu Andalan SiCantik</h2>
            <p>Menu, harga, kategori, gambar, dan status dapat dikelola dari Filament Admin.</p>
        </div>

        <div class="menu-grid">
            @forelse ($menus as $menu)
                <div class="menu-card">
                    <div class="menu-image">
                        @if (!empty($menu->gambar))
                            <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}">
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
                            <a href="#kontak">Pesan</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="empty-text">Belum ada menu catering.</p>
            @endforelse
        </div>
    </div>
</section>

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

<section class="section payment-section">
    <div class="container">
        <div class="section-title">
            <span>Pembayaran</span>
            <h2>Status Pembayaran Terbaru</h2>
            <p>Data pembayaran diambil dari tabel pembayaran dan dapat dikelola melalui admin.</p>
        </div>

        <div class="payment-grid">
            @forelse (($pembayarans ?? collect())->take(4) as $pembayaran)
                <div class="payment-card">
                    <span>{{ $pembayaran->metode_pembayaran }}</span>
                    <h3>{{ $pembayaran->pesanan->pelanggan->nama ?? 'Pelanggan' }}</h3>
                    <p>Rp{{ number_format($pembayaran->jumlah_bayar ?? 0, 0, ',', '.') }}</p>
                    <strong class="{{ $pembayaran->status == 'Lunas' ? 'paid' : 'pending' }}">
                        {{ $pembayaran->status }}
                    </strong>
                </div>
            @empty
                <p class="empty-text">Belum ada data pembayaran.</p>
            @endforelse
        </div>
    </div>
</section>

<section id="alur" class="section">
    <div class="container">
        <div class="section-title">
            <span>Alur Pemesanan</span>
            <h2>Cara Pesan Catering</h2>
            <p>Proses pemesanan dibuat sederhana agar pelanggan mudah melakukan reservasi.</p>
        </div>

        <div class="steps-grid">
            <div class="step-card">
                <span>01</span>
                <h3>Pilih Menu</h3>
                <p>Pelanggan melihat daftar menu catering yang tersedia.</p>
            </div>

            <div class="step-card">
                <span>02</span>
                <h3>Hubungi Admin</h3>
                <p>Pelanggan mengirim pesan melalui form kontak.</p>
            </div>

            <div class="step-card">
                <span>03</span>
                <h3>Konfirmasi</h3>
                <p>Admin mengecek detail pesanan, tanggal acara, dan pembayaran.</p>
            </div>

            <div class="step-card">
                <span>04</span>
                <h3>Diproses</h3>
                <p>Pesanan disiapkan dan dikirim sesuai jadwal acara.</p>
            </div>
        </div>
    </div>
</section>

<section id="ulasan" class="section testimonial-section">
    <div class="container">
        <div class="section-title">
            <span>Ulasan Pelanggan</span>
            <h2>Kata Mereka Tentang SiCantik</h2>
            <p>Ulasan pelanggan masuk ke database dan tampil di halaman admin.</p>
        </div>

        <div class="testimonial-grid">
            @forelse ($ulasans as $ulasan)
                <div class="testimonial-card">
                    <div class="stars">{{ str_repeat('⭐', (int) $ulasan->rating) }}</div>
                    <p>"{{ $ulasan->komentar }}"</p>
                    <h4>{{ $ulasan->pelanggan->nama ?? 'Pelanggan' }}</h4>
                    <small>
                        Acara:
                        {{ optional($ulasan->pesanan->tanggal_acara ?? null)->format('d M Y') ?? '-' }}
                    </small>
                </div>
            @empty
                <p class="empty-text">Belum ada ulasan pelanggan.</p>
            @endforelse
        </div>

        <div class="review-wrapper">
            <div class="review-info">
                <span class="badge">Kirim Ulasan</span>
                <h3>Bagikan Pengalaman Kamu</h3>
                <p>Form ini menyimpan data ke tabel pelanggan dan ulasan, lalu tampil di Filament Admin.</p>
            </div>

            <form class="review-form" method="POST" action="{{ route('ulasan.store') }}">
                @csrf

                <div class="form-grid">
                    <input type="text" name="nama" placeholder="Nama Lengkap" value="{{ old('nama') }}" required>
                    <input type="email" name="email" placeholder="Email Aktif" value="{{ old('email') }}" required>
                    <input type="text" name="no_hp" placeholder="Nomor HP" value="{{ old('no_hp') }}" required>

                    <select name="pesanan_id" required>
                        <option value="">Pilih Pesanan</option>
                        @foreach ($pesanans ?? [] as $pesanan)
                            <option value="{{ $pesanan->id }}" {{ old('pesanan_id') == $pesanan->id ? 'selected' : '' }}>
                                {{ $pesanan->pelanggan->nama ?? 'Pelanggan' }}
                                - Acara {{ optional($pesanan->tanggal_acara)->format('d M Y') ?? '-' }}
                            </option>
                        @endforeach
                    </select>

                    <select name="rating" required>
                        <option value="">Pilih Rating</option>
                        <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>5 - Sangat Baik</option>
                        <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 - Baik</option>
                        <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 - Cukup</option>
                        <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 - Kurang</option>
                        <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 - Sangat Kurang</option>
                    </select>

                    <textarea name="alamat" rows="3" placeholder="Alamat Lengkap" required>{{ old('alamat') }}</textarea>
                    <textarea name="komentar" rows="4" placeholder="Tulis ulasan kamu..." required>{{ old('komentar') }}</textarea>
                </div>

                @if ($errors->any())
                    <div class="alert-error">Mohon cek kembali data yang kamu isi.</div>
                @endif

                <button type="submit">Kirim Ulasan</button>
            </form>
        </div>
    </div>
</section>

<section id="kontak" class="section contact-section">
    <div class="container contact-wrapper">
        <div class="contact-info">
            <span class="badge">Kontak Kami</span>
            <h2>{{ $pengaturan->judul_kontak ?? 'Butuh Catering untuk Acara Kamu?' }}</h2>

            <p>
                {{ $pengaturan->deskripsi_kontak ?? 'Kirim pesan melalui form berikut. Admin akan membantu kebutuhan catering kamu.' }}
            </p>

            <div class="contact-list">
                <p>📍 {{ $pengaturan->alamat ?? 'Tangerang, Indonesia' }}</p>
                <p>📞 {{ $pengaturan->no_hp ?? '0812-3456-7890' }}</p>
                <p>✉️ {{ $pengaturan->email ?? 'sicantikcatering@gmail.com' }}</p>
            </div>

            <div class="social-links">
                @if (!empty($pengaturan?->instagram))
                    <a href="{{ $pengaturan->instagram }}" target="_blank">Instagram</a>
                @endif

                @if (!empty($pengaturan?->facebook))
                    <a href="{{ $pengaturan->facebook }}" target="_blank">Facebook</a>
                @endif

                @if (!empty($pengaturan?->tiktok))
                    <a href="{{ $pengaturan->tiktok }}" target="_blank">TikTok</a>
                @endif

                @if (!empty($pengaturan?->youtube))
                    <a href="{{ $pengaturan->youtube }}" target="_blank">YouTube</a>
                @endif

                @if (!empty($pengaturan?->whatsapp))
                    <a href="{{ $pengaturan->whatsapp }}" target="_blank">WhatsApp</a>
                @endif
            </div>
        </div>

        <form class="contact-form" method="POST" action="{{ route('pesan-kontak.store') }}">
            @csrf

            <input type="text" name="nama" placeholder="Nama Lengkap" value="{{ old('nama') }}" required>
            <input type="email" name="email" placeholder="Email Aktif" value="{{ old('email') }}" required>
            <input type="text" name="subjek" placeholder="Subjek Pesan" value="{{ old('subjek') }}" required>
            <textarea name="pesan" rows="5" placeholder="Tulis pesan kamu..." required>{{ old('pesan') }}</textarea>

            <button type="submit">Kirim Pesan</button>
        </form>
    </div>
</section>

<footer class="footer">
    <p>{{ $pengaturan->footer ?? 'Copyright © 2026 SiCantik Catering. Design by Ilham Firmansyah.' }}</p>
</footer>

<script src="{{ asset('front/js/script.js') }}"></script>
</body>
</html>