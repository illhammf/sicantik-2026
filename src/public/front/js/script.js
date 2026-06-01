const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('navMenu');

if (hamburger && navMenu) {
    hamburger.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        hamburger.textContent = navMenu.classList.contains('active') ? '✕' : '☰';
    });

    document.querySelectorAll('.nav-menu a').forEach((link) => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
            hamburger.textContent = '☰';
        });
    });
}

window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');

    if (navbar) {
        navbar.classList.toggle('scrolled', window.scrollY > 40);
    }
});

const flashMessage = document.querySelector('.flash-message');

if (flashMessage) {
    setTimeout(() => {
        flashMessage.style.opacity = '0';
        flashMessage.style.transform = 'translateY(-10px)';

        setTimeout(() => {
            flashMessage.remove();
        }, 400);
    }, 3500);
}

const revealElements = document.querySelectorAll(
    '.section-title, .category-card, .menu-card, .order-card, .payment-card, .step-card, .testimonial-card, .review-wrapper, .contact-wrapper'
);

const revealOnScroll = () => {
    revealElements.forEach((element) => {
        const elementTop = element.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;

        if (elementTop < windowHeight - 80) {
            element.classList.add('show');
        }
    });
};

window.addEventListener('scroll', revealOnScroll);
window.addEventListener('load', revealOnScroll);

const orderButtons = document.querySelectorAll('.menu-bottom a');

orderButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const menuCard = button.closest('.menu-card');
        const menuName = menuCard?.querySelector('h3')?.textContent?.trim();

        const subjectInput = document.querySelector('input[name="subjek"]');
        const messageInput = document.querySelector('textarea[name="pesan"]');

        if (menuName && subjectInput && messageInput) {
            subjectInput.value = `Pesanan ${menuName}`;
            messageInput.value = `Halo admin SiCantik, saya ingin bertanya dan memesan menu ${menuName}.`;
        }
    });
});