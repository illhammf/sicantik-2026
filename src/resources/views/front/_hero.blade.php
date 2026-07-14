<section id="home" class="hero">
    <div class="container hero-wrapper">
        <div class="hero-content">
            <span class="badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                {{ $pengaturan->badge_hero ?? 'Catering Lezat Untuk Setiap Acara' }}
            </span>

            <h1>
                {{ $pengaturan->judul_hero ?? 'Solusi Catering Praktis, Enak, dan Terpercaya' }}
            </h1>

            <p>
                {{ $pengaturan->deskripsi_hero ?? 'SiCantik Catering menyediakan nasi box, snack box, dan paket prasmanan untuk acara kampus, kantor, keluarga, seminar, dan kegiatan organisasi.' }}
            </p>

            <div class="hero-buttons">
                <a href="#menu" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    Lihat Menu
                </a>
                <a href="#kontak" class="btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    Hubungi Kami
                </a>
            </div>
        </div>

        <div class="hero-visual">
            @if (!empty($pengaturan?->gambar_hero))
                <img src="{{ asset('storage/' . $pengaturan->gambar_hero) }}" alt="{{ $pengaturan->nama_website ?? 'Hero Image' }}" loading="lazy">
            @endif
        </div>
    </div>
</section>
