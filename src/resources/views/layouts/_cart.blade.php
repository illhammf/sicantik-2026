<div class="cart-overlay" id="cartOverlay"></div>
<aside class="cart-sidebar" id="cartSidebar">
    <div class="cart-header">
        <h3>Keranjang</h3>
        <button class="cart-close" id="cartClose" aria-label="Tutup keranjang">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
    <div class="cart-body" id="cartBody">
        <div class="cart-empty" id="cartEmpty">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <p>Keranjang masih kosong</p>
            <span>Tambahkan menu catering favorite kamu</span>
        </div>
        <div class="cart-items" id="cartItems"></div>
    </div>
    <div class="cart-footer" id="cartFooter" style="display:none;">
        <div class="cart-total">
            <span>Total</span>
            <strong id="cartTotal">Rp0</strong>
        </div>
        <button class="btn-primary checkout-btn" id="checkoutBtn">
            Pesan Sekarang
        </button>
    </div>
</aside>

<div class="modal-overlay" id="modalOverlay" style="display:none;"></div>
<div class="checkout-modal" id="checkoutModal" style="display:none;">
    <div class="modal-header">
        <h3>Detail Pemesanan</h3>
        <button class="modal-close" id="modalClose" aria-label="Tutup">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
    <form class="checkout-form" id="checkoutForm" method="POST" action="{{ route('pesan.store') }}">
        @csrf
        <input type="hidden" name="items" id="checkoutItems">
        <div class="checkout-summary" id="checkoutSummary"></div>
        <div class="checkout-fields">
            <input type="text" name="nama" placeholder="Nama Lengkap" value="{{ Auth::guard('pelanggan')->user()?->nama ?? '' }}" required>
            <input type="email" name="email" placeholder="Email Aktif" value="{{ Auth::guard('pelanggan')->user()?->email ?? '' }}" required>
            <input type="text" name="no_hp" placeholder="Nomor HP / WhatsApp" value="{{ Auth::guard('pelanggan')->user()?->no_hp ?? '' }}" required>
            <input type="date" name="tanggal_acara" required>
            <textarea name="alamat_pengiriman" rows="3" placeholder="Alamat Pengiriman" required>{{ Auth::guard('pelanggan')->user()?->alamat ?? '' }}</textarea>
            <textarea name="catatan" rows="2" placeholder="Catatan (opsional)"></textarea>
        </div>
        <button type="submit" class="btn-primary submit-order-btn">Konfirmasi Pesanan</button>
    </form>
</div>
