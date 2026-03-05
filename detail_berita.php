<?php
// Include koneksi database
include 'koneksi.php';

// Ambil slug dari URL
$slug = isset($_GET['slug']) ? mysqli_real_escape_string($conn, $_GET['slug']) : '';

if (empty($slug)) {
    header('Location: berita/index.php');
    exit;
}

// Query untuk mengambil detail berita
$query_berita = "SELECT b.*, k.nama_kategori, k.slug_kategori 
                 FROM berita b 
                 LEFT JOIN kategori_berita k ON b.id_kategori = k.id_kategori 
                 WHERE b.slug_berita = '$slug' 
                 AND b.status_berita = 'publish' 
                 AND b.tanggal_publish <= NOW()";

$result_berita = mysqli_query($conn, $query_berita);
$berita = mysqli_fetch_assoc($result_berita);

// Jika berita tidak ditemukan
if (!$berita) {
    header('Location: berita/index.php');
    exit;
}

// Query untuk mengambil berita terkait
$query_related = "SELECT b.*, k.nama_kategori 
                  FROM berita b 
                  LEFT JOIN kategori_berita k ON b.id_kategori = k.id_kategori 
                  WHERE b.id_kategori = '{$berita['id_kategori']}' 
                  AND b.id_berita != '{$berita['id_berita']}'
                  AND b.status_berita = 'publish' 
                  AND b.tanggal_publish <= NOW() 
                  ORDER BY b.tanggal_publish DESC 
                  LIMIT 3";

$result_related = mysqli_query($conn, $query_related);
$related_news = [];
if ($result_related) {
    while ($row = mysqli_fetch_assoc($result_related)) {
        $related_news[] = $row;
    }
}

// Update jumlah dilihat
$query_update_view = "UPDATE berita SET views_count = views_count + 1 WHERE id_berita = '{$berita['id_berita']}'";
mysqli_query($conn, $query_update_view);
?>

<?php include 'header.php'; ?>

