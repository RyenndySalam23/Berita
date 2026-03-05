<?php  
include "koneksi.php";

if (isset($_POST['simpan'])) {
    // Ambil data dari form
    $judul_berita = mysqli_real_escape_string($conn, $_POST['judul_berita']);
    $slug_berita = mysqli_real_escape_string($conn, $_POST['slug_berita']);
    $ringkasan = mysqli_real_escape_string($conn, $_POST['ringkasan']);
    $isi_berita = $_POST['isi_berita']; // Tidak perlu escape karena akan di-handle nanti
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);
    $status_berita = mysqli_real_escape_string($conn, $_POST['status_berita']);
    $tanggal_publish = mysqli_real_escape_string($conn, $_POST['tanggal_publish']);

    // Clean HTML content
    $isi_berita = mysqli_real_escape_string($conn, $isi_berita);

    // Generate slug jika kosong
    if (empty($slug_berita)) {
        $slug_berita = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul_berita)));
    }

    // Fungsi upload gambar
    function uploadImage($input_name, $target_folder, $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp']) {
        if (!empty($_FILES[$input_name]['name'])) {
            // Buat folder jika belum ada
            if (!is_dir($target_folder)) {
                mkdir($target_folder, 0777, true);
            }

            $file_name = time() . "_" . basename($_FILES[$input_name]["name"]);
            $target_file = $target_folder . $file_name;
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Validasi format file
            if (!in_array($file_type, $allowed_types)) {
                echo "<script>alert('❌ Format file gambar tidak diizinkan! Hanya JPG, JPEG, PNG, GIF, WebP yang diperbolehkan.');</script>";
                return "";
            }

            // Cek ukuran file (max 5MB)
            if ($_FILES[$input_name]['size'] > 5 * 1024 * 1024) {
                echo "<script>alert('❌ Ukuran file terlalu besar! Maksimal 5MB.');</script>";
                return "";
            }

            // Upload file
            if (move_uploaded_file($_FILES[$input_name]["tmp_name"], $target_file)) {
                return $file_name;
            } else {
                echo "<script>alert('❌ Gagal mengunggah gambar!');</script>";
                return "";
            }
        }
        return "";
    }

    // Upload gambar utama
    $gambar_utama = uploadImage('gambar_utama', "uploads/berita/");

    // Query insert sesuai struktur database
    $query = "INSERT INTO berita (
        judul_berita, 
        slug_berita, 
        ringkasan, 
        isi_berita, 
        gambar_utama, 
        id_kategori, 
        status_berita, 
        tanggal_publish
    ) VALUES (
        '$judul_berita', 
        '$slug_berita', 
        '$ringkasan', 
        '$isi_berita', 
        '$gambar_utama', 
        '$id_kategori', 
        '$status_berita', 
        '$tanggal_publish'
    )";

    $simpan = mysqli_query($conn, $query);

    if ($simpan) {
        echo "<script>
            alert('✅ Berita berhasil disimpan!');
            window.location='?page=berita';
        </script>";
    } else {
        echo "<script>
            alert('❌ Gagal menyimpan berita: " . mysqli_error($conn) . "');
        </script>";
    }
}

