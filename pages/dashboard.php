<?php
require_once '../config/koneksi.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}
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
        .list-group-item {
            border: none;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s;
        }
        .list-group-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }
        .table-danger td {
            background-color: #f8d7da !important;
        }
        .table-warning td {
            background-color: #fff3cd !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">
                <i class="fas fa-boxes"></i> SISTEM STOK ELEKTRONIK
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="barang.php"><i class="fas fa-box"></i> Data Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="barang_masuk.php"><i class="fas fa-arrow-down"></i> Barang Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="barang_keluar.php"><i class="fas fa-arrow-up"></i> Barang Keluar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="laporan.php"><i class="fas fa-chart-bar"></i> Laporan</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> <?php echo $_SESSION['nama_lengkap']; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../proses/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card dashboard-card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2">TOTAL BARANG</h6>
                                <h2 class="mb-0">
                                    <?php
                                    $query = "SELECT COUNT(*) as total FROM barang";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo $data['total'];
                                    ?>
                                </h2>
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
                                <h2 class="mb-0">
                                    <?php
                                    $query = "SELECT SUM(stok) as total FROM barang";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo $data['total'] ?: '0';
                                    ?>
                                </h2>
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
                                <h2 class="mb-0">
                                    <?php
                                    $query = "SELECT SUM(jumlah) as total FROM barang_masuk 
                                             WHERE MONTH(tanggal_masuk) = MONTH(CURRENT_DATE())";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo $data['total'] ?: '0';
                                    ?>
                                </h2>
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
                                <h2 class="mb-0">
                                    <?php
                                    $query = "SELECT SUM(jumlah) as total FROM barang_keluar 
                                             WHERE MONTH(tanggal_keluar) = MONTH(CURRENT_DATE())";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo $data['total'] ?: '0';
                                    ?>
                                </h2>
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
                    <div class="card-body">
                        <h4>Selamat datang, <span class="text-primary"><?php echo $_SESSION['nama_lengkap']; ?></span>!</h4>
                        <p class="mb-0">Anda login sebagai Administrator di Sistem Informasi Stok Barang Elektronik Sei Batang Hari</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions & Low Stock -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-bolt"></i> AKSES CEPAT</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="barang.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-plus-circle text-primary me-2"></i> Tambah Barang Baru
                            </a>
                            <a href="barang_masuk.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-arrow-down text-success me-2"></i> Input Barang Masuk
                            </a>
                            <a href="barang_keluar.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-arrow-up text-warning me-2"></i> Input Barang Keluar
                            </a>
                            <a href="laporan.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-chart-bar text-info me-2"></i> Lihat Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> STOK BARANG RENDAH (< 10)</h5>
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
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT b.*, k.nama_kategori FROM barang b 
                                             LEFT JOIN kategori k ON b.id_kategori = k.id_kategori 
                                             WHERE b.stok < 10 
                                             ORDER BY b.stok ASC";
                                    $result = mysqli_query($koneksi, $query);
                                    $no = 1;
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $status_class = $row['stok'] < 5 ? 'table-danger' : 'table-warning';
                                    ?>
                                    <tr class="<?php echo $status_class; ?>">
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row['nama_barang']; ?></td>
                                        <td><?php echo $row['nama_kategori']; ?></td>
                                        <td><span class="badge bg-danger"><?php echo $row['stok']; ?></span></td>
                                        <td><?php echo $row['lokasi_rak']; ?></td>
                                        <td><?php echo $row['stok'] < 5 ? 'SANGAT RENDAH' : 'RENDAH'; ?></td>
                                    </tr>
                                    <?php 
                                        }
                                    } else {
                                        echo '<tr><td colspan="6" class="text-center text-success">Tidak ada barang dengan stok rendah</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>