<style>
    /* Styles untuk Halaman Detail Berita */
    .news-detail-page {
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    .page-header {
        background: linear-gradient(rgba(26, 79, 140, 0.85), rgba(26, 79, 140, 0.9)), url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 80px 0 60px;
        text-align: center;
        margin-bottom: 40px;
    }

    .page-header h1 {
        font-size: 32px;
        margin-bottom: 15px;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    /* News Detail Content */
    .news-detail-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .news-detail-image {
        height: 400px;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    .news-detail-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .news-detail-content {
        padding: 30px;
    }

    .news-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #666;
        font-size: 14px;
    }

    .meta-item i {
        color: #1a4f8c;
        font-size: 12px;
    }

    .news-category-badge {
        background: #1a4f8c;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }

    .news-category-badge:hover {
        background: #f8b500;
        color: white;
    }

    .news-detail-title {
        color: #1a4f8c;
        font-size: 28px;
        margin-bottom: 20px;
        line-height: 1.3;
    }

    .news-detail-body {
        color: #333;
        line-height: 1.8;
        font-size: 16px;
    }

    .news-detail-body p {
        margin-bottom: 20px;
    }

    .news-detail-body img {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
        margin: 20px 0;
    }

    .news-detail-body h2, .news-detail-body h3 {
        color: #1a4f8c;
        margin: 30px 0 15px 0;
    }

    .news-detail-body ul, .news-detail-body ol {
        margin-bottom: 20px;
        padding-left: 20px;
    }

    .news-detail-body li {
        margin-bottom: 8px;
    }

    /* Related News */
    .related-news {
        margin-top: 40px;
    }

    .related-news h3 {
        color: #1a4f8c;
        margin-bottom: 20px;
        font-size: 22px;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .related-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s;
    }

    .related-card:hover {
        transform: translateY(-5px);
    }

    .related-image {
        height: 160px;
        overflow: hidden;
    }

    .related-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .related-card:hover .related-image img {
        transform: scale(1.05);
    }

    .related-content {
        padding: 15px;
    }

    .related-content h4 {
        margin-bottom: 8px;
        font-size: 16px;
        line-height: 1.4;
    }

    .related-content h4 a {
        color: #1a4f8c;
        text-decoration: none;
    }

    .related-content h4 a:hover {
        color: #f8b500;
    }

    .related-date {
        font-size: 12px;
        color: #666;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Share Buttons */
    .share-section {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .share-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .share-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .share-facebook {
        background: #3b5998;
        color: white;
    }

    .share-twitter {
        background: #1da1f2;
        color: white;
    }

    .share-whatsapp {
        background: #25d366;
        color: white;
    }

    .share-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        color: white;
    }

    /* Sidebar */
    .news-sidebar {
        background: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
    }

    .sidebar-title {
        color: #1a4f8c;
        font-size: 20px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f8b500;
    }

    .categories-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .categories-list li {
        margin-bottom: 10px;
    }

    .categories-list li a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 12px;
        background: #f8f9fa;
        border-radius: 6px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s;
    }

    .categories-list li a:hover {
        background: #1a4f8c;
        color: white;
    }

    .categories-list li a:hover .count {
        background: white;
        color: #1a4f8c;
    }

    .count {
        background: #1a4f8c;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
    }

    .recent-news-item {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .recent-news-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .recent-news-image {
        width: 70px;
        height: 70px;
        border-radius: 6px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .recent-news-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .recent-news-content {
        flex: 1;
    }

    .recent-news-content h4 {
        margin: 0 0 5px 0;
        font-size: 14px;
        line-height: 1.4;
    }

    .recent-news-content h4 a {
        color: #333;
        text-decoration: none;
    }

    .recent-news-content h4 a:hover {
        color: #1a4f8c;
    }

    .recent-news-date {
        font-size: 11px;
        color: #666;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 24px;
        }
        
        .news-detail-image {
            height: 250px;
        }
        
        .news-detail-title {
            font-size: 22px;
        }
        
        .news-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .related-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="news-detail-page">
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1><?= htmlspecialchars($berita['judul_berita']) ?></h1>
        </div>
    </section>

    <!-- Main Content -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="news-detail-card">
                        <?php if (!empty($berita['gambar_utama'])): ?>
                            <div class="news-detail-image">
                                <img src="uploads/berita/<?= htmlspecialchars($berita['gambar_utama']) ?>" 
                                     alt="<?= htmlspecialchars($berita['judul_berita']) ?>">
                            </div>
                        <?php endif; ?>
                        
                        <div class="news-detail-content">
                            <div class="news-meta">
                                <div class="meta-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?= date('d F Y', strtotime($berita['tanggal_publish'])) ?>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-user"></i>
                                    <!-- Field penulis tidak ada di database, gunakan default -->
                                    Admin Lapas
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-eye"></i>
                                    <?= number_format($berita['views_count'], 0, ',', '.') ?> dilihat
                                </div>
                                <?php if (!empty($berita['nama_kategori'])): ?>
                                    <a href="kategori.php?slug=<?= htmlspecialchars($berita['slug_kategori']) ?>" class="news-category-badge">
                                        <?= htmlspecialchars($berita['nama_kategori']) ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <h1 class="news-detail-title"><?= htmlspecialchars($berita['judul_berita']) ?></h1>
                            
                            <!-- PERBAIKAN: Gunakan isi_berita sesuai database -->
                            <div class="news-detail-body">
                                <?= $berita['isi_berita'] ?>
                            </div>

                            <!-- Share Buttons -->
                            <div class="share-section">
                                <h4>Bagikan Berita:</h4>
                                <div class="share-buttons">
                                    <?php
                                    $current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                    $share_title = urlencode($berita['judul_berita']);
                                    ?>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($current_url) ?>" 
                                       target="_blank" class="share-btn share-facebook">
                                        <i class="fab fa-facebook-f"></i> Facebook
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?text=<?= $share_title ?>&url=<?= urlencode($current_url) ?>" 
                                       target="_blank" class="share-btn share-twitter">
                                        <i class="fab fa-twitter"></i> Twitter
                                    </a>
                                    <a href="https://api.whatsapp.com/send?text=<?= $share_title ?> <?= urlencode($current_url) ?>" 
                                       target="_blank" class="share-btn share-whatsapp">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related News -->
                    <?php if (!empty($related_news)): ?>
                        <div class="related-news">
                            <h3>Berita Terkait</h3>
                            <div class="related-grid">
                                <?php foreach ($related_news as $related): ?>
                                    <div class="related-card">
                                        <?php if (!empty($related['gambar_utama'])): ?>
                                            <div class="related-image">
                                                <img src="uploads/berita/<?= htmlspecialchars($related['gambar_utama']) ?>" 
                                                     alt="<?= htmlspecialchars($related['judul_berita']) ?>">
                                            </div>
                                        <?php endif; ?>
                                        <div class="related-content">
                                            <h4>
                                                <a href="detail_berita.php?slug=<?= htmlspecialchars($related['slug_berita']) ?>">
                                                    <?= htmlspecialchars($related['judul_berita']) ?>
                                                </a>
                                            </h4>
                                            <div class="related-date">
                                                <i class="fas fa-calendar-alt"></i>
                                                <?= date('d M Y', strtotime($related['tanggal_publish'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Categories Widget -->
                    <div class="news-sidebar">
                        <h3 class="sidebar-title">Kategori Berita</h3>
                        <ul class="categories-list">
                            <?php
                            $query_kategori = "SELECT k.*, COUNT(b.id_berita) as jumlah_berita 
                                             FROM kategori_berita k 
                                             LEFT JOIN berita b ON k.id_kategori = b.id_kategori 
                                             AND b.status_berita = 'publish'
                                             AND b.tanggal_publish <= NOW()
                                             GROUP BY k.id_kategori 
                                             ORDER BY k.nama_kategori";
                            $result_kategori = mysqli_query($conn, $query_kategori);
                            while ($kategori = mysqli_fetch_assoc($result_kategori)):
                            ?>
                                <li>
                                    <a href="kategori.php?slug=<?= htmlspecialchars($kategori['slug_kategori']) ?>">
                                        <?= htmlspecialchars($kategori['nama_kategori']) ?>
                                        <span class="count"><?= $kategori['jumlah_berita'] ?></span>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>

                    <!-- Recent News Widget -->
                    <div class="news-sidebar">
                        <h3 class="sidebar-title">Berita Terbaru</h3>
                        <?php
                        $query_recent = "SELECT judul_berita, slug_berita, gambar_utama, tanggal_publish 
                                       FROM berita 
                                       WHERE status_berita = 'publish' 
                                       AND tanggal_publish <= NOW() 
                                       ORDER BY tanggal_publish DESC 
                                       LIMIT 5";
                        $result_recent = mysqli_query($conn, $query_recent);
                        while ($recent = mysqli_fetch_assoc($result_recent)):
                        ?>
                            <div class="recent-news-item">
                                <div class="recent-news-image">
                                    <?php if (!empty($recent['gambar_utama'])): ?>
                                        <img src="uploads/berita/<?= htmlspecialchars($recent['gambar_utama']) ?>" 
                                             alt="<?= htmlspecialchars($recent['judul_berita']) ?>">
                                    <?php else: ?>
                                        <img src="https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                                             alt="Default News Image">
                                    <?php endif; ?>
                                </div>
                                <div class="recent-news-content">
                                    <h4>
                                        <a href="detail_berita.php?slug=<?= htmlspecialchars($recent['slug_berita']) ?>">
                                            <?= htmlspecialchars(mb_substr($recent['judul_berita'], 0, 50)) ?><?= strlen($recent['judul_berita']) > 50 ? '...' : '' ?>
                                        </a>
                                    </h4>
                                    <div class="recent-news-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        <?= date('d M Y', strtotime($recent['tanggal_publish'])) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>