// Ambil data kategori untuk dropdown
$query_kategori = mysqli_query($conn, "SELECT * FROM kategori_berita ORDER BY nama_kategori");
$kategori = [];
while ($row = mysqli_fetch_assoc($query_kategori)) {
    $kategori[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita - Lapas Garut</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CKEditor 5 (Lebih modern dan mudah) -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
    
    <style>
        :root {
            --primary: #1a4f8c;
            --secondary: #f8b500;
            --light: #f8f9fa;
            --dark: #343a40;
            --success: #28a745;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container-fluid {
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary), #2c5fa8) !important;
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 1.5rem;
            font-weight: 700;
            font-size: 1.2rem;
            border: none;
        }

        .card-body {
            padding: 2rem;
        }

        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(26, 79, 140, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success), #20c997);
            border: none;
            font-weight: 600;
            border-radius: 8px;
            padding: 12px 30px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #218838, #1e9e8a);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .btn-outline-secondary {
            border: 2px solid #6c757d;
            color: #6c757d;
            font-weight: 600;
            border-radius: 8px;
            padding: 12px 30px;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }

        /* Text Counter */
        .text-counter {
            font-size: 0.875rem;
            text-align: right;
            margin-top: 0.25rem;
            color: #6c757d;
        }

        .text-counter.warning {
            color: #ffc107;
        }

        .text-counter.danger {
            color: #dc3545;
        }

        /* CKEditor Container */
        .ck-editor__editable {
            min-height: 400px !important;
            max-height: 600px !important;
        }

        /* Preview Image */
        #image-preview {
            transition: all 0.3s ease;
        }

        #preview {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 200px;
            max-height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container-fluid px-4">
    <h1 class="mt-4 text-dark">
        <i class="fas fa-newspaper me-2" style="color: var(--primary);"></i>
        Tambah Berita
    </h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="?page=berita" class="text-decoration-none">Berita</a>
        </li>
        <li class="breadcrumb-item active text-dark">Tambah</li>
    </ol>

    <div class="card shadow-sm">
        <div class="card-header text-white">
            <i class="fas fa-edit me-2"></i>Form Tambah Berita
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" id="beritaForm">

                <!-- Judul & Slug -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <label class="form-label">
                            <strong>Judul Berita</strong> <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="judul_berita" class="form-control" 
                               placeholder="Masukkan judul berita yang menarik..." required 
                               onkeyup="generateSlug(this.value)">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">
                            <strong>Slug URL</strong>
                        </label>
                        <input type="text" name="slug_berita" class="form-control" 
                               placeholder="slug-otomatis-tergenerate">
                        <small class="text-muted">URL ramah SEO (otomatis terisi)</small>
                    </div>
                </div>

                <!-- Kategori & Status -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">
                            <strong>Kategori</strong> <span class="text-danger">*</span>
                        </label>
                        <select name="id_kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori as $kat): ?>
                                <option value="<?= $kat['id_kategori'] ?>">
                                    <?= htmlspecialchars($kat['nama_kategori']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                            <strong>Status</strong> <span class="text-danger">*</span>
                        </label>
                        <select name="status_berita" class="form-select" required>
                            <option value="draft">Draft (Simpan Sementara)</option>
                            <option value="publish" selected>Publish (Terbitkan)</option>
                            <option value="archived">Arsip</option>
                        </select>
                    </div>
                </div>

                <!-- Tanggal Publish -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">
                            <strong>Tanggal Publish</strong> <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" name="tanggal_publish" class="form-control" 
                               value="<?= date('Y-m-d\TH:i') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                            <strong>Gambar Utama</strong>
                        </label>
                        <input type="file" name="gambar_utama" class="form-control" 
                               accept=".jpg,.jpeg,.png,.gif,.webp" onchange="previewImage(this)">
                        <small class="text-muted">Format: JPG, PNG, GIF, WebP (Maks. 5MB)</small>
                        <div id="image-preview" class="mt-2" style="display:none;">
                            <img id="preview" src="#" alt="Preview">
                        </div>
                    </div>
                </div>

                <!-- Ringkasan -->
                <div class="mb-4">
                    <label class="form-label">
                        <strong>Ringkasan / Excerpt</strong> <span class="text-danger">*</span>
                    </label>
                    <textarea name="ringkasan" class="form-control" rows="3" 
                              placeholder="Tulis ringkasan singkat berita (akan ditampilkan di halaman daftar berita)..." 
                              maxlength="200" onkeyup="updateCounter(this, 'ringkasan-counter')" required></textarea>
                    <div class="text-counter" id="ringkasan-counter">0/200 karakter</div>
                </div>

                <!-- Isi Berita dengan CKEditor 5 -->
                <div class="mb-4">
                    <label class="form-label">
                        <strong>Isi Berita</strong> <span class="text-danger">*</span>
                    </label>
                    <textarea name="isi_berita" id="isi_berita" 
                              placeholder="Tulis konten berita lengkap di sini..."></textarea>
                    <small class="text-muted">Gunakan editor di atas untuk menulis konten berita</small>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-4 d-flex justify-content-between">
                    <button type="submit" name="simpan" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Simpan Berita
                    </button>
                    <a href="?page=berita" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
// Inisialisasi CKEditor 5
let editorInstance;
ClassicEditor
    .create(document.querySelector('#isi_berita'), {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                'undo', 'redo'
            ]
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
            ]
        },
        placeholder: 'Tulis konten berita lengkap di sini...'
    })
    .then(editor => {
        editorInstance = editor;
        console.log('CKEditor 5 berhasil diinisialisasi');
    })
    .catch(error => {
        console.error('Error inisialisasi CKEditor:', error);
        // Fallback ke textarea biasa
        document.getElementById('isi_berita').style.height = '400px';
        document.getElementById('isi_berita').style.padding = '15px';
    });

// Generate slug otomatis dari judul
function generateSlug(title) {
    if (!title) return;
    
    const slug = title
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .substring(0, 100);
    
    document.querySelector('input[name="slug_berita"]').value = slug;
}

// Update character counter
function updateCounter(textarea, counterId) {
    const counter = document.getElementById(counterId);
    const length = textarea.value.length;
    const maxLength = textarea.getAttribute('maxlength');
    
    counter.textContent = `${length}/${maxLength} karakter`;
    
    // Reset class
    counter.className = 'text-counter';
    
    // Tambah warning jika >80%
    if (length > maxLength * 0.8) {
        counter.classList.add('warning');
    }
    // Tambah danger jika >90%
    if (length > maxLength * 0.9) {
        counter.classList.add('danger');
    }
}

// Preview gambar
function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('image-preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.style.display = 'none';
    }
}

// Validasi form sebelum submit
document.getElementById('beritaForm').addEventListener('submit', function(e) {
    // Validasi judul
    const judul = document.querySelector('input[name="judul_berita"]').value;
    if (!judul.trim()) {
        e.preventDefault();
        alert('Judul berita harus diisi!');
        return;
    }
    
    // Validasi kategori
    const kategori = document.querySelector('select[name="id_kategori"]').value;
    if (!kategori) {
        e.preventDefault();
        alert('Kategori harus dipilih!');
        return;
    }
    
    // Validasi ringkasan
    const ringkasan = document.querySelector('textarea[name="ringkasan"]').value;
    if (!ringkasan.trim()) {
        e.preventDefault();
        alert('Ringkasan harus diisi!');
        return;
    }
    if (ringkasan.length > 200) {
        e.preventDefault();
        alert('Ringkasan maksimal 200 karakter!');
        return;
    }
    
    // Validasi isi berita
    let isiBerita = '';
    if (editorInstance) {
        isiBerita = editorInstance.getData();
    } else {
        isiBerita = document.getElementById('isi_berita').value;
    }
    
    if (!isiBerita.trim()) {
        e.preventDefault();
        alert('Isi berita harus diisi!');
        return;
    }
    
    console.log('Form berhasil divalidasi, mengirim data...');
});

// Inisialisasi counter saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    const ringkasanTextarea = document.querySelector('textarea[name="ringkasan"]');
    if (ringkasanTextarea) {
        updateCounter(ringkasanTextarea, 'ringkasan-counter');
    }
});
</script>

</body>
</html>