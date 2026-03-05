    <!-- Footer -->
    <footer>
        <style>
            /* Footer Styles */
            footer {
                background-color: #1a1a1a;
                color: white;
                padding-top: 50px;
            }

            .footer-content {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 30px;
                margin-bottom: 30px;
            }

            .footer-column h3 {
                font-size: 18px;
                margin-bottom: 15px;
                color: var(--secondary);
                position: relative;
                padding-bottom: 8px;
            }

            .footer-column h3::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 40px;
                height: 2px;
                background-color: var(--secondary);
            }

            .footer-links li {
                margin-bottom: 8px;
            }

            .footer-links a {
                color: #bbb;
                transition: color 0.3s;
                font-size: 14px;
            }

            .footer-links a:hover {
                color: var(--secondary);
            }

            .contact-info-footer li {
                display: flex;
                align-items: flex-start;
                margin-bottom: 12px;
            }

            .contact-info-footer i {
                margin-right: 8px;
                color: var(--secondary);
                margin-top: 3px;
                font-size: 14px;
            }

            .footer-bottom {
                border-top: 1px solid #333;
                padding: 15px 0;
                text-align: center;
                color: #bbb;
                font-size: 13px;
            }
        </style>

        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Tentang Lapas Garut</h3>
                    <p>Lapas Kelas IIA Garut merupakan unit pelaksana teknis di bawah Direktorat Jenderal Pemasyarakatan, Kementerian Hukum dan HAM RI yang berkomitmen untuk melakukan pembinaan dan pemberdayaan Warga Binaan.</p>
                    <div class="social-links" style="margin-top: 15px;">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Layanan Cepat</h3>
                    <ul class="footer-links">
                        <li><a href="#">Informasi Kunjungan</a></li>
                        <li><a href="#">Program Pembinaan</a></li>
                        <li><a href="#">Pengaduan Masyarakat</a></li>
                        <li><a href="#">Bantuan Hukum</a></li>
                        <li><a href="#">Informasi Warga Binaan</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Informasi</h3>
                    <ul class="footer-links">
                        <li><a href="#">Berita</a></li>
                        <li><a href="#">Pengumuman</a></li>
                        <li><a href="#">Agenda</a></li>
                        <li><a href="#">Galeri</a></li>
                        <li><a href="#">Download</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Kontak Kami</h3>
                    <ul class="contact-info-footer">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Jalan Raya Cikajang No. 123, Garut, Jawa Barat 44151</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>(0262) 123-4567</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>info@lapasgarut.go.id</span>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <span>Senin - Jumat: 08.00 - 16.00 WIB</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 Lapas Kelas IIA Garut - Lembaga Pemasyarakatan Garut. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
            document.querySelector('.nav-links').classList.toggle('active');
        });

        // Dropdown Menu for Mobile
        const dropdownParents = document.querySelectorAll('.nav-links li');
        
        dropdownParents.forEach(parent => {
            if (window.innerWidth <= 768) {
                parent.addEventListener('click', function(e) {
                    if (this.querySelector('.dropdown')) {
                        e.preventDefault();
                        const dropdown = this.querySelector('.dropdown');
                        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                    }
                });
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.navbar') && window.innerWidth <= 768) {
                document.querySelector('.nav-links').classList.remove('active');
                
                // Hide all dropdowns
                document.querySelectorAll('.dropdown').forEach(dropdown => {
                    dropdown.style.display = 'none';
                });
            }
        });

        // Search functionality
        document.querySelector('.search-box button').addEventListener('click', function() {
            const searchTerm = document.querySelector('.search-box input').value;
            if (searchTerm.trim() !== '') {
                alert('Mencari: ' + searchTerm);
                // In a real implementation, you would redirect to search results page
            }
        });

        // Add enter key support for search
        document.querySelector('.search-box input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.querySelector('.search-box button').click();
            }
        });

        // Simple counter animation for statistics
        function animateCounter(element, target, duration) {
            let start = 0;
            const increment = target / (duration / 16);
            const timer = setInterval(() => {
                start += increment;
                if (start >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(start);
                }
            }, 16);
        }

        // Initialize counters when statistics section is in view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const stats = document.querySelectorAll('.stat-number');
                    stats.forEach(stat => {
                        const target = parseInt(stat.textContent);
                        animateCounter(stat, target, 2000);
                    });
                    observer.disconnect();
                }
            });
        });

        observer.observe(document.querySelector('.statistics'));
    </script>
</body>
</html>