import './bootstrap';

// ============================================================
// CART SYSTEM
// ============================================================

const CART_STORAGE_KEY = 'sicantik_cart';

function getCart() {
    try {
        return JSON.parse(localStorage.getItem(CART_STORAGE_KEY)) || [];
    } catch {
        return [];
    }
}

function saveCart(cart) {
    localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
}

function updateCartUI() {
    const cart = getCart();
    const badge = document.getElementById('cartBadge');
    const emptyEl = document.getElementById('cartEmpty');
    const itemsEl = document.getElementById('cartItems');
    const footerEl = document.getElementById('cartFooter');

    const totalItems = cart.reduce((sum, item) => sum + item.jumlah, 0);
    if (badge) badge.textContent = totalItems;

    if (cart.length === 0) {
        if (emptyEl) emptyEl.style.display = 'flex';
        if (itemsEl) itemsEl.innerHTML = '';
        if (footerEl) footerEl.style.display = 'none';
        return;
    }

    if (emptyEl) emptyEl.style.display = 'none';
    if (footerEl) footerEl.style.display = 'block';

    let html = '';
    let totalPrice = 0;

    cart.forEach((item, index) => {
        const subtotal = item.harga * item.jumlah;
        totalPrice += subtotal;
        const imgHtml = item.gambar
            ? `<img src="${item.gambar}" alt="${item.nama}">`
            : '🍛';
        html += `
            <div class="cart-item" data-index="${index}">
                <div class="cart-item-img">${imgHtml}</div>
                <div class="cart-item-info">
                    <h4>${item.nama}</h4>
                    <p>Rp${formatNumber(item.harga)}</p>
                    <div class="cart-item-actions">
                        <button class="cart-qty-minus" data-index="${index}">−</button>
                        <span>${item.jumlah}</span>
                        <button class="cart-qty-plus" data-index="${index}">+</button>
                        <button class="cart-item-remove" data-index="${index}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>`;
    });

    if (itemsEl) itemsEl.innerHTML = html;
    const totalEl = document.getElementById('cartTotal');
    if (totalEl) totalEl.textContent = `Rp${formatNumber(totalPrice)}`;

    // Attach cart item events
    document.querySelectorAll('.cart-qty-minus').forEach(btn => {
        btn.addEventListener('click', () => updateQty(parseInt(btn.dataset.index), -1));
    });
    document.querySelectorAll('.cart-qty-plus').forEach(btn => {
        btn.addEventListener('click', () => updateQty(parseInt(btn.dataset.index), 1));
    });
    document.querySelectorAll('.cart-item-remove').forEach(btn => {
        btn.addEventListener('click', () => removeItem(parseInt(btn.dataset.index)));
    });
}

function updateQty(index, delta) {
    const cart = getCart();
    if (!cart[index]) return;
    cart[index].jumlah = Math.max(1, cart[index].jumlah + delta);
    saveCart(cart);
    updateCartUI();
}

function removeItem(index) {
    let cart = getCart();
    cart.splice(index, 1);
    saveCart(cart);
    updateCartUI();
    if (cart.length === 0) closeCart();
}

function addToCart(menuId, menuName, menuPrice, menuImage) {
    let cart = getCart();
    const existing = cart.find(item => item.id === menuId);
    if (existing) {
        existing.jumlah += 1;
    } else {
        cart.push({
            id: menuId,
            nama: menuName,
            harga: menuPrice,
            gambar: menuImage,
            jumlah: 1,
        });
    }
    saveCart(cart);
    updateCartUI();
    openCart();
}

function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// ============================================================
// CART UI TOGGLE
// ============================================================

