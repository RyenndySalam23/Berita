-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2026 at 08:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_berita1`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `judul_berita` varchar(255) NOT NULL,
  `slug_berita` varchar(255) NOT NULL,
  `ringkasan` text DEFAULT NULL,
  `isi_berita` longtext DEFAULT NULL,
  `gambar_utama` varchar(255) DEFAULT NULL,
  `status_berita` enum('draft','publish','archived') NOT NULL DEFAULT 'draft',
  `views_count` int(11) NOT NULL DEFAULT 0,
  `tanggal_publish` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `id_kategori`, `judul_berita`, `slug_berita`, `ringkasan`, `isi_berita`, `gambar_utama`, `status_berita`, `views_count`, `tanggal_publish`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jadwal Kunjungan Keluarga Bulan Maret 2026', 'jadwal-kunjungan-keluarga-bulan-maret-2026', 'Berikut adalah jadwal kunjungan keluarga untuk Warga Binaan selama bulan Maret 2026. Kunjungan dilaksanakan setiap hari Selasa dan Kamis dengan pembagian blok.', '<h3>Jadwal Kunjungan Keluarga Maret 2026</h3><p>Dengan ini diumumkan jadwal kunjungan keluarga untuk Warga Binaan Lapas Kelas IIA Garut selama bulan Maret 2026 sebagai berikut:</p><ul><li><strong>Selasa, 3 Maret 2026:</strong> Blok A (Nama A-K)</li><li><strong>Kamis, 5 Maret 2026:</strong> Blok B (Nama L-R)</li><li><strong>Selasa, 10 Maret 2026:</strong> Blok C (Nama S-Z)</li><li><strong>Kamis, 12 Maret 2026:</strong> Blok D (Semua blok)</li><li><strong>Selasa, 17 Maret 2026:</strong> Blok A</li><li><strong>Kamis, 19 Maret 2026:</strong> Blok B</li><li><strong>Selasa, 24 Maret 2026:</strong> Blok C</li><li><strong>Kamis, 26 Maret 2026:</strong> Blok D</li></ul><p>Kunjungan dilaksanakan pukul 09.00 - 14.00 WIB. Pengunjung wajib membawa KTP asli dan mematuhi protokol kesehatan.</p>', 'kunjungan-maret.jpg', 'publish', 125, '2026-03-01 08:00:00', '2026-03-05 19:02:02', '2026-03-05 19:02:02'),
(2, 2, 'Kegiatan Olahraga Bersama Warga Binaan', 'kegiatan-olahraga-bersama-warga-binaan', 'Kegiatan olahraga rutin setiap hari Sabtu untuk menjaga kesehatan dan kebugaran Warga Binaan Lapas Garut.', '<h3>Olahraga Bersama Warga Binaan</h3><p>Lapas Kelas IIA Garut secara rutin mengadakan kegiatan olahraga untuk Warga Binaan setiap hari Sabtu. Kegiatan ini bertujuan untuk menjaga kesehatan fisik dan mental para Warga Binaan.</p><p>Jenis olahraga yang dilakukan:</p><ul><li>Senam pagi bersama</li><li>Futsal</li><li>Bulutangkis</li><li>Tenis meja</li><li>Voli</li></ul><p>Kegiatan dilaksanakan pukul 07.00 - 09.00 WIB di lapangan olahraga Lapas Garut. Seluruh Warga Binaan diwajibkan mengikuti minimal satu jenis olahraga setiap minggunya.</p>', 'olahraga-bersama.jpg', 'publish', 87, '2026-03-02 10:30:00', '2026-03-05 19:02:02', '2026-03-05 19:02:02'),
(3, 3, 'Pelatihan Keterampilan Membatik untuk Warga Binaan', 'pelatihan-keterampilan-membatik-warga-binaan', 'Program pembinaan keterampilan membatik bagi Warga Binaan bekerja sama dengan Dinas Perindustrian Kabupaten Garut.', '<h3>Pelatihan Membatik di Lapas Garut</h3><p>Lapas Kelas IIA Garut bekerja sama dengan Dinas Perindustrian dan Perdagangan Kabupaten Garut mengadakan pelatihan keterampilan membatik bagi Warga Binaan. Pelatihan ini merupakan bagian dari program pembinaan kemandirian.</p><p>Detail pelatihan:</p><ul><li><strong>Peserta:</strong> 25 Warga Binaan</li><li><strong>Durasi:</strong> 2 bulan (Maret-April 2026)</li><li><strong>Instruktur:</strong> Pengrajin batik profesional dari Garut</li><li><strong>Materi:</strong> Teknik membatik, pewarnaan alami, finishing, hingga pemasaran</li></ul><p>Hasil karya batik dari Warga Binaan akan dipasarkan melalui koperasi lapas dan pameran-pameran UKM yang diadakan oleh Pemerintah Kabupaten Garut.</p>', 'pelatihan-membatik.jpg', 'publish', 211, '2026-03-03 14:15:00', '2026-03-05 19:02:02', '2026-03-05 19:04:00'),
(4, 4, 'Perubahan Prosedur Kunjungan Terbaru', 'perubahan-prosedur-kunjungan-terbaru', 'Informasi mengenai perubahan prosedur kunjungan di Lapas Kelas IIA Garut mulai berlaku 1 April 2026.', '<h3>Prosedur Kunjungan Terbaru</h3><p>Sehubungan dengan peningkatan keamanan dan kenyamanan, Lapas Kelas IIA Garut memberlakukan prosedur kunjungan terbaru mulai tanggal 1 April 2026:</p><ol><li><strong>Registrasi Online</strong> - Pengunjung wajib melakukan registrasi online minimal H-1 melalui website https://lasgar.org/kunjungan</li><li><strong>Dokumen yang dibawa:</strong> KTP asli (fisik) dan kartu keluarga</li><li><strong>Protokol Kesehatan:</strong> Tetap memakai masker selama di area kunjungan</li><li><strong>Larangan:</strong> Tidak membawa handphone, kamera, atau barang terlarang lainnya</li><li><strong>Durasi Kunjungan:</strong> Maksimal 30 menit per Warga Binaan</li></ol><p>Untuk informasi lebih lanjut dapat menghubungi bagian pelayanan kunjungan di nomor (0262) 123-4567.</p>', 'prosedur-kunjungan.jpg', 'publish', 342, '2026-03-04 09:45:00', '2026-03-05 19:02:02', '2026-03-05 19:02:02'),
(5, 1, 'Kegiatan Keagamaan Bulan Ramadhan 1447 H', 'kegiatan-keagamaan-bulan-ramadhan-1447-h', 'Jadwal lengkap kegiatan keagamaan selama bulan suci Ramadhan 1447 H di Lapas Kelas IIA Garut.', '<h3>Kegiatan Ramadhan 1447 H di Lapas Garut</h3><p>Menyambut bulan suci Ramadhan 1447 H, Lapas Kelas IIA Garut mengadakan berbagai kegiatan keagamaan untuk meningkatkan keimanan dan ketakwaan Warga Binaan muslim:</p><p><strong>Kegiatan Harian:</strong></p><ul><li>03.30 - 04.00: Sahur bersama</li><li>04.30 - 05.30: Shalat Subuh berjamaah dan Kajian Subuh</li><li>12.00 - 13.00: Shalat Dzuhur dan Tadarus Al-Quran</li><li>15.30 - 16.30: Shalat Ashar dan Kultum</li><li>17.45 - 18.15: Buka puasa bersama</li><li>19.00 - 20.00: Shalat Maghrib, Isya, dan Tarawih berjamaah</li><li>20.30 - 21.30: Ceramah agama dan kajian kitab</li></ul><p><strong>Kegiatan Khusus:</strong></p><ul><li>Khataman Al-Quran setiap hari Jumat</li><li>Pesantren Kilat (pekan terakhir Ramadhan)</li><li>Pemberian santunan kepada Warga Binaan kurang mampu</li></ul><p>Semoga kegiatan ini dapat memberikan keberkahan bagi kita semua.</p>', 'ramadhan.jpg', 'publish', 161, '2026-03-05 11:20:00', '2026-03-05 19:02:02', '2026-03-05 19:18:11'),
(6, 2, 'berita test', 'berita-test', '23r4t54erweqe', '<p>wCSADSFDGFHYFK,DTRSAGFgwraersdt,rjsaehWGEQFWAESR</p><p>STHYT</p>', '1772738696_kemenekes.png', 'publish', 0, '2026-03-05 20:23:00', '2026-03-05 19:24:56', '2026-03-05 19:24:56');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_berita`
--

CREATE TABLE `kategori_berita` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `slug_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_berita`
--

INSERT INTO `kategori_berita` (`id_kategori`, `nama_kategori`, `slug_kategori`, `deskripsi`, `created_at`) VALUES
(1, 'Pengumuman', 'pengumuman', 'Informasi pengumuman resmi Lapas Garut', '2026-03-05 19:02:02'),
(2, 'Kegiatan', 'kegiatan', 'Berita tentang kegiatan di Lapas Garut', '2026-03-05 19:02:02'),
(3, 'Pembinaan', 'pembinaan', 'Informasi program pembinaan Warga Binaan', '2026-03-05 19:02:02'),
(4, 'Kunjungan', 'kunjungan', 'Informasi jadwal dan prosedur kunjungan', '2026-03-05 19:02:02'),
(5, 'Layanan Publik', 'layanan-publik', 'Informasi layanan publik di Lapas Garut', '2026-03-05 19:02:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori_berita`
--
ALTER TABLE `kategori_berita`
  ADD PRIMARY KEY (`id_kategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kategori_berita`
--
ALTER TABLE `kategori_berita`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `berita_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_berita` (`id_kategori`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
