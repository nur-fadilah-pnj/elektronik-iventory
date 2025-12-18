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

// Include koneksi
require_once '../config/koneksi.php';

$page_title = "Pengaturan Sistem";
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
        .settings-card {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .settings-icon {
            font-size: 3rem;
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <!-- Navbar (sama seperti index.php) -->
    <?php include '../partials/navbar.php'; ?>
    
    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../index.php"><i class="fas fa-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item active">Pengaturan</li>
                    </ol>
                </nav>
                <div class="card settings-card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-cog me-2"></i>Pengaturan Sistem</h3>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3 mb-4">
                                <a href="pengaturan_profil.php" class="text-decoration-none">
                                    <div class="card h-100 hover-shadow">
                                        <div class="card-body">
                                            <i class="fas fa-user-cog settings-icon mb-3"></i>
                                            <h5>Profil Pengguna</h5>
                                            <p class="text-muted">Kelola data profil Anda</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-md-3 mb-4">
                                <a href="pengaturan_kategori.php" class="text-decoration-none">
                                    <div class="card h-100 hover-shadow">
                                        <div class="card-body">
                                            <i class="fas fa-tags settings-icon mb-3"></i>
                                            <h5>Kategori Barang</h5>
                                            <p class="text-muted">Kelola kategori barang</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-md-3 mb-4">
                                <a href="pengaturan_supplier.php" class="text-decoration-none">
                                    <div class="card h-100 hover-shadow">
                                        <div class="card-body">
                                            <i class="fas fa-truck settings-icon mb-3"></i>
                                            <h5>Data Supplier</h5>
                                            <p class="text-muted">Kelola data supplier</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-md-3 mb-4">
                                <a href="pengaturan_sistem.php" class="text-decoration-none">
                                    <div class="card h-100 hover-shadow">
                                        <div class="card-body">
                                            <i class="fas fa-sliders-h settings-icon mb-3"></i>
                                            <h5>Sistem</h5>
                                            <p class="text-muted">Pengaturan sistem</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Quick Settings -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Profil Anda</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <i class="fas fa-user-circle fa-5x text-primary mb-3"></i>
                                            </div>
                                            <div class="col-md-8">
                                                <p><strong>Nama:</strong> <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?></p>
                                                <p><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                                                <p><strong>Login Terakhir:</strong> <?php echo date('d/m/Y H:i', strtotime($_SESSION['last_login'] ?? 'now')); ?></p>
                                                <button class="btn btn-primary btn-sm" onclick="window.location.href='pengaturan_profil.php'">
                                                    <i class="fas fa-edit me-1"></i> Edit Profil
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Sistem</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        // Info database
                                        $query = "SELECT VERSION() as version";
                                        $result = mysqli_query($koneksi, $query);
                                        $db_info = mysqli_fetch_assoc($result);
                                        ?>
                                        <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
                                        <p><strong>MySQL Version:</strong> <?php echo $db_info['version']; ?></p>
                                        <p><strong>Server:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
                                        <p><strong>Tanggal Sistem:</strong> <?php echo date('d F Y H:i:s'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tambah efek hover
        document.querySelectorAll('.hover-shadow').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>