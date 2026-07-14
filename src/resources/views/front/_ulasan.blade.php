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
