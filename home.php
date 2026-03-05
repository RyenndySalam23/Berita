<?php 
// Include koneksi database
include 'koneksi.php';

// Query untuk mengambil 3 berita terbaru
$query_berita = "SELECT b.*, k.nama_kategori 
                 FROM berita b 
                 LEFT JOIN kategori_berita k ON b.id_kategori = k.id_kategori 
                 WHERE b.status_berita = 'publish' 
                 AND b.tanggal_publish <= NOW() 
                 ORDER BY b.tanggal_publish DESC 
                 LIMIT 3";

$result_berita = mysqli_query($conn, $query_berita);
$berita = [];
if ($result_berita) {
    while ($row = mysqli_fetch_assoc($result_berita)) {
        $berita[] = $row;
    }
}
?>

<?php include 'header.php'; ?>

<style>
    /* Additional Styles untuk Home Page */
    /* Hero Section */
    .hero {
        background: linear-gradient(rgba(26, 79, 140, 0.98), rgba(0, 0, 0, 0.9)), url('assets/img/LPgedung32 (1).png');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 80px 0;
        text-align: center;
        position: relative;
    }

    .hero::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60px;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.1));
    }

    .hero h2 {
        font-size: 32px;
        margin-bottom: 15px;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .hero p {
        font-size: 16px;
        max-width: 700px;
        margin: 0 auto 25px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }

    .hero-buttons {
        display: flex;
        justify-content: center;
        gap: 12px;
    }

    /* About Section */
    .about {
        background-color: white;
    }

    .about-content {
        display: flex;
        align-items: center;
        gap: 30px;
    }

    .about-image {
        flex: 1;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .about-image img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.5s;
    }

    .about-image:hover img {
        transform: scale(1.03);
    }

    .about-text {
        flex: 1;
    }

    .about-text h3 {
        font-size: 24px;
        color: var(--primary);
        margin-bottom: 15px;
    }

    .about-text p {
        margin-bottom: 12px;
        color: var(--gray);
    }

    /* Services Section */
    .services {
        background-color: #f8f9fa;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
    }

    .service-card {
        background-color: white;
        border-radius: 6px;
        padding: 25px 15px;
        text-align: center;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s;
    }

    .service-card:hover {
        transform: translateY(-8px);
    }

    .service-icon {
        font-size: 35px;
        color: var(--primary);
        margin-bottom: 15px;
    }

    .service-card h3 {
        margin-bottom: 12px;
        color: var(--primary);
        font-size: 18px;
    }

    /* News Section */
    .news {
        background-color: white;
    }

    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
    }

    .news-card {
        background-color: white;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s;
    }

    .news-card:hover {
        transform: translateY(-5px);
    }

    .news-image {
        height: 180px;
        overflow: hidden;
        background-color: #f8f9fa;
        position: relative;
    }

    .news-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .news-card:hover .news-image img {
        transform: scale(1.05);
    }

    .news-content {
        padding: 15px;
    }

    .news-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 8px;
        font-size: 12px;
        color: var(--gray);
        flex-wrap: wrap;
    }

    .news-date, .news-views {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .news-date i, .news-views i {
        color: var(--primary);
        font-size: 11px;
    }

    .news-content h3 {
        margin-bottom: 8px;
        color: var(--primary);
        font-size: 16px;
        line-height: 1.4;
        min-height: 45px;
    }

    .news-content p {
        color: var(--gray);
        margin-bottom: 12px;
        font-size: 14px;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .read-more {
        color: var(--primary);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        font-size: 14px;
        text-decoration: none;
    }

    .read-more i {
        margin-left: 4px;
        transition: transform 0.3s;
        font-size: 12px;
    }

    .read-more:hover i {
        transform: translateX(3px);
    }

    .no-news {
        grid-column: 1 / -1;
        text-align: center;
        padding: 40px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .no-news i {
        font-size: 48px;
        color: var(--gray);
        margin-bottom: 15px;
    }

    /* Statistics Section */
    .statistics {
        background: linear-gradient(rgba(26, 79, 140, 0.9), rgba(26, 79, 140, 0.9)), url('https://images.unsplash.com/photo-1551135049-8a33b5883817?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
        background-size: cover;
        background-position: center;
        color: white;
        text-align: center;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 25px;
    }

    .stat-item {
        padding: 15px;
    }

    .stat-number {
        font-size: 40px;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--secondary);
    }

    .stat-text {
        font-size: 16px;
    }

    /* Contact Section */
    .contact {
        background-color: #f8f9fa;
    }

    .contact-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }

    .contact-info {
        padding: 10px;
        border-radius: 6px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .contact-info h3 {
        color: var(--primary);
        margin-bottom: 15px;
        font-size: 20px;
    }

    .contact-details {
        margin-bottom: 25px;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .contact-item i {
        color: var(--primary);
        margin-right: 8px;
        margin-top: 3px;
        font-size: 14px;
    }

    .map-container {
        height: 280px;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .map-container iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    /* Responsive untuk Home Content */
    @media (max-width: 768px) {
        .hero h2 {
            font-size: 26px;
        }
        
        .hero p {
            font-size: 14px;
        }
        
        .hero-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .btn {
            width: 100%;
            max-width: 220px;
            margin-bottom: 8px;
        }

        .about-content {
            flex-direction: column;
        }

        .news-meta {
            gap: 10px;
        }
    }

    @media (max-width: 576px) {
        .section-title h2 {
            font-size: 22px;
        }

        .section-title1 h2 {
            font-size: 22px;
            color: #f8f9fa;
        }

        
        .stat-number {
            font-size: 32px;
        }
        
        .news-grid {
            grid-template-columns: 1fr;
        }

        .news-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h2>Selamat Datang di Lapas Kelas IIA Garut</h2>
        <p>Lembaga Pemasyarakatan yang berkomitmen untuk melakukan pembinaan dan pemberdayaan Warga Binaan dengan pendekatan humanis dan integratif.</p>
        <div class="hero-buttons">
            <a href="https://lasgar.org" class="btn btn-primary">Informasi Kunjungan</a>
            <a href="#" class="btn btn-secondary">Program Pembinaan</a>
            <a href="https://lasgar.org/informasi-pengaduan" class="btn btn-accent">Pengaduan Masyarakat</a>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about section-padding">
    <div class="container">
        <div class="section-title">
            <h2>Tentang Lapas Garut</h2>
            <p>Profil singkat Lembaga Pemasyarakatan Kelas IIA Garut</p>
        </div>
        <div class="about-content">
            <div class="about-image">
                <img src="assets/img/LPgedung32 (1).png" alt="Gedung Lapas Garut">
            </div>
            <div class="about-text">
                <h3>Lapas Kelas IIA Garut</h3>
                <p>Lapas Kelas IIA Garut merupakan unit pelaksana teknis di bawah Direktorat Jenderal Pemasyarakatan, Kementerian Hukum dan HAM RI yang berlokasi di Jalan Raya Cikajang No. 123, Garut, Jawa Barat.</p>
                <p>Lapas ini memiliki kapasitas tampung hingga 500 Warga Binaan dan menyelenggarakan berbagai program pembinaan untuk mempersiapkan reintegrasi sosial Warga Binaan ke masyarakat.</p>
                <p>Dengan motto "Membina, Mendidik, dan Memberdayakan", Lapas Garut berkomitmen untuk menjalankan tugas dengan prinsip profesionalisme, transparansi, dan akuntabilitas.</p>
                <a href="#" class="btn btn-primary" style="margin-top: 15px;">Selengkapnya</a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services section-padding">
    <div class="container">
        <div class="section-title">
            <h2>Layanan Kami</h2>
            <p>Berbagai layanan yang disediakan oleh Lapas Kelas IIA Garut</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Kunjungan Keluarga</h3>
                <p>Layanan kunjungan keluarga bagi Warga Binaan dengan jadwal dan prosedur yang telah ditetapkan.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>Pembinaan Kepribadian</h3>
                <p>Program pembinaan untuk mengembangkan kepribadian dan karakter Warga Binaan.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3>Pelatihan Keterampilan</h3>
                <p>Berbagai pelatihan keterampilan untuk mempersiapkan Warga Binaan kembali ke masyarakat.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-balance-scale"></i>
                </div>
                <h3>Bantuan Hukum</h3>
                <p>Fasilitas bantuan hukum bagi Warga Binaan yang membutuhkan pendampingan hukum.</p>
            </div>
        </div>
    </div>
</section>

<!-- News Section -->
<section class="news section-padding">
    <div class="container">
        <div class="section-title">
            <h2>Berita & Pengumuman</h2>
            <p>Informasi terbaru seputar kegiatan dan pengumuman Lapas Garut</p>
        </div>
        <div class="news-grid">
            <?php if (empty($berita)): ?>
                <div class="no-news">
                    <i class="fas fa-newspaper"></i>
                    <h3>Belum Ada Berita</h3>
                    <p>Silakan periksa kembali nanti untuk berita terbaru.</p>
                </div>
            <?php else: ?>
                <?php foreach ($berita as $item): ?>
                <div class="news-card">
                    <div class="news-image">
                        <?php if (!empty($item['gambar_utama'])): ?>
                            <img src="uploads/berita/<?= htmlspecialchars($item['gambar_utama']) ?>" 
                                 alt="<?= htmlspecialchars($item['judul_berita']) ?>">
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                                 alt="Default News Image">
                        <?php endif; ?>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <div class="news-date">
                                <i class="fas fa-calendar-alt"></i>
                                <?= date('d M Y', strtotime($item['tanggal_publish'])) ?>
                            </div>
                            <div class="news-views">
                                <i class="fas fa-eye"></i>
                                <?= number_format($item['views_count'], 0, ',', '.') ?> dilihat
                            </div>
                        </div>
                        <h3><?= htmlspecialchars($item['judul_berita']) ?></h3>
                        <p><?= htmlspecialchars($item['ringkasan']) ?></p>
                        <a href="detail_berita.php?slug=<?= htmlspecialchars($item['slug_berita']) ?>" class="read-more">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Link ke halaman berita lengkap -->
        <?php if (!empty($berita)): ?>
        <div class="text-center mt-4">
            <a href="index_berita.php" class="btn btn-primary">
                <i class="fas fa-list me-2"></i>Lihat Semua Berita
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Statistics Section -->
<section class="statistics section-padding">
    <div class="container">
        <div class="section-title1">
            <h2>Statistik Lapas Garut</h2>
            <p>Data terkini mengenai Warga Binaan dan kegiatan di Lapas Garut</p>
        </div>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">485</div>
                <div class="stat-text">Warga Binaan</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24</div>
                <div class="stat-text">Petugas Lapas</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">15</div>
                <div class="stat-text">Program Pembinaan</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">92%</div>
                <div class="stat-text">Tingkat Kepuasan Layanan</div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact section-padding">
    <div class="container">
        <div class="section-title">
            <h2>Kontak & Lokasi</h2>
            <p>Informasi kontak dan lokasi Lapas Kelas IIA Garut</p>
        </div>
        <div class="contact-content">
            <div class="contact-info">
                <h3>Kontak Kami</h3>
                <div class="contact-details">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Jl. KH. Hasan Arif, Banyuresmi, Kabupaten Garut, Jawa Barat, kode pos 44191</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+62......</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>info@lapasgarut.go.id</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <span>Senin - Jumat: 08.00 - 16.00 WIB</span>
                    </div>
                </div>
                <h3>Jadwal Kunjungan</h3>
                <div class="contact-details">
                    <div class="contact-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Keluarga: Selasa & Kamis (09.00 - 14.00 WIB)</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Umum: Rabu (10.00 - 12.00 WIB)</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Pengacara: Setiap hari kerja</span>
                    </div>
                </div>
            </div>
            <div class="map-container">
                <iframe src="https://maps.google.com/maps?q=Lembaga%20Pemasyarakatan%20Kelas%20IIA%20Garut&t=&z=15&ie=UTF8&iwloc=&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>  
    </div>
</section>

<!-- Tambahkan script ini sebelum penutup body -->
<script>
    // Fungsi untuk animasi statistik
    function animateStatistics() {
        const statItems = document.querySelectorAll('.stat-item');
        
        // Nilai akhir untuk setiap statistik
        const finalValues = {
            0: 485,   // Warga Binaan
            1: 24,    // Petugas Lapas
            2: 15,    // Program Pembinaan
            3: 92     // Tingkat Kepuasan Layanan (%)
        };
        
        // Durasi animasi dalam milidetik
        const duration = 2000;
        // Interval waktu untuk update
        const interval = 50;
        
        statItems.forEach((item, index) => {
            const statNumber = item.querySelector('.stat-number');
            const finalValue = finalValues[index];
            const increment = finalValue / (duration / interval);
            let currentValue = 0;
            
            // Fungsi untuk memperbarui angka
            const updateNumber = () => {
                currentValue += increment;
                if (currentValue >= finalValue) {
                    currentValue = finalValue;
                    // Tambahkan simbol % untuk statistik terakhir
                    if (index === 3) {
                        statNumber.textContent = Math.floor(currentValue) + '%';
                    } else {
                        statNumber.textContent = Math.floor(currentValue);
                    }
                    return;
                }
                
                // Tambahkan simbol % untuk statistik terakhir
                if (index === 3) {
                    statNumber.textContent = Math.floor(currentValue) + '%';
                } else {
                    statNumber.textContent = Math.floor(currentValue);
                }
                
                setTimeout(updateNumber, interval);
            };
            
            // Mulai animasi
            updateNumber();
        });
    }

    // Fungsi untuk memeriksa apakah elemen berada dalam viewport
    function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Fungsi untuk menangani scroll dan memicu animasi
    function handleScroll() {
        const statisticsSection = document.querySelector('.statistics');
        
        if (isElementInViewport(statisticsSection) && !statisticsSection.classList.contains('animated')) {
            statisticsSection.classList.add('animated');
            animateStatistics();
        }
    }

    // Event listener untuk scroll
    window.addEventListener('scroll', handleScroll);

    // Juga cek saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah section statistik sudah terlihat saat halaman dimuat
        handleScroll();
        
        // Juga tambahkan fallback: jika setelah 1 detik belum terlihat, tetap jalankan animasi
        setTimeout(function() {
            const statisticsSection = document.querySelector('.statistics');
            if (!statisticsSection.classList.contains('animated')) {
                statisticsSection.classList.add('animated');
                animateStatistics();
            }
        }, 1000);
    });
</script>

<?php include 'footer.php'; ?>
