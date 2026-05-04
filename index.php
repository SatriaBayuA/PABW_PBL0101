<?php
session_start();
require_once __DIR__ . '/backend/csrf.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UMSIDA Gallery — Galeri Seni Digital</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include __DIR__ . '/partials/header.php'; ?>

    <main id="home">
    <!-- HERO SECTION -->
    <section class="hero" aria-labelledby="hero-title">
    <article>
        <h1 id="hero-title">Galeri Seni Digital UMSIDA</h1>
        <p>Temukan karya seni digital yang menakjubkan dari mahasiswa dan dosen berbakat di Universitas Muhammadiyah Sidoarjo. Jelajahi dunia kreativitas, warna, dan imajinasi tanpa batas.</p>
        <a href="#contact" class="cta-button">Hubungi Kami</a>
    </article>
    </section>

    
    <!-- FEATURED SECTION (Gallery dari DB artworks) -->
    <section id="featured" aria-labelledby="featured-title">
    <h2 id="featured-title">Karya Unggulan</h2>
    <nav class="featured-grid" aria-label="Featured artworks">
        <?php
        require_once __DIR__ . '/backend/config.php';
        $result = $mysqli->query("SELECT * FROM artworks WHERE featured=1 ORDER BY created_at DESC LIMIT 3");
        while ($row = $result->fetch_assoc()) {
            echo '<article class="card-3d glass">';
            echo '<figure>';
            echo '<img src="'.$row['image_url'].'" alt="'.htmlspecialchars($row['title']).'">';
            echo '<figcaption>';
            echo '<h3>'.htmlspecialchars($row['title']).'</h3>';
            echo '<p>'.htmlspecialchars($row['description']).'</p>';
            echo '</figcaption>';
            echo '</figure>';
            echo '</article>';
        }
        ?>
    </nav>
    </section>

    <!-- SERVICES SECTION -->
    <section class="services glass" id="services" aria-labelledby="services-title">
        <h2 id="services-title">Layanan Kami</h2>
        <article class="services-grid">
        <aside class="service-card card-3d">
            <h3>Workshop Digital Art</h3>
            <ul>
            <li>Adobe Photoshop</li>
            <li>Illustrator</li>
            <li>Digital Painting</li>
            <li>3D Modeling Basics</li>
            <li>Animation Fundamentals</li>
            </ul>
        </aside>
        <aside class="service-card card-3d">
        <h3>Pameran Virtual</h3>
            <ul>
            <li>Galeri Online Interaktif</li>
            <li>VR Exhibition</li>
            <li>Live Streaming Event</li>
            <li>Artist Talk</li>
            <li>Portfolio Showcase</li>
            </ul>
        </aside>
        <aside class="service-card card-3d">
        <h3>Langkah Bergabung</h3>
            <ol>
            <li>Daftar melalui formulir online</li>
            <li>Upload portfolio</li>
            <li>Verifikasi kurator</li>
            <li>Ikuti workshop</li>
            <li>Publikasikan karya</li>
            </ol>
        </aside>
        </article>
    </section>

    <!-- TECHNIQUES SECTION -->
    <section class="techniques glass" id="techniques" aria-labelledby="techniques-title">
        <h2 id="techniques-title">Teknik Seni Digital</h2>
        <article>
        <details class="card-3d"><summary>3D Modeling & Rendering</summary><p>Menciptakan objek dan scene tiga dimensi dengan tekstur dan pencahayaan realistis.</p></details>
        <details class="card-3d"><summary>Digital Painting</summary><p>Menggunakan stylus dan tablet untuk membuat karya yang meniru teknik tradisional.</p></details>
        <details class="card-3d"><summary>Photo Manipulation</summary><p>Mentransformasi foto untuk menciptakan gambar surreal atau enhanced.</p></details>
        <details class="card-3d"><summary>Vector Art</summary><p>Karya berbasis vektor yang tajam di segala ukuran—ideal untuk logo dan ilustrasi.</p></details>
        <details class="card-3d"><summary>Generative Art</summary><p>Seni berbasis algoritma—menggabungkan kreativitas manusia dan komputasi.</p></details>
        </article>
    </section>

    <!-- CONTACT FORM -->
    <section id="contact" aria-labelledby="contact-title">
        <h2 id="contact-title">Hubungi Kami</h2>
        <article class="contact-form glass">
        <form id="contactForm" method="post" action="backend/contact_submit.php" novalidate>
        <input type="hidden" name="csrf_token" value="<?php 
        require_once __DIR__ . '/backend/csrf.php'; 
        echo htmlspecialchars(getCsrfToken()); 
            ?>">
            <div class="form-group">
            <label for="name">Nama Lengkap *</label>
            <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
            <label for="phone">Nomor Telepon</label>
            <input type="tel" id="phone" name="phone">
            </div>
            <div class="form-group">
            <label for="category">Kategori Pertanyaan *</label>
            <select id="category" name="category" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="workshop">Workshop & Pelatihan</option>
                <option value="exhibition">Pameran Virtual</option>
                <option value="membership">Keanggotaan</option>
                <option value="collaboration">Kolaborasi</option>
                <option value="other">Lainnya</option>
            </select>
            </div>
            <div class="form-group">
            <label for="message">Pesan *</label>
            <textarea id="message" name="message" required></textarea>
            </div>
            <div class="checkbox-group">
            <input type="checkbox" id="newsletter" name="newsletter">
            <label for="newsletter">Saya ingin menerima newsletter</label>
            </div>
            <button type="submit" class="submit-button">Kirim Pesan</button>
            <aside class="form-message" id="formMessage" aria-live="polite"></aside>
        </form>
        </article>
    </section>
    </main>

    <?php include __DIR__ . '/partials/footer.php'; ?>

    <button id="backToTop" title="Kembali ke Atas" aria-label="Kembali ke atas">↑</button>

    <script src="assets/js/app.js"></script>
</body>
</html>