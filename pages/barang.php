<?php
require_once '../config/koneksi.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - Sistem Stok Barang Elektronik</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        .card-header {
            border-radius: 10px 10px 0 0 !important;
            font-weight: 600;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-top: none;
        }
        .badge {
            font-size: 0.85em;
            padding: 5px 10px;
            font-weight: 500;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .modal-header.bg-primary {
            background-color: #007bff !important;
            color: white;
        }
        .modal-header.bg-warning {
            background-color: #ffc107 !important;
            color: #212529;
        }
        .dataTables_wrapper {
            padding: 0;
        }
        .dataTables_length select,
        .dataTables_filter input {
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }
        .pagination .page-link {
            color: #007bff;
        }
        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }
        .stats-card {
            border-left: 4px solid #007bff;
        }
        .hover-shadow {
            transition: all 0.3s;
        }
        .hover-shadow:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background-color: white;
        }
        .stock-indicator {
            width: 100px;
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 5px;
        }
        .stock-fill {
            height: 100%;
            border-radius: 4px;
        }
        .stock-low .stock-fill {
            background-color: #dc3545;
            width: 30%;
        }
        .stock-medium .stock-fill {
            background-color: #ffc107;
            width: 60%;
        }
        .stock-high .stock-fill {
            background-color: #28a745;
            width: 90%;
        }
        .stock-out .stock-fill {
            background-color: #6c757d;
            width: 5%;
        }
        .action-buttons .btn {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 2px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
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
                        <a class="nav-link active" href="barang.php">
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
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Administrator
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenu">
            <li><a class="dropdown-item" href="/pengaturan">Pengaturan</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/logout">Logout</a></li>
        </ul>
    </li>
</ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <!-- Statistik Ringkas -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card stats-card hover-shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Total Barang</h6>
                                <h3 class="mb-0 text-primary">
                                    <?php
                                    $query = "SELECT COUNT(*) as total FROM barang";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo number_format($data['total']);
                                    ?>
                                </h3>
                            </div>
                            <i class="fas fa-box fa-2x text-primary opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card stats-card hover-shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Total Stok</h6>
                                <h3 class="mb-0 text-primary">
                                    <?php
                                    $query = "SELECT SUM(stok) as total FROM barang";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo number_format($data['total'] ?: 0);
                                    ?>
                                </h3>
                            </div>
                            <i class="fas fa-cubes fa-2x text-primary opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card stats-card hover-shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Stok Rendah (< 10)</h6>
                                <h3 class="mb-0 text-danger">
                                    <?php
                                    $query = "SELECT COUNT(*) as total FROM barang WHERE stok < 10";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo number_format($data['total']);
                                    ?>
                                </h3>
                            </div>
                            <i class="fas fa-exclamation-triangle fa-2x text-danger opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card stats-card hover-shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Stok Habis</h6>
                                <h3 class="mb-0 text-secondary">
                                    <?php
                                    $query = "SELECT COUNT(*) as total FROM barang WHERE stok = 0";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo number_format($data['total']);
                                    ?>
                                </h3>
                            </div>
                            <i class="fas fa-times-circle fa-2x text-secondary opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Card -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-box me-2"></i> Data Barang
                        </h5>
                        <div>
                            <button class="btn btn-light btn-sm me-2" onclick="printTable()">
                                <i class="fas fa-print me-1"></i> Cetak
                            </button>
                            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#tambahBarangModal">
                                <i class="fas fa-plus me-1"></i> Tambah Barang
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        // Tampilkan pesan sukses/error
                        if (isset($_GET['pesan'])) {
                            $pesan = $_GET['pesan'];
                            if ($pesan == 'sukses_tambah') {
                                echo '<div class="alert alert-success alert-dismissible fade show">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Barang berhasil ditambahkan!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                      </div>';
                            } elseif ($pesan == 'sukses_edit') {
                                echo '<div class="alert alert-success alert-dismissible fade show">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Barang berhasil diupdate!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                      </div>';
                            } elseif ($pesan == 'sukses_hapus') {
                                echo '<div class="alert alert-success alert-dismissible fade show">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Barang berhasil dihapus!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                      </div>';
                            } elseif ($pesan == 'gagal') {
                                echo '<div class="alert alert-danger alert-dismissible fade show">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        Terjadi kesalahan!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                      </div>';
                            }
                        }
                        ?>
                        
                        <!-- Filter -->
                        <div class="row mb-3">
                         <div class="col-md-3">
                             <label class="form-label">Filter Kategori:</label>
                            <select class="form-select" id="filterKategori" onchange="applyFilters()">
                                 <option value="">Semua Kategori</option>
                                 <?php
                                 $query = "SELECT * FROM kategori ORDER BY nama_kategori";
                                 $result = mysqli_query($koneksi, $query);
                                 while ($kat = mysqli_fetch_assoc($result)) {
                                $selected = (isset($_GET['kategori']) && $_GET['kategori'] == $kat['id_kategori']) ? 'selected' : '';
                                     echo '<option value="' . $kat['id_kategori'] . '" ' . $selected . '>' . htmlspecialchars($kat['nama_kategori']) . '</option>';
                                 }
                                 ?>
                             </select>
                         </div>
                         <div class="col-md-3">
                            <label class="form-label">Filter Stok:</label>
                            <select class="form-select" id="filterStok" onchange="applyFilters()">
                                <option value="">Semua Stok</option>
                                <option value="low" <?php echo (isset($_GET['stok']) && $_GET['stok'] == 'low') ? 'selected' : ''; ?>>Rendah (< 10)</option>
                                <option value="out" <?php echo (isset($_GET['stok']) && $_GET['stok'] == 'out') ? 'selected' : ''; ?>>Habis (0)</option>
                                <option value="good" <?php echo (isset($_GET['stok']) && $_GET['stok'] == 'good') ? 'selected' : ''; ?>>Cukup (≥ 10)</option>
                            </select>
                         </div>
                         <div class="col-md-3">
                            <label class="form-label">Urutkan:</label>
                            <select class="form-select" id="sortBy" onchange="applyFilters()">
                                <option value="nama" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'nama') ? 'selected' : ''; ?>>Nama Barang A-Z</option>
                                <option value="stok_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'stok_asc') ? 'selected' : ''; ?>>Stok (Terendah)</option>
                                <option value="stok_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'stok_desc') ? 'selected' : ''; ?>>Stok (Tertinggi)</option>
                                <option value="harga_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'harga_asc') ? 'selected' : ''; ?>>Harga (Termurah)</option>
                                <option value="harga_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'harga_desc') ? 'selected' : ''; ?>>Harga (Termahal)</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                <!-- Tambahkan tombol reset filter -->
                        <button class="btn btn-outline-danger me-2" onclick="resetFilters()" title="Reset Filter">
                            <i class="fas fa-redo"></i>
                         </button>
                 <!-- Ubah tombol cetak di sini -->
                        <button class="btn btn-outline-success w-100" onclick="cetakLaporan()">
                            <i class="fas fa-print me-1"></i> Cetak Laporan
                         </button>
                        </div>
                    </div>
                        
                        <!-- Tabel Data Barang -->
                        <div class="table-responsive">
                            <table id="tabelBarang" class="table table-hover table-striped">
                                <thead class="table-light sticky-header">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th width="120">Stok</th>
                                        <th width="140">Harga Beli</th>
                                        <th width="140">Harga Jual</th>
                                        <th width="80">Satuan</th>
                                        <th width="100">Lokasi Rak</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT b.*, k.nama_kategori FROM barang b 
                                             LEFT JOIN kategori k ON b.id_kategori = k.id_kategori 
                                             ORDER BY b.nama_barang";
                                    $result = mysqli_query($koneksi, $query);
                                    $no = 1;
                                    $total_nilai_beli = 0;
                                    $total_nilai_jual = 0;
                                    
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $nilai_beli = $row['stok'] * $row['harga_beli'];
                                            $nilai_jual = $row['stok'] * $row['harga_jual'];
                                            $total_nilai_beli += $nilai_beli;
                                            $total_nilai_jual += $nilai_jual;
                                            
                                            // Tentukan kelas stok
                                            $stock_class = '';
                                            if ($row['stok'] == 0) {
                                                $stock_class = 'stock-out';
                                            } elseif ($row['stok'] < 10) {
                                                $stock_class = 'stock-low';
                                            } elseif ($row['stok'] < 50) {
                                                $stock_class = 'stock-medium';
                                            } else {
                                                $stock_class = 'stock-high';
                                            }
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no++; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($row['nama_barang']); ?></strong>
                                            <br>
                                            <small class="text-muted">ID: <?php echo $row['id_barang']; ?></small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?php echo htmlspecialchars($row['nama_kategori']); ?></span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="badge <?php 
                                                    if ($row['stok'] == 0) echo 'bg-secondary';
                                                    elseif ($row['stok'] < 10) echo 'bg-danger';
                                                    else echo 'bg-success';
                                                ?>">
                                                    <?php echo number_format($row['stok']); ?>
                                                </span>
                                                <div class="stock-indicator <?php echo $stock_class; ?>">
                                                    <div class="stock-fill"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-primary fw-bold">
                                                Rp <?php echo number_format($row['harga_beli'], 0, ',', '.'); ?>
                                            </div>
                                            <small class="text-muted">
                                                Total: Rp <?php echo number_format($nilai_beli, 0, ',', '.'); ?>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="text-success fw-bold">
                                                Rp <?php echo number_format($row['harga_jual'], 0, ',', '.'); ?>
                                            </div>
                                            <small class="text-muted">
                                                Total: Rp <?php echo number_format($nilai_jual, 0, ',', '.'); ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark">
                                                <?php echo htmlspecialchars($row['satuan']); ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($row['lokasi_rak']): ?>
                                                <span class="badge bg-dark">
                                                    <?php echo htmlspecialchars($row['lokasi_rak']); ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center action-buttons">
                                            <button class="btn btn-sm btn-warning edit-barang" 
                                                    data-id="<?php echo $row['id_barang']; ?>"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editBarangModal"
                                                    title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger hapus-barang" 
                                                    data-id="<?php echo $row['id_barang']; ?>"
                                                    data-nama="<?php echo htmlspecialchars($row['nama_barang']); ?>"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn btn-sm btn-info view-detail" 
                                                    data-id="<?php echo $row['id_barang']; ?>"
                                                    title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php 
                                        }
                                    } else {
                                        echo '<tr>
                                                <td colspan="9" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-box fa-2x mb-3"></i><br>
                                                        Belum ada data barang
                                                    </div>
                                                </td>
                                              </tr>';
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-primary">
                                        <td colspan="4" class="text-end fw-bold">TOTAL NILAI STOK:</td>
                                        <td class="fw-bold">
                                            Rp <?php echo number_format($total_nilai_beli, 0, ',', '.'); ?>
                                        </td>
                                        <td class="fw-bold">
                                            Rp <?php echo number_format($total_nilai_jual, 0, ',', '.'); ?>
                                        </td>
                                        <td colspan="3"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Barang -->
    <div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-labelledby="tambahBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tambahBarangModalLabel">
                        <i class="fas fa-plus me-2"></i> Tambah Barang Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../proses/barang_proses.php?aksi=tambah" method="POST" id="formTambahBarang">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-tag me-1"></i> Nama Barang <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="nama_barang" 
                                       placeholder="Masukkan nama barang" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-list me-1"></i> Kategori <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="id_kategori" required>
                                    <option value="">Pilih Kategori...</option>
                                    <?php
                                    $query = "SELECT * FROM kategori ORDER BY nama_kategori";
                                    $result = mysqli_query($koneksi, $query);
                                    while ($kat = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $kat['id_kategori'] . '">' . htmlspecialchars($kat['nama_kategori']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-cubes me-1"></i> Stok Awal <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control" name="stok" 
                                       value="0" required min="0" placeholder="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-money-bill me-1"></i> Harga Beli <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control" name="harga_beli" 
                                       required min="0" step="100" placeholder="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-money-bill-wave me-1"></i> Harga Jual <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control" name="harga_jual" 
                                       required min="0" step="100" placeholder="0">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-balance-scale me-1"></i> Satuan
                                </label>
                                <select class="form-select" name="satuan">
                                    <option value="pcs">Pcs</option>
                                    <option value="unit">Unit</option>
                                    <option value="set">Set</option>
                                    <option value="paket">Paket</option>
                                    <option value="box">Box</option>
                                    <option value="lusin">Lusin</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-map-marker-alt me-1"></i> Lokasi Rak
                                </label>
                                <input type="text" class="form-control" name="lokasi_rak" 
                                       placeholder="Contoh: A1, B2, C3, etc">
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Format: Huruf (rak) + Angka (posisi)
                                </div>
                            </div>
                        </div>
                        
                        <!-- Preview Harga -->
                        <div class="alert alert-info mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <small><strong>Margin:</strong> <span id="marginPreview">0%</span></small><br>
                                    <small><strong>Keuntungan:</strong> Rp <span id="keuntunganPreview">0</span></small>
                                </div>
                                <div class="col-md-6">
                                    <small><strong>Total Nilai Stok:</strong> Rp <span id="totalNilaiPreview">0</span></small><br>
                                    <small><strong>Status Stok:</strong> <span id="statusStokPreview" class="badge bg-success">CUKUP</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Barang -->
    <div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="editBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="editBarangModalLabel">
                        <i class="fas fa-edit me-2"></i> Edit Barang
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../proses/barang_proses.php?aksi=edit" method="POST" id="formEditBarang">
                    <input type="hidden" name="id_barang" id="edit_id_barang">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-tag me-1"></i> Nama Barang <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="nama_barang" id="edit_nama_barang" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-list me-1"></i> Kategori <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="id_kategori" id="edit_id_kategori" required>
                                    <option value="">Pilih Kategori...</option>
                                    <?php
                                    $query = "SELECT * FROM kategori ORDER BY nama_kategori";
                                    $result = mysqli_query($koneksi, $query);
                                    while ($kat = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $kat['id_kategori'] . '">' . htmlspecialchars($kat['nama_kategori']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-cubes me-1"></i> Stok <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control" name="stok" id="edit_stok" required min="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-money-bill me-1"></i> Harga Beli <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control" name="harga_beli" id="edit_harga_beli" required min="0" step="100">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-money-bill-wave me-1"></i> Harga Jual <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control" name="harga_jual" id="edit_harga_jual" required min="0" step="100">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-balance-scale me-1"></i> Satuan
                                </label>
                                <select class="form-select" name="satuan" id="edit_satuan">
                                    <option value="pcs">Pcs</option>
                                    <option value="unit">Unit</option>
                                    <option value="set">Set</option>
                                    <option value="paket">Paket</option>
                                    <option value="box">Box</option>
                                    <option value="lusin">Lusin</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-map-marker-alt me-1"></i> Lokasi Rak
                                </label>
                                <input type="text" class="form-control" name="lokasi_rak" id="edit_lokasi_rak">
                            </div>
                        </div>
                        
                        <!-- Preview Harga -->
                        <div class="alert alert-info mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <small><strong>Margin:</strong> <span id="edit_marginPreview">0%</span></small><br>
                                    <small><strong>Keuntungan:</strong> Rp <span id="edit_keuntunganPreview">0</span></small>
                                </div>
                                <div class="col-md-6">
                                    <small><strong>Total Nilai Stok:</strong> Rp <span id="edit_totalNilaiPreview">0</span></small><br>
                                    <small><strong>Status Stok:</strong> <span id="edit_statusStokPreview" class="badge bg-success">CUKUP</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Barang -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-info-circle me-2"></i> Detail Barang
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailContent">
                    <!-- Content akan diisi via JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

        <!-- JavaScript Libraries -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    // Fungsi untuk menerapkan filter
    function applyFilters() {
        const kategori = document.getElementById('filterKategori').value;
        const stok = document.getElementById('filterStok').value;
        const sort = document.getElementById('sortBy').value;
        
        // Redirect dengan parameter filter
        window.location.href = `barang.php?kategori=${kategori}&stok=${stok}&sort=${sort}`;
    }
    
    // Fungsi reset filter
    function resetFilters() {
        window.location.href = 'barang.php';
    }
    
    // Fungsi cetak laporan dengan filter
    function cetakLaporan() {
        const kategori = document.getElementById('filterKategori').value;
        const stok = document.getElementById('filterStok').value;
        const sort = document.getElementById('sortBy').value;
        
        // Buka halaman cetak dengan parameter filter
        window.open(`cetak_barang.php?kategori=${kategori}&stok=${stok}&sort=${sort}`, '_blank');
    }
    
    // Fungsi print tabel (untuk tombol cetak di header)
    function printTable() {
        // Ambil data filter
        const kategori = document.getElementById('filterKategori').value;
        const stok = document.getElementById('filterStok').value;
        const sort = document.getElementById('sortBy').value;
        
        // Buka halaman cetak dengan filter yang sama
        window.open(`cetak_barang.php?kategori=${kategori}&stok=${stok}&sort=${sort}`, '_blank');
    }
    
    // Inisialisasi DataTables dengan konfigurasi
    $(document).ready(function() {
        // Inisialisasi DataTables
        $('#tabelBarang').DataTable({
            "pageLength": 25,
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Berikutnya"
                }
            },
            "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
        });
        
        // Tambahkan preview harga di modal tambah
        $('input[name="harga_beli"], input[name="harga_jual"], input[name="stok"]').on('input', function() {
            updatePreview();
        });
        
        // Preview harga untuk modal edit
        $('#edit_harga_beli, #edit_harga_jual, #edit_stok').on('input', function() {
            updateEditPreview();
        });
        
        // Fungsi hapus barang dengan konfirmasi
        $(document).on('click', '.hapus-barang', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `Apakah Anda yakin ingin menghapus barang:<br><strong>${nama}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `../proses/barang_proses.php?aksi=hapus&id=${id}`;
                }
            });
        });
        
        // Fungsi untuk modal edit barang
        $(document).on('click', '.edit-barang', function() {
            const id = $(this).data('id');
            
            // AJAX untuk mengambil data barang
            $.ajax({
                url: '../proses/barang_proses.php',
                type: 'GET',
                data: { aksi: 'get_barang', id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Isi form edit
                        $('#edit_id_barang').val(response.data.id_barang);
                        $('#edit_nama_barang').val(response.data.nama_barang);
                        $('#edit_id_kategori').val(response.data.id_kategori);
                        $('#edit_stok').val(response.data.stok);
                        $('#edit_harga_beli').val(response.data.harga_beli);
                        $('#edit_harga_jual').val(response.data.harga_jual);
                        $('#edit_satuan').val(response.data.satuan);
                        $('#edit_lokasi_rak').val(response.data.lokasi_rak);
                        
                        // Update preview
                        updateEditPreview();
                    }
                }
            });
        });
    });
    
    // Fungsi preview harga modal tambah
    function updatePreview() {
        const hargaBeli = parseFloat($('input[name="harga_beli"]').val()) || 0;
        const hargaJual = parseFloat($('input[name="harga_jual"]').val()) || 0;
        const stok = parseInt($('input[name="stok"]').val()) || 0;
        
        // Hitung margin
        const margin = hargaBeli > 0 ? ((hargaJual - hargaBeli) / hargaBeli * 100).toFixed(2) : 0;
        const keuntungan = (hargaJual - hargaBeli) * stok;
        const totalNilai = hargaJual * stok;
        
        // Update preview
        $('#marginPreview').text(margin + '%');
        $('#keuntunganPreview').text(keuntungan.toLocaleString('id-ID'));
        $('#totalNilaiPreview').text(totalNilai.toLocaleString('id-ID'));
        
        // Update status stok
        const statusBadge = $('#statusStokPreview');
        if (stok == 0) {
            statusBadge.text('HABIS').removeClass().addClass('badge bg-secondary');
        } else if (stok < 10) {
            statusBadge.text('RENDAH').removeClass().addClass('badge bg-danger');
        } else {
            statusBadge.text('CUKUP').removeClass().addClass('badge bg-success');
        }
    }
    
    // Fungsi preview harga modal edit
    function updateEditPreview() {
        const hargaBeli = parseFloat($('#edit_harga_beli').val()) || 0;
        const hargaJual = parseFloat($('#edit_harga_jual').val()) || 0;
        const stok = parseInt($('#edit_stok').val()) || 0;
        
        // Hitung margin
        const margin = hargaBeli > 0 ? ((hargaJual - hargaBeli) / hargaBeli * 100).toFixed(2) : 0;
        const keuntungan = (hargaJual - hargaBeli) * stok;
        const totalNilai = hargaJual * stok;
        
        // Update preview
        $('#edit_marginPreview').text(margin + '%');
        $('#edit_keuntunganPreview').text(keuntungan.toLocaleString('id-ID'));
        $('#edit_totalNilaiPreview').text(totalNilai.toLocaleString('id-ID'));
        
        // Update status stok
        const statusBadge = $('#edit_statusStokPreview');
        if (stok == 0) {
            statusBadge.text('HABIS').removeClass().addClass('badge bg-secondary');
        } else if (stok < 10) {
            statusBadge.text('RENDAH').removeClass().addClass('badge bg-danger');
        } else {
            statusBadge.text('CUKUP').removeClass().addClass('badge bg-success');
        }
    }
    </script>
</body>
</html>