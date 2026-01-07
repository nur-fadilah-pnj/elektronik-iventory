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
        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
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
                            <i class="fas fa-user-circle"></i> Administrator
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <!-- Statistic Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card dashboard-card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2">TOTAL BARANG</h6>
                                <h2 class="mb-0">127</h2>
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
                                <h2 class="mb-0">2,548</h2>
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
                                <h2 class="mb-0">342</h2>
                                <small class="text-white-50">Bulan ini</small>
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
                                <h2 class="mb-0">189</h2>
                                <small class="text-white-50">Bulan ini</small>
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
                <div class="card welcome-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4>Selamat datang, <span class="fw-bold">Administrator</span>!</h4>
                                <p class="mb-0">Anda login sebagai Administrator di Sistem Informasi Stok Barang Elektronik Sei Batang Hari</p>
                                <small><i class="fas fa-calendar-alt me-1"></i> 28 Desember 2025</small>
                            </div>
                            <div class="col-md-4 text-end">
                                <i class="fas fa-chart-line display-4 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions & Low Stock -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card dashboard-card">
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
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="fas fa-print text-secondary me-2"></i> Cetak Laporan
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="fas fa-users text-dark me-2"></i> Manajemen Pengguna
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8 mb-3">
                <div class="card dashboard-card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> STOK BARANG RENDAH (< 10)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Lokasi Rak</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-danger">
                                        <td>1</td>
                                        <td>Resistor 10KΩ 1/4W</td>
                                        <td>Komponen Pasif</td>
                                        <td><span class="badge bg-danger">3</span></td>
                                        <td>Rak A-12</td>
                                        <td>SANGAT RENDAH</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-plus"></i> Restock
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td>2</td>
                                        <td>Kapasitor Elektrolit 100uF 25V</td>
                                        <td>Komponen Pasif</td>
                                        <td><span class="badge bg-danger">4</span></td>
                                        <td>Rak A-15</td>
                                        <td>SANGAT RENDAH</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-plus"></i> Restock
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>3</td>
                                        <td>IC Arduino Uno R3</td>
                                        <td>Mikrokontroler</td>
                                        <td><span class="badge bg-warning">7</span></td>
                                        <td>Rak B-05</td>
                                        <td>RENDAH</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-plus"></i> Restock
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>4</td>
                                        <td>Transistor BC547</td>
                                        <td>Semikonduktor</td>
                                        <td><span class="badge bg-warning">8</span></td>
                                        <td>Rak C-08</td>
                                        <td>RENDAH</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-plus"></i> Restock
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>5</td>
                                        <td>LED 5mm Merah</td>
                                        <td>Optoelektronik</td>
                                        <td><span class="badge bg-warning">9</span></td>
                                        <td>Rak D-03</td>
                                        <td>RENDAH</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-plus"></i> Restock
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="barang.php?filter=stok_rendah" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-list"></i> Lihat Semua
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card dashboard-card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-history"></i> AKTIVITAS TERBARU</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-success rounded-circle p-2 text-white">
                                        <i class="fas fa-arrow-down"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Barang Masuk</h6>
                                    <p class="mb-1">Resistor 10KΩ sebanyak 500 pcs telah masuk</p>
                                    <small class="text-muted"><i class="far fa-clock"></i> 2 jam yang lalu</small>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-warning rounded-circle p-2 text-white">
                                        <i class="fas fa-arrow-up"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Barang Keluar</h6>
                                    <p class="mb-1">IC Arduino Uno R3 sebanyak 10 pcs dikeluarkan</p>
                                    <small class="text-muted"><i class="far fa-clock"></i> 5 jam yang lalu</small>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary rounded-circle p-2 text-white">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Barang Baru</h6>
                                    <p class="mb-1">Sensor Ultrasonic HC-SR04 telah ditambahkan</p>
                                    <small class="text-muted"><i class="far fa-clock"></i> Kemarin</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-5 py-3 bg-light border-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <small class="text-muted">© 2025 Sistem Stok Barang Elektronik. All rights reserved.</small>
                </div>
                <div class="col-md-6 text-end">
                    <small class="text-muted">Versi 2.1.0 | Terakhir diperbarui: 28 Desember 2025</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple script untuk memperbarui tanggal
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dateString = now.toLocaleDateString('id-ID', options);
            
            // Update semua elemen dengan kelas .current-date
            document.querySelectorAll('.current-date').forEach(el => {
                el.textContent = dateString;
            });
            
            // Animasi untuk kartu saat dihover
            const cards = document.querySelectorAll('.dashboard-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.boxShadow = '0 10px 25px rgba(0,0,0,0.15)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
                });
            });
        });
    </script>
</body>
</html>