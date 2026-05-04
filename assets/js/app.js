// ===== NAV ACTIVE ON CLICK =====
const navLinks = document.querySelectorAll('.main-nav a');
navLinks.forEach(link => {
    link.addEventListener('click', function () {
        navLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
    });
});

// ===== NAV ACTIVE ON SCROLL =====
window.addEventListener('scroll', () => {
    let current = '';
    const sections = document.querySelectorAll('section[id]');
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        if (scrollY >= (sectionTop - 200)) current = section.getAttribute('id');
    });
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) link.classList.add('active');
    });
});

// ===== BACK TO TOP =====
const backToTopButton = document.getElementById('backToTop');
window.addEventListener('scroll', () => {
    backToTopButton.style.display = window.pageYOffset > 300 ? 'flex' : 'none';
});
backToTopButton.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// ===== INTERSECTION ANIMATION =====
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('article, .service-card, details').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity .6s ease, transform .6s ease';
    observer.observe(el);
});

// ===== CONTACT FORM AJAX =====
const contactForm = document.getElementById('contactForm');
const formMessage = document.getElementById('formMessage');

if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(contactForm);

        try {
            const res = await fetch(contactForm.action, {
                method: 'POST',
                body: formData
            });
            const data = await res.json();

            formMessage.classList.remove('success', 'error');
            if (data.success) {
                formMessage.classList.add('success');
                formMessage.textContent = data.msg;
                formMessage.style.display = 'block';
                contactForm.reset();
            } else {
                formMessage.classList.add('error');
                formMessage.textContent = data.msg || 'Terjadi kesalahan';
                formMessage.style.display = 'block';
            }
            setTimeout(() => { formMessage.style.display = 'none'; }, 5000);
        } catch (err) {
            formMessage.classList.remove('success', 'error');
            formMessage.classList.add('error');
            formMessage.textContent = 'Gagal mengirim. Periksa koneksi atau server.';
            formMessage.style.display = 'block';
            setTimeout(() => { formMessage.style.display = 'none'; }, 5000);
        }
    });
}

// ===== FETCH ARTWORKS =====
async function loadArtworks() {
    try {
        const res = await fetch('backend/artworks_fetch.php');
        const data = await res.json();

        if (data.success) {
            const gallery = document.getElementById('gallery');
            if (!gallery) return; // safety check
            gallery.innerHTML = '';

            data.data.forEach(art => {
                const card = document.createElement('figure');
                card.className = 'art-card';
                card.innerHTML = `
                    <img src="${art.image_path}" alt="${art.title}">
                    <figcaption>
                        <h3>${art.title}</h3>
                        <p>${art.description}</p>
                    </figcaption>
                `;
                gallery.appendChild(card);
            });
        }
    } catch (err) {
        console.error('Gagal memuat artworks:', err);
    }
}

document.addEventListener('DOMContentLoaded', loadArtworks);