function openCart() {
    document.getElementById('cartSidebar')?.classList.add('active');
    document.getElementById('cartOverlay')?.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeCart() {
    document.getElementById('cartSidebar')?.classList.remove('active');
    document.getElementById('cartOverlay')?.classList.remove('active');
    document.body.style.overflow = '';
}

document.getElementById('cartToggle')?.addEventListener('click', () => {
    const isActive = document.getElementById('cartSidebar')?.classList.contains('active');
    if (isActive) closeCart();
    else openCart();
});

document.getElementById('cartClose')?.addEventListener('click', closeCart);
document.getElementById('cartOverlay')?.addEventListener('click', closeCart);

// ============================================================
// CHECKOUT MODAL
// ============================================================

function openCheckout() {
    const cart = getCart();
    if (cart.length === 0) return;

    closeCart();

    // Populate summary
    let html = '';
    let total = 0;
    cart.forEach(item => {
        const sub = item.harga * item.jumlah;
        total += sub;
        html += `
            <div class="checkout-summary-item">
                <span>${item.nama} × ${item.jumlah}</span>
                <span>Rp${formatNumber(sub)}</span>
            </div>`;
    });
    html += `
        <div class="checkout-summary-total">
            <span>Total</span>
            <span>Rp${formatNumber(total)}</span>
        </div>`;

    document.getElementById('checkoutSummary').innerHTML = html;
    document.getElementById('checkoutItems').value = JSON.stringify(
        cart.map(item => ({ menu_id: item.id, jumlah: item.jumlah }))
    );

    document.getElementById('checkoutModal').style.display = 'block';
    document.getElementById('modalOverlay').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeCheckout() {
    document.getElementById('checkoutModal').style.display = 'none';
    document.getElementById('modalOverlay').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('checkoutBtn')?.addEventListener('click', openCheckout);
document.getElementById('modalClose')?.addEventListener('click', closeCheckout);
document.getElementById('modalOverlay')?.addEventListener('click', closeCheckout);

// ============================================================
// ADD TO CART BUTTONS (Menu Cards)
// ============================================================

document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const card = btn.closest('.menu-card');
        if (!card) return;
        const id = parseInt(card.dataset.menuId);
        const name = card.dataset.menuName;
        const price = parseInt(card.dataset.menuPrice);
        const image = card.dataset.menuImage || '';
        addToCart(id, name, price, image);
    });
});

// ============================================================
// NAVBAR
// ============================================================

const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('navMenu');
const navbar = document.querySelector('.navbar');

const overlay = document.createElement('div');
overlay.className = 'nav-overlay';
document.body.appendChild(overlay);

function toggleMenu(open) {
    navMenu?.classList.toggle('active', open);
    overlay?.classList.toggle('active', open);
    if (hamburger) {
        hamburger.setAttribute('aria-expanded', open);
    }
    document.body.style.overflow = open ? 'hidden' : '';
}

if (hamburger && navMenu) {
    hamburger.addEventListener('click', () => toggleMenu(!navMenu.classList.contains('active')));
    overlay.addEventListener('click', () => toggleMenu(false));
    document.querySelectorAll('.nav-menu a').forEach((link) => {
        link.addEventListener('click', () => toggleMenu(false));
    });
}

// ============================================================
// SCROLL EFFECTS
// ============================================================

window.addEventListener('scroll', () => {
    if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 50);

    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-menu a:not(.btn-admin)');
    let current = '';
    sections.forEach(section => {
        if (window.scrollY >= section.offsetTop - 120) {
            current = section.getAttribute('id');
        }
    });
    navLinks.forEach(link => link.classList.toggle('active', link.getAttribute('href') === '#' + current));

    const scrollBtn = document.getElementById('scrollTop');
    if (scrollBtn) scrollBtn.classList.toggle('visible', window.scrollY > 400);
});

document.getElementById('scrollTop')?.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// ============================================================
// FLASH MESSAGE
// ============================================================

const flashMessage = document.querySelector('.flash-message');
if (flashMessage) {
    setTimeout(() => {
        flashMessage.style.opacity = '0';
        flashMessage.style.transform = 'translateY(-10px)';
        flashMessage.style.transition = '.4s ease';
        setTimeout(() => flashMessage.remove(), 400);
    }, 4000);
}

