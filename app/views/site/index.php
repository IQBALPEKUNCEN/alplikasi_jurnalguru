<?php

/** @var yii\web\View $this */

// Mengatur judul halaman web
$this->title = 'SMK MUHAMMADIYAH 2 AJIBARANG';

// --- Styling CSS dengan Keterangan ---
// CSS ini didefinisikan dalam string heredoc untuk kemudahan manajemen
// dan di-register ke dalam halaman menggunakan metode registerCss.
$css = <<<CSS
/* Gaya Umum untuk seluruh halaman */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box; /* Memastikan padding dan border tidak menambah ukuran elemen */
}

body {
    /* Menggunakan font modern untuk keterbacaan yang baik */
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    /* Menerapkan latar belakang gradien yang elegan */
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #333; /* Warna teks utama */
    overflow-x: hidden; /* Mencegah scroll horizontal */
    transition: all 0.4s ease; /* Transisi halus untuk perubahan tema */
}

/* Bagian Hero (Layar Utama) */
.hero-section {
    min-height: 100vh; /* Memastikan bagian ini memenuhi tinggi layar */
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

/* Menambahkan overlay poligon abstrak di latar belakang untuk estetika */
.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.03)" points="0,0 1000,300 1000,1000 0,700"/></svg>');
    z-index: 1; /* Menempatkan overlay di bawah konten */
}

.hero-content {
    position: relative;
    z-index: 2; /* Menempatkan konten di atas overlay */
    max-width: 1200px;
    width: 100%;
    padding: 0 20px;
}

/* Styling Carousel */
.carousel-container {
    position: relative;
    margin-bottom: 60px;
    /* Animasi fade-in saat halaman dimuat */
    animation: fadeInUp 0.8s ease-out;
}

.carousel-inner {
    border-radius: 20px;
    overflow: hidden;
    /*bayangan belankang gambar cuy
    /* Menambahkan bayangan untuk efek 3D */
    box-shadow: 0 25px 50px rgba(180, 154, 154, 0.3); 
    position: relative;
}

/* Overlay gradien halus pada carousel depan gambar */ 
.carousel-inner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(248, 248, 248, 0.1), rgba(118, 75, 162, 0.1));
    z-index: 1;
    pointer-events: none; /* Memastikan overlay tidak menghalangi interaksi mouse */
}

.carousel-item img {
    height: 450px;
    object-fit: cover; /* Memastikan gambar terisi penuh tanpa distorsi */
    transition: transform 0.5s ease;
}

/* Efek zoom-in halus saat gambar di-hover */
.carousel-item:hover img {
    transform: scale(1.05);
}

/* Tombol navigasi (panah) carousel warna panah */
.carousel-control-prev,
.carousel-control-next {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    transition: all 0.3s ease;
    backdrop-filter: blur(10px); /* Efek frosted glass yang menarik */
}

/* Menyesuaikan posisi tombol navigasi */
.carousel-control-prev { left: -30px; }
.carousel-control-next { right: -30px; }

/* Efek hover pada tombol navigasi warnA lingkaran panah */
.carousel-control-prev:hover,
.carousel-control-next:hover {
    background: rgba(255, 255, 255, 1);
    transform: translateY(-50%) scale(1.1);
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    width: 20px;
    height: 20px;
    background-size: 20px;
    filter: invert(1); /* Membuat ikon berwarna putih */
}

/* Indikator (titik) carousel warna titik di bawah gambar */
.carousel-indicators { bottom: -50px; }
.carousel-indicators li {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    margin: 0 8px;
    transition: all 0.3s ease;
}

.carousel-indicators li.active {
    background: #fff;
    transform: scale(1.2);
}

/* Bagian Sambutan dan Fitur backgroud */
.welcome-section {
    text-align: center;
    animation: fadeInUp 0.8s ease-out 0.2s both;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px); /* Frosted glass effect */
    padding: 50px 40px;
    border-radius: 25px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.welcome-title {
    font-size: 3rem;
    font-weight: 700;
    color: white; /* Judul berwarna putih */ 
    margin-bottom: 10px;
    text-shadow: 0 4px 6px rgba(0,0,0,0.2); /* Bayangan teks untuk visibilitas Sistem jurnal guru di bawah gambar */
}

/* warna smk muhammadiya 2 ajbarang */
.welcome-subtitle {
    font-size: 1.5rem;
    font-weight: 400;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 30px;
    letter-spacing: 0.5px;
}

.features-grid {
    display: grid;
    /* Membuat grid responsif, kartu akan menyesuaikan lebar layar */
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.feature-card {
    background: rgba(255, 255, 255, 0.1);
    padding: 30px;
    border-radius: 20px;
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px); /* Frosted glass effect pada kartu fitur */
}

/* Efek hover pada kartu fitur */
.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    background: rgba(255, 255, 255, 0.15);
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 24px;
    color: white;
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
}

