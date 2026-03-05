<?php
include "koneksi.php";
$pageTitle = "Sejarah Lapas Garut";
?>
    <?php include 'header.php'; ?>
<body>

<style>
    /* Styles untuk Halaman Sejarah - Timeline Version */
    .history-page {
        background-color: #f8f9fa;
        min-height: 100vh;
        margin-top: 0;
        padding-top: 0;
    }

    .page-header {
        background: linear-gradient(rgba(26, 79, 140, 0.95), rgba(26, 79, 140, 0.98)), url('https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 100px 0 80px;
        text-align: center;
        margin-bottom: 50px;
        margin-top: 0;
    }

    .page-header h1 {
        font-size: 42px;
        margin-bottom: 20px;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .page-header p {
        font-size: 18px;
        max-width: 700px;
        margin: 0 auto;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }

    /* Timeline */
    .timeline {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 0;
    }

    .timeline::after {
        content: '';
        position: absolute;
        width: 6px;
        background-color: #1a4f8c;
        top: 0;
        bottom: 0;
        left: 50%;
        margin-left: -3px;
    }

    .timeline-item {
        padding: 10px 40px;
        position: relative;
        width: 50%;
        box-sizing: border-box;
    }

    .timeline-item:nth-child(odd) {
        left: 0;
    }

    .timeline-item:nth-child(even) {
        left: 50%;
    }

    .timeline-content {
        padding: 20px 30px;
        background-color: white;
        position: relative;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s;
    }

    .timeline-content:hover {
        transform: translateY(-5px);
    }

    .timeline-item:nth-child(odd) .timeline-content::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        right: -10px;
        background-color: white;
        top: 30px;
        border-radius: 50%;
        z-index: 1;
        box-shadow: 0 0 0 4px #1a4f8c;
    }

    .timeline-item:nth-child(even) .timeline-content::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        left: -10px;
        background-color: white;
        top: 30px;
        border-radius: 50%;
        z-index: 1;
        box-shadow: 0 0 0 4px #1a4f8c;
    }

    .timeline-year {
        font-weight: 700;
        font-size: 24px;
        color: #1a4f8c;
        margin-bottom: 10px;
    }

    .timeline-title {
        font-weight: 600;
        font-size: 20px;
        margin-bottom: 15px;
        color: #343a40;
    }

    /* History Sections */
    .history-section {
        padding: 60px 0;
    }

    .section-title {
        color: #1a4f8c;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 30px;
        text-align: center;
        position: relative;
    }

    .section-title::after {
        content: '';
        display: block;
        width: 80px;
        height: 4px;
        background: #f8b500;
        margin: 15px auto;
        border-radius: 2px;
    }

    .card-custom {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .card-custom:hover {
        transform: translateY(-10px);
    }

    .card-header-custom {
        background: linear-gradient(135deg, #1a4f8c, #14417c);
        color: white;
        padding: 20px;
        border-bottom: none;
    }

    .card-header-custom h3 {
        margin: 0;
        font-size: 22px;
    }

    .card-body-custom {
        padding: 25px;
    }

    .mission-vision {
        background-color: white;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        margin: 40px 0;
    }

    .mission-vision h3 {
        color: #1a4f8c;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .mission-vision ul {
        padding-left: 20px;
    }

    .mission-vision li {
        margin-bottom: 10px;
    }

    .current-info {
        background: linear-gradient(135deg, #1a4f8c, #14417c);
        color: white;
        padding: 60px 0;
        margin-top: 50px;
        text-align: center;
    }

    .current-info h2 {
        font-size: 32px;
        margin-bottom: 30px;
    }

    .stat-item {
        margin-bottom: 30px;
    }

    .stat-number {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .stat-label {
        font-size: 18px;
        opacity: 0.9;
    }

    .back-button {
        background-color: #1a4f8c;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        margin-bottom: 20px;
    }

    .back-button:hover {
        background-color: #14417c;
        color: white;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media screen and (max-width: 768px) {
        .timeline::after {
            left: 31px;
        }

        .timeline-item {
            width: 100%;
            padding-left: 70px;
            padding-right: 25px;
        }

        .timeline-item:nth-child(even) {
            left: 0;
        }

        .timeline-item:nth-child(odd) .timeline-content::after,
        .timeline-item:nth-child(even) .timeline-content::after {
            left: 21px;
        }

        .page-header h1 {
            font-size: 32px;
        }

        .page-header {
            padding: 80px 0 60px;
        }
    }
</style>

<div class="history-page">
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Sejarah Lapas Garut</h1>
            <p>Melacak perjalanan panjang Lembaga Pemasyarakatan Garut sejak tahun 1918 hingga menjadi institusi pemasyarakatan modern</p>
        </div>
    </section>

    <!-- Timeline Section -->
    <section class="history-section">
        <div class="container">
            <h2 class="section-title">Garis Waktu Sejarah</h2>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-year">1918</div>
                        <h3 class="timeline-title">Pendirian oleh Pemerintah Kolonial Belanda</h3>
                        <p>Lapas Garut didirikan oleh pemerintah kolonial Belanda dengan nama Lembaga Pemasyarakatan Lowokwaru. Awalnya berfungsi sebagai penjara untuk menahan tahanan politik yang menentang pemerintahan kolonial.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-year">1945</div>
                        <h3 class="timeline-title">Era Pasca Kemerdekaan</h3>
                        <p>Setelah Indonesia merdeka, fungsi lapas diperluas untuk menampung tahanan dengan berbagai tingkat kejahatan. Nama diubah menjadi Lembaga Pemasyarakatan Garut seiring dengan perubahan sistem pemasyarakatan nasional.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-year">1970-an</div>
                        <h3 class="timeline-title">Masa Transisi dan Peran Khusus</h3>
                        <p>Lapas Garut sempat digunakan sebagai tempat perawatan bagi para korban peristiwa G-30-S/PKI. Periode ini menjadi babak penting dalam sejarah lapas dengan peran kemanusiaan yang diembannya.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-year">2000-an</div>
                        <h3 class="timeline-title">Modernisasi dan Rehabilitasi</h3>
                        <p>Lapas Garut mengalami transformasi signifikan dengan penerapan sistem pemasyarakatan modern yang berfokus pada rehabilitasi dan reintegrasi sosial. Berbagai program pelatihan dan pembinaan diperkenalkan.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-year">Sekarang</div>
                        <h3 class="timeline-title">Era Kontemporer</h3>
                        <p>Lapas Garut kini menjadi institusi pemasyarakatan dengan kapasitas lebih dari 3000 orang dan menjalankan berbagai program rehabilitasi untuk membantu narapidana kembali menjadi warga negara yang produktif.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed History Section -->
    <section class="history-section">
        <div class="container">
            <h2 class="section-title">Sejarah Lengkap Lapas Garut</h2>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card-custom">
                        <div class="card-header-custom">
                            <h3><i class="fas fa-landmark me-2"></i> Era Kolonial Belanda</h3>
                        </div>
                        <div class="card-body-custom">
                            <p>Lapas Garut didirikan pada tahun 1918 oleh pemerintah kolonial Belanda dengan nama Lembaga Pemasyarakatan Lowokwaru. Pada masa ini, fungsi utama lembaga adalah sebagai penjara untuk menahan tahanan politik yang dianggap membahayakan pemerintahan kolonial.</p>
                            <p>Arsitektur bangunan masih mengikuti gaya kolonial dengan sistem keamanan yang ketat. Kondisi tahanan pada masa ini sangat keras dengan fokus pada penghukuman daripada pembinaan.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card-custom">
                        <div class="card-header-custom">
                            <h3><i class="fas fa-flag me-2"></i> Masa Awal Kemerdekaan</h3>
                        </div>
                        <div class="card-body-custom">
                            <p>Setelah Indonesia merdeka pada tahun 1945, Lapas Garut mengalami perubahan signifikan dalam sistem dan tujuannya. Fungsi lembaga diperluas tidak hanya untuk tahanan politik tetapi juga untuk menampung tahanan dengan berbagai jenis kejahatan.</p>
                            <p>Nama diubah menjadi Lembaga Pemasyarakatan Garut seiring dengan perubahan paradigma dari sistem kepenjaraan ke sistem pemasyarakatan yang lebih manusiawi.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card-custom">
                        <div class="card-header-custom">
                            <h3><i class="fas fa-history me-2"></i> Periode 1970-an</h3>
                        </div>
                        <div class="card-body-custom">
                            <p>Pada tahun 1970-an, Lapas Garut memiliki peran khusus dalam sejarah Indonesia ketika digunakan sebagai tempat penampungan sementara bagi para korban peristiwa G-30-S/PKI. Periode ini menjadi babak penting dengan tantangan kemanusiaan yang kompleks.</p>
                            <p>Lembaga ini berperan tidak hanya sebagai tempat pembinaan tetapi juga sebagai tempat rehabilitasi sosial bagi mereka yang terlibat dalam peristiwa tersebut.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card-custom">
                        <div class="card-header-custom">
                            <h3><i class="fas fa-sync-alt me-2"></i> Transformasi Modern</h3>
                        </div>
                        <div class="card-body-custom">
                            <p>Sejak tahun 2000-an, Lapas Garut mengalami transformasi besar-besaran menuju sistem pemasyarakatan modern. Fokus bergeser dari sekadar penghukuman menjadi rehabilitasi dan reintegrasi sosial.</p>
                            <p>Berbagai program pembinaan diperkenalkan, termasuk pelatihan keterampilan, pendidikan formal, dan konseling keagamaan untuk mempersiapkan narapidana kembali ke masyarakat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="history-section">
        <div class="container">
            <div class="mission-vision">
                <h2 class="section-title">Visi dan Misi Lapas Garut</h2>
                
                <div class="row">
                    <div class="col-md-6">
                        <h3><i class="fas fa-eye me-2" style="color: #1a4f8c;"></i> Visi</h3>
                        <p>Menjadi lembaga pemasyarakatan modern yang efektif dalam melakukan pembinaan, rehabilitasi, dan reintegrasi sosial warga binaan untuk menciptakan masyarakat yang aman, tertib, dan sejahtera.</p>
                    </div>
                    
                    <div class="col-md-6">
                        <h3><i class="fas fa-bullseye me-2" style="color: #1a4f8c;"></i> Misi</h3>
                        <ul>
                            <li>Melaksanakan sistem pemasyarakatan yang manusiawi dan berkeadilan</li>
                            <li>Menyelenggarakan pembinaan narapidana secara komprehensif</li>
                            <li>Mengembangkan program rehabilitasi yang efektif</li>
                            <li>Mempersiapkan warga binaan untuk reintegrasi sosial yang sukses</li>
                            <li>Menjalin kemitraan dengan masyarakat dan stakeholders</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Current Information Section -->
    <section class="current-info">
        <div class="container">
            <h2>Lapas Garut Saat Ini</h2>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-number">3000+</div>
                        <div class="stat-label">Kapasitas Warga Binaan</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-number">100+</div>
                        <div class="stat-label">Program Rehabilitasi</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Tenaga Pembina</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-number">1918</div>
                        <div class="stat-label">Tahun Berdiri</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>