// ============================================================
// SCROLL REVEAL ANIMATIONS
// ============================================================

const revealElements = document.querySelectorAll(
    '.section-title, .category-card, .menu-card, .order-card, .payment-card, .step-card, .testimonial-card, .review-wrapper, .contact-wrapper, .stat-card'
);

const revealOnScroll = () => {
    const windowHeight = window.innerHeight;
    revealElements.forEach(el => {
        if (el.getBoundingClientRect().top < windowHeight - 60) {
            el.classList.add('show');
        }
    });
};

window.addEventListener('scroll', revealOnScroll, { passive: true });
window.addEventListener('load', revealOnScroll);
window.addEventListener('resize', revealOnScroll);

// ============================================================
// COUNTER ANIMATION
// ============================================================

function animateCounters() {
    document.querySelectorAll('.stat-card h2').forEach(el => {
        const text = el.textContent;
        const match = text.match(/^([\d.]+)([+]?)$/);
        if (!match) return;
        const target = parseFloat(match[1]);
        const suffix = match[2] || '';
        const isDecimal = text.includes('.');
        const duration = 1500;
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = target * eased;
            el.textContent = (isDecimal ? current.toFixed(1) : Math.floor(current)) + suffix;
            if (progress < 1) requestAnimationFrame(update);
        }
        requestAnimationFrame(update);
    });
}

const statsSection = document.querySelector('.stats');
if (statsSection) {
    let counted = false;
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !counted) {
                counted = true;
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });
    observer.observe(statsSection);
}

// ============================================================
// FAQ ACCORDION
// ============================================================

document.querySelectorAll('.faq-question').forEach(btn => {
    btn.addEventListener('click', () => {
        const item = btn.closest('.faq-item');
        const isActive = item.classList.contains('active');

        // Close all
        document.querySelectorAll('.faq-item').forEach(el => el.classList.remove('active'));

        // Toggle current
        if (!isActive) item.classList.add('active');
    });
});

// ============================================================
// MENU CATEGORY FILTER
// ============================================================

const filterButtons = document.querySelectorAll('.menu-filter');
const menuCards = document.querySelectorAll('.menu-card');

filterButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        filterButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const filter = btn.dataset.filter;

        menuCards.forEach(card => {
            if (filter === 'all' || card.dataset.category === filter) {
                card.style.display = '';
                // Re-trigger animation
                card.classList.remove('show');
                requestAnimationFrame(() => {
                    if (card.getBoundingClientRect().top < window.innerHeight - 60) {
                        card.classList.add('show');
                    }
                });
            } else {
                card.style.display = 'none';
            }
        });
    });
});

// ============================================================
// USER DROPDOWN
// ============================================================

const dropdownBtn = document.getElementById('userDropdownBtn');
const dropdown = document.getElementById('userDropdown');

if (dropdownBtn && dropdown) {
    dropdownBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('open');
    });

    document.addEventListener('click', (e) => {
        if (!dropdown.contains(e.target) && !dropdownBtn.contains(e.target)) {
            dropdown.classList.remove('open');
        }
    });
}

// ============================================================
// SYNC CART BADGE (for duplicate badges)
// ============================================================

const cartBadge2 = document.getElementById('cartBadge2');
const _origUpdateUI = updateCartUI;

updateCartUI = function() {
    _origUpdateUI();

    const cart = getCart();
    const totalItems = cart.reduce((sum, item) => sum + item.jumlah, 0);
    if (cartBadge2) cartBadge2.textContent = totalItems;
};

// Also hook cartToggle2
document.getElementById('cartToggle2')?.addEventListener('click', () => {
    document.getElementById('cartSidebar')?.classList.add('active');
    document.getElementById('cartOverlay')?.classList.add('active');
    document.body.style.overflow = 'hidden';
});

// ============================================================
// INIT
// ============================================================

updateCartUI();
