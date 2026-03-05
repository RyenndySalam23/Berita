<?php 
// Include koneksi database
include 'koneksi.php';

// Konfigurasi pagination
$limit = 6; // Jumlah berita per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk menghitung total berita
$query_count = "SELECT COUNT(*) as total FROM berita 
                WHERE status_berita = 'publish' 
                AND tanggal_publish <= NOW()";
$result_count = mysqli_query($conn, $query_count);
$total_berita = mysqli_fetch_assoc($result_count)['total'];
$total_pages = ceil($total_berita / $limit);

// Query untuk mengambil berita dengan pagination
$query_berita = "SELECT b.*, k.nama_kategori 
                 FROM berita b 
                 LEFT JOIN kategori_berita k ON b.id_kategori = k.id_kategori 
                 WHERE b.status_berita = 'publish' 
                 AND b.tanggal_publish <= NOW() 
                 ORDER BY b.tanggal_publish DESC 
                 LIMIT $limit OFFSET $offset";

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
    /* Additional Styles untuk Halaman Berita */
    .news-page {
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    .page-header {
        background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(26, 79, 140, 0.9)), url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 80px 0 60px;
        text-align: center;
        margin-bottom: 40px;
    }

    .page-header h1 {
        font-size: 36px;
        margin-bottom: 15px;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .page-header p {
        font-size: 18px;
        max-width: 600px;
        margin: 0 auto;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }

    /* News Grid Layout */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .news-card {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .news-image {
        height: 220px;
        overflow: hidden;
        background-color: #f8f9fa;
        position: relative;
    }

    .news-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .news-card:hover .news-image img {
        transform: scale(1.1);
    }

    .news-category {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--primary);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .news-content {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .news-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 12px;
        font-size: 13px;
        color: var(--gray);
        flex-wrap: wrap;
    }

    .news-content h3 {
        margin-bottom: 12px;
        color: var(--primary);
        font-size: 18px;
        line-height: 1.4;
        flex-grow: 1;
    }

    .news-content p {
        color: var(--gray);
        margin-bottom: 15px;
        font-size: 14px;
        line-height: 1.6;
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
        margin-top: auto;
    }

    .read-more i {
        margin-left: 6px;
        transition: transform 0.3s;
        font-size: 12px;
    }

    .read-more:hover i {
        transform: translateX(4px);
    }

    /* Pagination */
    .pagination {
        justify-content: center;
        margin-top: 40px;
    }

    .page-link {
        color: var(--primary);
        border: 1px solid #dee2e6;
        padding: 8px 16px;
        margin: 0 4px;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.3s;
    }

    .page-link:hover {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }

    /* No News State */
    .no-news {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 40px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .no-news i {
        font-size: 64px;
        color: var(--gray);
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .no-news h3 {
        color: var(--primary);
        margin-bottom: 10px;
    }

    .no-news p {
        color: var(--gray);
        margin-bottom: 20px;
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
        color: var(--primary);
        font-size: 20px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--secondary);
    }

    .categories-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .categories-list li {
        margin-bottom: 8px;
    }

    .categories-list a {
        color: var(--gray);
        text-decoration: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        transition: color 0.3s;
    }

    .categories-list a:hover {
        color: var(--primary);
    }

    .categories-list .count {
        background: var(--secondary);
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
    }

    /* Recent News Sidebar */
    .recent-news-item {
        display: flex;
        gap: 12px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .recent-news-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .recent-news-image {
        width: 60px;
        height: 60px;
        border-radius: 6px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .recent-news-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .recent-news-content h4 {
        margin: 0 0 5px 0;
        font-size: 14px;
        line-height: 1.3;
    }

    .recent-news-content h4 a {
        color: var(--primary);
        text-decoration: none;
    }

    .recent-news-content h4 a:hover {
        color: var(--secondary);
    }

    .recent-news-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 11px;
        color: var(--gray);
    }

    .recent-news-date {
        display: flex;
        align-items: center;
        gap: 3px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 28px;
        }
        
        .page-header p {
            font-size: 16px;
        }
        
        .news-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .news-content {
            padding: 20px;
        }
        
        .news-image {
            height: 200px;
        }
        
        .news-meta {
            gap: 10px;
        }
    }

    @media (max-width: 576px) {
        .page-header {
            padding: 60px 0 40px;
        }
        
        .news-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        
        .pagination {
            flex-wrap: wrap;
        }
        
        .page-link {
            padding: 6px 12px;
            font-size: 14px;
        }
        
        .recent-news-meta {
            flex-direction: column;
            gap: 3px;
        }
    }
</style>

<div class="news-page">
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Berita & Pengumuman</h1>
            <p>Informasi terbaru seputar kegiatan dan pengumuman Lapas Kelas IIA Garut</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <!-- Main News Content -->
                <div class="col-lg-9">
                    <?php if (empty($berita)): ?>
                        <div class="no-news">
                            <i class="fas fa-newspaper"></i>
                            <h3>Belum Ada Berita</h3>
                            <p>Silakan periksa kembali nanti untuk berita terbaru.</p>
                            <a href="home.php" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="news-grid">
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
                                    <?php if (!empty($item['nama_kategori'])): ?>
                                        <span class="news-category"><?= htmlspecialchars($item['nama_kategori']) ?></span>
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
                        </div>

                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($page < $total_pages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-3">
                    <!-- Categories Widget -->
                    <div class="news-sidebar">
                        <h3 class="sidebar-title">Kategori Berita</h3>
                        <ul class="categories-list">
                            <?php
                            // Query untuk mengambil kategori
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
                        $query_recent = "SELECT judul_berita, slug_berita, gambar_utama, tanggal_publish, views_count
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
                                    <div class="recent-news-meta">
                                        <div class="recent-news-date">
                                            <i class="fas fa-calendar-alt"></i>
                                            <?= date('d M Y', strtotime($recent['tanggal_publish'])) ?>
                                        </div>
                                        <div class="recent-news-views">
                                            <i class="fas fa-eye"></i>
                                            <?= number_format($recent['views_count'], 0, ',', '.') ?>
                                        </div>
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
