<?php
// Mulai session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Include koneksi (hanya untuk koneksi, TIDAK untuk query)
require_once '../config/koneksi.php';

$page_title = "Profil Pengguna";

// HANYA gunakan data dari session - TANPA QUERY DATABASE
$user = [
    'username' => $_SESSION['username'],
    'nama_lengkap' => $_SESSION['nama_lengkap'],
    'email' => $_SESSION['email'] ?? '',
    'level' => $_SESSION['level'] ?? 'admin',
    'created_at' => $_SESSION['created_at'] ?? date('Y-m-d H:i:s'),
    'last_login' => $_SESSION['last_login'] ?? null
];

// JANGAN query database sama sekali untuk data user
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Sistem Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .profile-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 150px;
            position: relative;
        }
        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            position: absolute;
            bottom: -75px;
            left: 50%;
            transform: translateX(-50%);
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            color: #667eea;
        }
        .profile-body {
            padding-top: 90px;
            padding-bottom: 30px;
        }
        .info-item {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
            min-width: 150px;
        }
        .info-value {
            color: #6c757d;
        }
        .stats-card {
            border-radius: 10px;
            transition: transform 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .badge-level {
            font-size: 0.9em;
            padding: 5px 15px;
        }
    </style>
</head>
<body>
    <!-- Navbar Sederhana (tanpa include) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-boxes me-2"></i> Sistem Stok Elektronik
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">
                            <i class="fas fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="barang.php">
                            <i class="fas fa-box me-1"></i> Data Barang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="barang_masuk.php">
                            <i class="fas fa-arrow-down me-1"></i> Barang Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="barang_keluar.php">
                            <i class="fas fa-arrow-up me-1"></i> Barang Keluar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="laporan.php">
                            <i class="fas fa-chart-bar me-1"></i> Laporan
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> <?php echo htmlspecialchars($user['nama_lengkap']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenu">
                            <li>
                                <a class="dropdown-item" href="profil.php">
                                    <i class="fas fa-user me-2"></i> Profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="pengaturan.php">
                                    <i class="fas fa-cog me-2"></i> Pengaturan
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="../proses/logout.php" 
                                   onclick="return confirm('Yakin ingin logout?')">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../index.php"><i class="fas fa-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item active">Profil</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <div class="row">
            <!-- Profil Card -->
            <div class="col-md-4 mb-4">
                <div class="card profile-card">
                    <div class="profile-header"></div>
                    <div class="profile-body text-center">
                        <div class="profile-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h3 class="mt-4 mb-0"><?php echo htmlspecialchars($user['nama_lengkap']); ?></h3>
                        <p class="text-muted"><?php echo htmlspecialchars($user['username']); ?></p>
                        
                        <div class="d-flex justify-content-center mb-3">
                            <?php 
                            $level_text = 'Administrator';
                            $level_class = 'bg-primary';
                            
                            if (isset($user['level'])) {
                                if ($user['level'] == 'admin') {
                                    $level_text = 'Administrator';
                                    $level_class = 'bg-primary';
                                } elseif ($user['level'] == 'staff') {
                                    $level_text = 'Staff';
                                    $level_class = 'bg-success';
                                } elseif ($user['level'] == 'supervisor') {
                                    $level_text = 'Supervisor';
                                    $level_class = 'bg-warning text-dark';
                                }
                            }
                            ?>
                            <span class="badge <?php echo $level_class; ?> badge-level">
                                <i class="fas fa-user-tag me-1"></i> <?php echo $level_text; ?>
                            </span>
                        </div>
                        
                        <div class="mt-4">
                            <button class="btn btn-outline-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editProfilModal">
                                <i class="fas fa-edit me-1"></i> Edit Profil
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#gantiPasswordModal">
                                <i class="fas fa-key me-1"></i> Ganti Password
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Statistik Singkat -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Aktivitas Terbaru</h6>
                    </div>
                    <div class="card-body">
                        <div class="info-item">
                            <div class="d-flex justify-content-between">
                                <span class="info-label">Login Terakhir</span>
                                <span class="info-value">
                                    <?php echo isset($user['last_login']) && $user['last_login'] ? 
                                        date('d/m/Y H:i', strtotime($user['last_login'])) : 'Belum pernah'; ?>
                                </span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="d-flex justify-content-between">
                                <span class="info-label">Akun Dibuat</span>
                                <span class="info-value">
                                    <?php echo isset($user['created_at']) ? 
                                        date('d/m/Y', strtotime($user['created_at'])) : date('d/m/Y'); ?>
                                </span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="d-flex justify-content-between">
                                <span class="info-label">Status</span>
                                <span class="info-value">
                                    <span class="badge bg-success">Aktif</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Detail Informasi -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Informasi Profil</h5>
                    </div>
                    <div class="card-body">
                        <div class="info-item">
                            <div class="row">
                                <div class="col-md-3 info-label">Nama Lengkap</div>
                                <div class="col-md-9 info-value"><?php echo htmlspecialchars($user['nama_lengkap']); ?></div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="row">
                                <div class="col-md-3 info-label">Username</div>
                                <div class="col-md-9 info-value"><?php echo htmlspecialchars($user['username']); ?></div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="row">
                                <div class="col-md-3 info-label">Email</div>
                                <div class="col-md-9 info-value">
                                    <?php echo !empty($user['email']) ? htmlspecialchars($user['email']) : 
                                    '<span class="text-muted">Belum diatur</span>'; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="row">
                                <div class="col-md-3 info-label">Level Akses</div>
                                <div class="col-md-9 info-value">
                                    <?php 
                                    if (isset($user['level'])) {
                                        if ($user['level'] == 'admin') {
                                            echo '<span class="badge bg-primary">Administrator</span> - Akses penuh ke semua fitur';
                                        } elseif ($user['level'] == 'staff') {
                                            echo '<span class="badge bg-success">Staff</span> - Akses terbatas';
                                        } elseif ($user['level'] == 'supervisor') {
                                            echo '<span class="badge bg-warning text-dark">Supervisor</span> - Akses monitoring dan approval';
                                        } else {
                                            echo '<span class="badge bg-secondary">' . htmlspecialchars($user['level']) . '</span>';
                                        }
                                    } else {
                                        echo '<span class="badge bg-primary">Administrator</span>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="row">
                                <div class="col-md-3 info-label">Tanggal Bergabung</div>
                                <div class="col-md-9 info-value">
                                    <?php echo isset($user['created_at']) ? 
                                        date('l, d F Y', strtotime($user['created_at'])) : 
                                        date('l, d F Y'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (isset($user['last_login'])): ?>
                        <div class="info-item">
                            <div class="row">
                                <div class="col-md-3 info-label">Login Terakhir</div>
                                <div class="col-md-9 info-value">
                                    <?php echo date('l, d F Y H:i:s', strtotime($user['last_login'])); ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="info-item">
                            <div class="row">
                                <div class="col-md-3 info-label">ID Pengguna</div>
                                <div class="col-md-9 info-value">
                                    <code><?php echo $_SESSION['user_id']; ?></code>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Statistik Sistem (tanpa query database) -->
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <div class="card stats-card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-user fa-3x text-primary mb-3"></i>
                                <h4><?php echo htmlspecialchars($user['nama_lengkap']); ?></h4>
                                <p class="text-muted mb-0">Nama Pengguna</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="card stats-card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar-alt fa-3x text-success mb-3"></i>
                                <h4>
                                    <?php echo isset($user['created_at']) ? 
                                        date('d/m/Y', strtotime($user['created_at'])) : 
                                        date('d/m/Y'); ?>
                                </h4>
                                <p class="text-muted mb-0">Tanggal Bergabung</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Profil (SIMPAN UNTUK FITUR MENDATANG) -->
    <div class="modal fade" id="editProfilModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Profil</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Fitur edit profil sedang dalam pengembangan. Untuk saat ini, 
                        data profil diambil dari sistem login.
                    </div>
                    <p>Data Anda:</p>
                    <ul>
                        <li><strong>Nama:</strong> <?php echo htmlspecialchars($user['nama_lengkap']); ?></li>
                        <li><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></li>
                        <li><strong>Email:</strong> <?php echo !empty($user['email']) ? htmlspecialchars($user['email']) : 'fadilah@gmail.com'; ?></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ganti Password (SIMPAN UNTUK FITUR MENDATANG) -->
    <div class="modal fade" id="gantiPasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="fas fa-key me-2"></i>Ganti Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Fitur ganti password sedang dalam pengembangan. 
                        Untuk mengganti password, silakan hubungi administrator sistem.
                    </div>
                    <p>Untuk keamanan, pastikan password Anda:</p>
                    <ul>
                        <li>Minimal 8 karakter</li>
                        <li>Mengandung huruf besar dan kecil</li>
                        <li>Mengandung angka</li>
                        <li>Tidak menggunakan password yang mudah ditebak</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Auto-hide alert setelah 5 detik
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Tampilkan pesan jika ada parameter di URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('pesan')) {
            const pesan = urlParams.get('pesan');
            if (pesan === 'sukses') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Perubahan berhasil disimpan.',
                    confirmButtonColor: '#0d6efd',
                    timer: 3000
                });
            } else if (pesan === 'gagal') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan. Silakan coba lagi.',
                    confirmButtonColor: '#0d6efd'
                });
            }
        }
        
        // Fungsi untuk demo edit profil
        document.querySelector('[data-bs-target="#editProfilModal"]').addEventListener('click', function() {
            Swal.fire({
                icon: 'info',
                title: 'Fitur Dalam Pengembangan',
                text: 'Fitur edit profil akan segera hadir di versi update berikutnya.',
                confirmButtonColor: '#0d6efd'
            });
        });
        
        // Fungsi untuk demo ganti password
        document.querySelector('[data-bs-target="#gantiPasswordModal"]').addEventListener('click', function() {
            Swal.fire({
                icon: 'info',
                title: 'Fitur Dalam Pengembangan',
                text: 'Fitur ganti password akan segera hadir. Untuk saat ini, password diatur oleh sistem.',
                confirmButtonColor: '#ffc107'
            });
        });
    </script>
</body>
</html>