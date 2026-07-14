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
