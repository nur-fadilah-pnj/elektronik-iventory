<?php
// Mulai session hanya jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika belum login, redirect ke login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Include koneksi database
require_once 'config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Stok Barang Elektronik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .dashboard-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            height: 100%;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .card-icon {
            font-size: 2.5rem;
            opacity: 0.7;
        }
        .table-danger td {
            background-color: #f8d7da !important;
        }
        .table-warning td {
            background-color: #fff3cd !important;
        }
        .stats-number {
            font-size: 2.2rem;
            font-weight: bold;
        }
    </style>
</head>
<!-- Modal Pengaturan Sederhana -->
<div class="modal fade" id="settingsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-cog me-2"></i>Pengaturan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Halaman pengaturan sedang dalam pengembangan.</p>
                <p>Untuk sekarang, Anda bisa:</p>
                <ul>
                    <li>Edit profil melalui menu Profil</li>
                    <li>Kelola data melalui menu masing-masing</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="pages/profil.php" class="btn btn-primary">Ke Halaman Profil</a>
            </div>
        </div>
    </div>
</div>

<script>
function showSettings() {
    var settingsModal = new bootstrap.Modal(document.getElementById('settingsModal'));
    settingsModal.show();
}
</script>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-boxes"></i> SISTEM STOK ELEKTRONIK
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php"><i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/barang.php"><i class="fas fa-box"></i> Data Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/barang_masuk.php"><i class="fas fa-arrow-down"></i> Barang Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/barang_keluar.php"><i class="fas fa-arrow-up"></i> Barang Keluar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/laporan.php"><i class="fas fa-chart-bar"></i> Laporan</a>
                    </li>
                </ul>
                                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="showSettings()">
                                    <i class="fas fa-cog me-2"></i> Pengaturan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="pages/profil.php">
                                    <i class="fas fa-user me-2"></i> Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="proses/logout.php" 
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
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card dashboard-card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2">TOTAL BARANG</h6>
                                <div class="stats-number">
                                    <?php
                                    $query = "SELECT COUNT(*) as total FROM barang";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo $data['total'];
                                    ?>
                                </div>
                            </div>
                            <i class="fas fa-box card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card dashboard-card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2">TOTAL STOK</h6>
                                <div class="stats-number">
                                    <?php
                                    $query = "SELECT SUM(stok) as total FROM barang";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo $data['total'] ?: '0';
                                    ?>
                                </div>
                            </div>
                            <i class="fas fa-cubes card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card dashboard-card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2">BARANG MASUK</h6>
                                <div class="stats-number">
                                    <?php
                                    $query = "SELECT SUM(jumlah) as total FROM barang_masuk 
                                             WHERE MONTH(tanggal_masuk) = MONTH(CURRENT_DATE())";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo $data['total'] ?: '0';
                                    ?>
                                </div>
                            </div>
                            <i class="fas fa-arrow-down card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card dashboard-card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2">BARANG KELUAR</h6>
                                <div class="stats-number">
                                    <?php
                                    $query = "SELECT SUM(jumlah) as total FROM barang_keluar 
                                             WHERE MONTH(tanggal_keluar) = MONTH(CURRENT_DATE())";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo $data['total'] ?: '0';
                                    ?>
                                </div>
                            </div>
                            <i class="fas fa-arrow-up card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Welcome Message -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-primary">
                            <i class="fas fa-hand-wave me-2"></i>
                            Selamat datang, <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?>!
                        </h3>
                        <p class="mb-0">Anda login sebagai Administrator di Sistem Informasi Stok Barang Toko Cahaya Elektronik</p>
                        <p class="text-muted mt-2">
                            <i class="fas fa-calendar me-1"></i>
                            <?php echo date('d F Y'); ?> | 
                            <i class="fas fa-clock me-1"></i>
                            <?php echo date('H:i:s'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="row">
            <!-- Quick Actions -->
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>AKSES CEPAT</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="pages/barang.php" class="list-group-item list-group-item-action d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-2 me-3">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Tambah Barang Baru</h6>
                                    <small class="text-muted">Input data barang baru</small>
                                </div>
                            </a>
                            <a href="pages/barang_masuk.php" class="list-group-item list-group-item-action d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle p-2 me-3">
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Input Barang Masuk</h6>
                                    <small class="text-muted">Catat barang masuk</small>
                                </div>
                            </a>
                            <a href="pages/barang_keluar.php" class="list-group-item list-group-item-action d-flex align-items-center">
                                <div class="bg-warning text-white rounded-circle p-2 me-3">
                                    <i class="fas fa-arrow-up"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Input Barang Keluar</h6>
                                    <small class="text-muted">Catat barang keluar</small>
                                </div>
                            </a>
                            <a href="pages/laporan.php" class="list-group-item list-group-item-action d-flex align-items-center">
                                <div class="bg-info text-white rounded-circle p-2 me-3">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Lihat Laporan</h6>
                                    <small class="text-muted">Analisis data stok</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Low Stock -->
            <div class="col-md-8 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>STOK BARANG RENDAH (< 10)</h5>
                        <span class="badge bg-light text-danger"><?php
                            $query = "SELECT COUNT(*) as total FROM barang WHERE stok < 10";
                            $result = mysqli_query($koneksi, $query);
                            $data = mysqli_fetch_assoc($result);
                            echo $data['total'];
                        ?> item</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT b.*, k.nama_kategori FROM barang b 
                                             LEFT JOIN kategori k ON b.id_kategori = k.id_kategori 
                                             WHERE b.stok < 10 
                                             ORDER BY b.stok ASC 
                                             LIMIT 10";
                                    $result = mysqli_query($koneksi, $query);
                                    $no = 1;
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $status_class = $row['stok'] < 5 ? 'table-danger' : 'table-warning';
                                            $status_text = $row['stok'] < 5 ? 'SANGAT RENDAH' : 'RENDAH';
                                            $status_badge = $row['stok'] < 5 ? 'bg-danger' : 'bg-warning text-dark';
                                    ?>
                                    <tr class="<?php echo $status_class; ?>">
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_kategori']); ?></td>
                                        <td>
                                            <span class="badge <?php echo $status_badge; ?>">
                                                <?php echo $row['stok']; ?>
                                            </span>
                                        </td>
                                        <td><?php echo 'Rp ' . number_format($row['harga_jual'], 0, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars($row['lokasi_rak']); ?></td>
                                        <td>
                                            <span class="badge <?php echo $status_badge; ?>">
                                                <?php echo $status_text; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php 
                                        }
                                    } else {
                                        echo '<tr>
                                                <td colspan="7" class="text-center text-success py-4">
                                                    <i class="fas fa-check-circle fa-2x mb-3"></i><br>
                                                    Tidak ada barang dengan stok rendah
                                                </td>
                                              </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>AKTIVITAS TERBARU</h5>
                        <button class="btn btn-light btn-sm" onclick="location.reload()">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0"><i class="fas fa-arrow-down me-2"></i>Barang Masuk Terbaru</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="list-group">
                                            <?php
                                            $query = "SELECT bm.*, b.nama_barang FROM barang_masuk bm 
                                                     JOIN barang b ON bm.id_barang = b.id_barang 
                                                     ORDER BY bm.created_at DESC LIMIT 5";
                                            $result = mysqli_query($koneksi, $query);
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<div class="list-group-item">
                                                            <div class="d-flex w-100 justify-content-between">
                                                                <h6 class="mb-1">' . htmlspecialchars($row['nama_barang']) . '</h6>
                                                                <small>' . date('d/m/Y', strtotime($row['tanggal_masuk'])) . '</small>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <small>Supplier: ' . htmlspecialchars($row['supplier'] ?: '-') . '</small>
                                                                <span class="badge bg-success">' . $row['jumlah'] . ' unit</span>
                                                            </div>
                                                          </div>';
                                                }
                                            } else {
                                                echo '<div class="text-center py-3 text-muted">
                                                        <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                        Belum ada data barang masuk
                                                      </div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-warning text-dark">
                                        <h6 class="mb-0"><i class="fas fa-arrow-up me-2"></i>Barang Keluar Terbaru</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="list-group">
                                            <?php
                                            $query = "SELECT bk.*, b.nama_barang FROM barang_keluar bk 
                                                     JOIN barang b ON bk.id_barang = b.id_barang 
                                                     ORDER BY bk.created_at DESC LIMIT 5";
                                            $result = mysqli_query($koneksi, $query);
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<div class="list-group-item">
                                                            <div class="d-flex w-100 justify-content-between">
                                                                <h6 class="mb-1">' . htmlspecialchars($row['nama_barang']) . '</h6>
                                                                <small>' . date('d/m/Y', strtotime($row['tanggal_keluar'])) . '</small>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <small>Penerima: ' . htmlspecialchars($row['penerima'] ?: '-') . '</small>
                                                                <span class="badge bg-warning text-dark">' . $row['jumlah'] . ' unit</span>
                                                            </div>
                                                          </div>';
                                                }
                                            } else {
                                                echo '<div class="text-center py-3 text-muted">
                                                        <i class="fas fa-outbox fa-2x mb-2"></i><br>
                                                        Belum ada data barang keluar
                                                      </div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-4 py-3 bg-light border-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    <small class="text-muted">
                        <i class="fas fa-copyright"></i> <?php echo date('Y'); ?> - Sistem Informasi Stok Barang Elektronik Sei Batang Hari
                        | Login sebagai: <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?>
                        | <i class="fas fa-server"></i> <?php echo mysqli_get_host_info($koneksi); ?>
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Update waktu real-time
    function updateTime() {
        const now = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        document.getElementById('currentTime').innerText = now.toLocaleDateString('id-ID', options);
    }
    
    // Update waktu setiap detik
    setInterval(updateTime, 1000);
    updateTime();
    
    // Auto refresh data setiap 60 detik
    setTimeout(function() {
        window.location.reload();
    }, 60000);
    </script>
</body>
</html>