.feature-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 15px;
    color: rgba(255, 255, 255, 0.95);
}

.feature-description {
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.6;
    font-size: 0.95rem;
}

/* Elemen Mengambang di Latar Belakang (floating elements) */
.floating-elements {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none; /* Memastikan elemen ini tidak dapat diklik */
    z-index: 1;
}

.floating-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
    /* Animasi mengambang tak terbatas */
    animation: float 6s ease-in-out infinite;
}

/* Mengatur posisi dan animasi untuk setiap lingkaran */
.floating-circle:nth-child(1) {
    width: 80px; height: 80px; top: 10%; left: 10%; animation-delay: 0s;
}
.floating-circle:nth-child(2) {
    width: 120px; height: 120px; top: 20%; right: 15%; animation-delay: 2s;
}
.floating-circle:nth-child(3) {
    width: 60px; height: 60px; bottom: 15%; left: 20%; animation-delay: 4s;
}
.floating-circle:nth-child(4) {
    width: 100px; height: 100px; bottom: 25%; right: 10%; animation-delay: 1s;
}

/* Keyframes untuk Animasi */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

/* Media Queries untuk Responsif */
@media (max-width: 768px) {
    .welcome-title { font-size: 2.5rem; }
    .welcome-subtitle { font-size: 1.2rem; }
    .carousel-item img { height: 300px; }
    .welcome-section { padding: 30px 20px; }
    .features-grid { grid-template-columns: 1fr; }
    .carousel-control-prev { left: 0; }
    .carousel-control-next { right: 0; }
}

@media (max-width: 480px) {
    .welcome-title { font-size: 2rem; }
}
CSS;
// Mendaftarkan CSS ke dalam halaman
$this->registerCss($css);

// --- JavaScript dengan Keterangan ---
// Script ini juga didefinisikan dalam string heredoc
$js = <<<JS
window.addEventListener('DOMContentLoaded', () => {
    // Menambahkan efek parallax pada elemen yang mengambang
    const handleMouseMove = (e) => {
        const circles = document.querySelectorAll('.floating-circle');
        const mouseX = e.clientX;
        const mouseY = e.clientY;
        
        circles.forEach((circle, index) => {
            const speed = (index + 1) * 0.02; // Setiap lingkaran bergerak dengan kecepatan berbeda
            const x = (mouseX - window.innerWidth / 2) * speed;
            const y = (mouseY - window.innerHeight / 2) * speed;
            
            circle.style.transform = `translate(\${x}px, \${y}px)`;
        });
    };
    
    // Menambahkan event listener untuk pergerakan mouse
    document.addEventListener('mousemove', handleMouseMove);
    
    // Menambahkan perilaku smooth scroll untuk tautan anchor
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
JS;
// Mendaftarkan JavaScript ke dalam halaman
$this->registerJs($js);
?>

<div class="site-index">
    <div class="hero-section">
        <div class="floating-elements">
            <div class="floating-circle"></div>
            <div class="floating-circle"></div>
            <div class="floating-circle"></div>
            <div class="floating-circle"></div>
        </div>

        <div class="hero-content">
            <div class="carousel-container">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?= Yii::getAlias('@web/img/smk 1.jpg') ?>" class="d-block w-100" alt="SMK Muhammadiyah 2 Ajibarang - Gedung Utama">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= Yii::getAlias('@web/img/smk2.jpg') ?>" class="d-block w-100" alt="SMK Muhammadiyah 2 Ajibarang - Fasilitas">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= Yii::getAlias('@web/img/smk3.jpg') ?>" class="d-block w-100" alt="SMK Muhammadiyah 2 Ajibarang - Kegiatan Siswa">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Sebelumnya</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Berikutnya</span>
                    </a>
                </div>
            </div>

            <div class="welcome-section">
                <h1 class="welcome-title">Sistem Jurnal Guru</h1>
                <p class="welcome-subtitle">SMK Muhammadiyah 2 Ajibarang</p>

                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">📚</div>
                        <h3 class="feature-title">Manajemen Jurnal</h3>
                        <p class="feature-description">Kelola jurnal mengajar dengan mudah dan terorganisir.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">👨‍🏫</div>
                        <h3 class="feature-title">Portal Guru</h3>
                        <p class="feature-description">Akses khusus untuk para pendidik SMK Muhammadiyah 2.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h3 class="feature-title">Laporan Digital</h3>
                        <p class="feature-description">Sistem pelaporan yang modern dan efisien.</p>
                    </div>
                </div>

                <div style="margin-top: 40px;">
                    <a href="https://maps.app.goo.gl/AH8QQZM43REHco9K8" target="_blank" class="btn btn-light btn-lg" style="padding: 12px 25px; font-size: 1rem; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); transition: transform 0.3s ease;">
                        📍 Lihat Lokasi Sekolah di Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
```