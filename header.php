<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapas Kelas IIA Garut - Lembaga Pemasyarakatan Garut</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset dan Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary: #00254bff;
            --secondary: #d4af37;
            --accent: #8b0000;
            --dark: #333;
            --light: #f8f9fa;
            --gray: #6c757d;
            --header-blue: #1a4f8c;
            --header-dark-blue: #0d3a6b;
        }

        body {
            background-color: #f5f5f5;
            color: var(--dark);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: #0d3a6b;
        }

        .btn-secondary {
            background-color: var(--secondary);
            color: var(--dark);
        }

        .btn-secondary:hover {
            background-color: #c19b1e;
        }

        .btn-accent {
            background-color: var(--accent);
            color: white;
        }

        .btn-accent:hover {
            background-color: #690000;
        }

        .section-padding {
            padding: 60px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title h2 {
            font-size: 32px;
            color: var(--primary);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--secondary);
        }

        .section-title p {
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto;
        }

        /* Header Styles - Warna Biru */
        header {
            background: linear-gradient(rgba(6, 22, 40, 0.9), rgba(7, 41, 81, 0.9));
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .main-header {
            padding: 10px 0;
            background: transparent;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            transition: transform 0.3s;
        }

        .logo:hover {
            transform: scale(1.02);
        }

        .logo img {
            height: 60px;
            margin-right: 12px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-text h1 {
            font-size: 20px;
            color: white;
            margin-bottom: 2px;
            line-height: 1.2;
            font-weight: 700;
        }

        .logo-text p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2px;
        }

        .logo-text .subtitle {
            font-size: 10px;
            color: var(--secondary);
            font-weight: 600;
        }

        /* Navigation - Warna Biru */
        nav {
            background: transparent;
            position: relative;
        }

        nav::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--secondary) 0%, var(--accent) 100%);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-links {
            display: flex;
        }

        .nav-links li {
            position: relative;
        }

        .nav-links a {
            color: white;
            padding: 14px 16px;
            display: block;
            font-weight: 500;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            font-size: 14px;
        }

        .nav-links a::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--secondary);
            transition: width 0.3s;
        }

        .nav-links a:hover::before,
        .nav-links a.active::before {
            width: 100%;
        }

        .nav-links a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--secondary);
        }

        .nav-links .fa-chevron-down {
            font-size: 10px;
            margin-left: 4px;
            transition: transform 0.3s;
        }

        .nav-links li:hover .fa-chevron-down {
            transform: rotate(180deg);
        }

        .dropdown {
            position: absolute;
            background: linear-gradient(rgba(6, 22, 40, 0.9), rgba(7, 41, 81, 0.9));
            min-width: 200px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            z-index: 100;
            border-radius: 0 0 6px 6px;
            overflow: hidden;
            transform: translateY(8px);
        }

        .nav-links li:hover .dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown a {
            color: var(--dark); 
            padding: 10px 16px;
            border-bottom: 1px solid #000000ff;
            transition: all 0.3s;
            font-size: 13px;
        }

        .dropdown a:hover {
            background-color: #f8f9fa;
            color: var(--primary);
            padding-left: 20px;
        }

        .dropdown a::before {
            display: none;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .mobile-menu-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Header dan Navbar yang Digabungkan - Warna Biru */
        .header-nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }

        .header-nav-container .logo {
            flex-shrink: 0;
        }

        .header-nav-container nav {
            background: none;
            flex-grow: 1;
        }

        .header-nav-container nav::before {
            display: none;
        }

        .header-nav-container .nav-links {
            justify-content: flex-end;
            margin-left: auto;
        }

        .header-nav-container .nav-links a {
            color: white;
            font-weight: 600;
        }

        .header-nav-container .nav-links a:hover {
            color: var(--secondary);
        }

        .header-nav-container .nav-links a::before {
            background-color: var(--secondary);
        }

        .header-nav-container .dropdown {
            background-color: white;
            border: 1px solid #e0e0e0;
        }

        /* Responsive Styles untuk Header */
        @media (max-width: 992px) {
            .header-nav-container {
                flex-wrap: wrap;
            }
            
            .logo {
                margin-bottom: 10px;
            }
            
            .header-nav-container nav {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
                color: white;
            }
            
            .header-nav-container .nav-links {
                position: fixed;
                top: 0;
                right: -100%;
                width: 250px;
                height: 100vh;
                background: linear-gradient(135deg, var(--header-blue) 0%, var(--header-dark-blue) 100%);
                flex-direction: column;
                padding-top: 50px;
                transition: right 0.3s;
                z-index: 1000;
                box-shadow: -3px 0 10px rgba(0, 0, 0, 0.2);
            }
            
            .header-nav-container .nav-links.active {
                right: 0;
            }
            
            .header-nav-container .nav-links li {
                width: 100%;
            }
            
            .header-nav-container .nav-links a {
                color: white;
            }
            
            .header-nav-container .dropdown {
                position: static;
                opacity: 1;
                visibility: visible;
                display: none;
                box-shadow: none;
                background-color: rgba(0, 0, 0, 0.2);
                width: 100%;
                border: none;
            }
            
            .header-nav-container .nav-links li:hover .dropdown {
                display: block;
            }
        }

        @media (max-width: 576px) {
            .header-nav-container {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .header-nav-container nav {
                width: 100%;
                margin-top: 10px;
            }
            
            .mobile-menu-btn {
                position: absolute;
                top: 15px;
                right: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Header yang Digabungkan dengan Navbar - Warna Biru -->
    <header>
        <div class="container">
            <div class="header-nav-container">
                <div class="logo">
                    <img src="assets/img/login-lasgar.png" alt="Logo Lapas Garut">
                    <div class="logo-text">
                        <h1>Lapas Kelas IIA Garut</h1>
                        <p>Lembaga Pemasyarakatan Garut</p>
                        <p class="subtitle">Kementerian Hukum dan HAM Republik Indonesia</p>
                    </div>
                </div>
                
                <nav>
                    <div class="navbar">
                        <ul class="nav-links">
                            <li><a href="home.php" class="active">Beranda</a></li>
                            <li>
                                <a href="#">Profil <i class="fas fa-chevron-down"></i></a>
                                <ul class="dropdown">
                                    <li><a href="sejarah.php">Sejarah</a></li>
                                    <li><a href="visi_misi.php">Visi & Misi</a></li>
                                    <li><a href="struktur.php">Struktur Organisasi</a></li>
                                    <li><a href="tugas_fungsi.php">Tugas & Fungsi</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Layanan <i class="fas fa-chevron-down"></i></a>
                                <ul class="dropdown">
                                    <li><a href="#">Kunjungan Keluarga</a></li>
                                    <li><a href="#">Pembinaan Narapidana</a></li>
                                    <li><a href="#">Pelayanan Hukum</a></li>
                                    <li><a href="#">Program Rehabilitasi</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Informasi</a></li>
                            <li><a href="index_berita.php">Berita</a></li>
                            <li><a href="#">Galeri</a></li>
                            <li><a href="#">Kontak</a></li>
                        </ul>
                        <button class="mobile-menu-btn">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Script untuk menu mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const navLinks = document.querySelector('.nav-links');
            
            mobileMenuBtn.addEventListener('click', function() {
                navLinks.classList.toggle('active');
            });
            
            // Tutup menu mobile saat mengklik link
            document.querySelectorAll('.nav-links a').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        navLinks.classList.remove('active');
                    }
                });
            });
        });
    </script>
</body>
</html>