<?php
require_once '../config/koneksi.php';
requireLogin();
// Ambil parameter filter dari URL
$filter_kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';
$filter_sort = isset($_GET['sort']) ? $_GET['sort'] : 'nama';

// Filter untuk stok
$where_stok = "WHERE 1=1";
if (!empty($filter_kategori)) {
    $where_stok .= " AND b.id_kategori = '" . mysqli_real_escape_string($koneksi, $filter_kategori) . "'";
}

if (!empty($filter_status)) {
    switch ($filter_status) {
        case 'rendah':
            $where_stok .= " AND b.stok < 10";
            break;
        case 'habis':
            $where_stok .= " AND b.stok = 0";
            break;
        case 'cukup':
            $where_stok .= " AND b.stok >= 10";
            break;
    }
}

switch ($filter_sort) {
    case 'stok_asc':
        $order_stok = "b.stok ASC";
        break;
    case 'stok_desc':
        $order_stok = "b.stok DESC";
        break;
    case 'harga_asc':
        $order_stok = "b.harga_beli ASC";
        break;
    case 'harga_desc':
        $order_stok = "b.harga_beli DESC";
        break;
    default:
        $order_stok = "b.nama_barang ASC";
}

// Filter untuk barang masuk
$where_masuk = "WHERE 1=1";
if (!empty($_GET['tanggal_dari_masuk'])) {
    $where_masuk .= " AND DATE(bm.tanggal_masuk) >= '" . mysqli_real_escape_string($koneksi, $_GET['tanggal_dari_masuk']) . "'";
}
if (!empty($_GET['tanggal_sampai_masuk'])) {
    $where_masuk .= " AND DATE(bm.tanggal_masuk) <= '" . mysqli_real_escape_string($koneksi, $_GET['tanggal_sampai_masuk']) . "'";
}
if (!empty($_GET['barang_masuk'])) {
    $where_masuk .= " AND bm.id_barang = '" . mysqli_real_escape_string($koneksi, $_GET['barang_masuk']) . "'";
}
if (!empty($_GET['supplier'])) {
    $where_masuk .= " AND bm.supplier LIKE '%" . mysqli_real_escape_string($koneksi, $_GET['supplier']) . "%'";
}

// Filter untuk barang keluar
$where_keluar = "WHERE 1=1";
if (!empty($_GET['tanggal_dari_keluar'])) {
    $where_keluar .= " AND DATE(bk.tanggal_keluar) >= '" . mysqli_real_escape_string($koneksi, $_GET['tanggal_dari_keluar']) . "'";
}
if (!empty($_GET['tanggal_sampai_keluar'])) {
    $where_keluar .= " AND DATE(bk.tanggal_keluar) <= '" . mysqli_real_escape_string($koneksi, $_GET['tanggal_sampai_keluar']) . "'";
}
if (!empty($_GET['barang_keluar'])) {
    $where_keluar .= " AND bk.id_barang = '" . mysqli_real_escape_string($koneksi, $_GET['barang_keluar']) . "'";
}
if (!empty($_GET['penerima'])) {
    $where_keluar .= " AND bk.penerima LIKE '%" . mysqli_real_escape_string($koneksi, $_GET['penerima']) . "%'";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Sistem Stok Barang Elektronik</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Date Range Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    
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
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 12px 20px;
            transition: all 0.3s;
        }
        .nav-tabs .nav-link.active {
            color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.1);
            border-bottom: 3px solid #0d6efd;
        }
        .nav-tabs .nav-link:hover {
            color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.05);
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
        .stats-card {
            border-left: 4px solid #0d6efd;
            transition: all 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 20px;
        }
        .daterangepicker {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .filter-box {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .export-buttons .btn {
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .summary-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .summary-card h3 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0;
        }
        .summary-card small {
            opacity: 0.9;
        }
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background-color: white;
        }
        .dataTables_wrapper {
            padding: 0;
        }
        .dt-buttons .btn {
            border-radius: 5px;
            font-weight: 500;
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
                        <a class="nav-link active" href="laporan.php">
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="summary-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small>NILAI STOK</small>
                            <h3>
                                <?php
                                $query = "SELECT SUM(stok * harga_beli) as total FROM barang";
                                $result = mysqli_query($koneksi, $query);
                                $data = mysqli_fetch_assoc($result);
                                echo 'Rp ' . number_format($data['total'] ?: 0, 0, ',', '.');
                                ?>
                            </h3>
                            <small>Berdasarkan harga beli</small>
                        </div>
                        <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="summary-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small>TOTAL BARANG</small>
                            <h3>
                                <?php
                                $query = "SELECT COUNT(*) as total FROM barang";
                                $result = mysqli_query($koneksi, $query);
                                $data = mysqli_fetch_assoc($result);
                                echo number_format($data['total']);
                                ?>
                            </h3>
                            <small>Jenis barang berbeda</small>
                        </div>
                        <i class="fas fa-box fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="summary-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small>BARANG MASUK</small>
                            <h3>
                                <?php
                                $query = "SELECT SUM(jumlah) as total FROM barang_masuk 
                                         WHERE MONTH(tanggal_masuk) = MONTH(CURRENT_DATE())";
                                $result = mysqli_query($koneksi, $query);
                                $data = mysqli_fetch_assoc($result);
                                echo number_format($data['total'] ?: 0);
                                ?>
                            </h3>
                            <small>Bulan ini</small>
                        </div>
                        <i class="fas fa-arrow-down fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="summary-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small>BARANG KELUAR</small>
                            <h3>
                                <?php
                                $query = "SELECT SUM(jumlah) as total FROM barang_keluar 
                                         WHERE MONTH(tanggal_keluar) = MONTH(CURRENT_DATE())";
                                $result = mysqli_query($koneksi, $query);
                                $data = mysqli_fetch_assoc($result);
                                echo number_format($data['total'] ?: 0);
                                ?>
                            </h3>
                            <small>Bulan ini</small>
                        </div>
                        <i class="fas fa-arrow-up fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Card -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2"></i> Laporan Sistem
                        </h5>
                        <button class="btn btn-light btn-sm" onclick="window.print()">
                            <i class="fas fa-print me-1"></i> Cetak Semua
                        </button>
                    </div>
                    <div class="card-body">
                        <!-- Tabs Navigation -->
                        <ul class="nav nav-tabs mb-4" id="laporanTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="stok-tab" data-bs-toggle="tab" data-bs-target="#stok" type="button">
                                    <i class="fas fa-box me-1"></i> Laporan Stok
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="masuk-tab" data-bs-toggle="tab" data-bs-target="#masuk" type="button">
                                    <i class="fas fa-arrow-down me-1"></i> Barang Masuk
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="keluar-tab" data-bs-toggle="tab" data-bs-target="#keluar" type="button">
                                    <i class="fas fa-arrow-up me-1"></i> Barang Keluar
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="grafik-tab" data-bs-toggle="tab" data-bs-target="#grafik" type="button">
                                 
                                </button>
                            </li>
                        </ul>
                        
                        <!-- Tabs Content -->
                        <div class="tab-content" id="laporanTabContent">
                            <!-- Tab Laporan Stok -->
                            <div class="tab-pane fade show active" id="stok" role="tabpanel">
                                <!-- Filter -->
                                <div class="filter-box mb-4">
                                    <div class="row align-items-end">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold">Filter Kategori:</label>
                                            <select class="form-select" id="filterKategoriStok">
                                                <option value="">Semua Kategori</option>
                                                <?php
                                                $query = "SELECT * FROM kategori ORDER BY nama_kategori";
                                                $result = mysqli_query($koneksi, $query);
                                                while ($kat = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $kat['id_kategori'] . '">' . htmlspecialchars($kat['nama_kategori']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold">Status Stok:</label>
                                            <select class="form-select" id="filterStatusStok">
                                                <option value="">Semua Status</option>
                                                <option value="rendah">Rendah (< 10)</option>
                                                <option value="habis">Habis (0)</option>
                                                <option value="cukup">Cukup (≥ 10)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold">Urutkan:</label>
                                            <select class="form-select" id="sortStok">
                                                <option value="nama">Nama A-Z</option>
                                                <option value="stok_asc">Stok Terendah</option>
                                                <option value="stok_desc">Stok Tertinggi</option>
                                                <option value="harga_asc">Harga Termurah</option>
                                                <option value="harga_desc">Harga Termahal</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            
                                                
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Tabel Stok -->
                                <div class="export-buttons mb-3">
                                    <button class="btn btn-outline-success btn-sm" onclick="exportToExcel('tabelStok')">
                                        <i class="fas fa-file-excel me-1"></i> Excel
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="exportToPDF()">
                                        <i class="fas fa-file-pdf me-1"></i> PDF
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="printStok()">
                                        <i class="fas fa-print me-1"></i> Cetak
                                    </button>
                                </div>
                                
                                <div class="table-responsive">
                                    <table id="tabelStok" class="table table-hover table-striped">
                                        <thead class="table-primary sticky-header">
                                            <tr>
                                                <th width="50">No</th>
                                                <th>Nama Barang</th>
                                                <th>Kategori</th>
                                                <th width="100">Stok</th>
                                                <th width="140">Harga Beli</th>
                                                <th width="140">Harga Jual</th>
                                                <th width="140">Nilai Stok (Beli)</th>
                                                <th width="140">Nilai Stok (Jual)</th>
                                                <th width="100">Lokasi Rak</th>
                                                <th width="80">Status</th>
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
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $nilai_beli = $row['stok'] * $row['harga_beli'];
                                                $nilai_jual = $row['stok'] * $row['harga_jual'];
                                                $total_nilai_beli += $nilai_beli;
                                                $total_nilai_jual += $nilai_jual;
                                                
                                                // Tentukan status stok
                                                $status_class = '';
                                                $status_text = '';
                                                if ($row['stok'] == 0) {
                                                    $status_class = 'bg-secondary';
                                                    $status_text = 'HABIS';
                                                } elseif ($row['stok'] < 10) {
                                                    $status_class = 'bg-danger';
                                                    $status_text = 'RENDAH';
                                                } elseif ($row['stok'] < 50) {
                                                    $status_class = 'bg-warning text-dark';
                                                    $status_text = 'CUKUP';
                                                } else {
                                                    $status_class = 'bg-success';
                                                    $status_text = 'AMAN';
                                                }
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($row['nama_barang']); ?></strong>
                                                    <br>
                                                    <small class="text-muted">ID: <?php echo $row['id_barang']; ?></small>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['nama_kategori']); ?></td>
                                                <td class="text-center">
                                                    <span class="badge <?php echo $status_class; ?>">
                                                        <?php echo number_format($row['stok']); ?>
                                                    </span>
                                                </td>
                                                <td class="text-end">Rp <?php echo number_format($row['harga_beli'], 0, ',', '.'); ?></td>
                                                <td class="text-end">Rp <?php echo number_format($row['harga_jual'], 0, ',', '.'); ?></td>
                                                <td class="text-end fw-bold">Rp <?php echo number_format($nilai_beli, 0, ',', '.'); ?></td>
                                                <td class="text-end fw-bold text-success">Rp <?php echo number_format($nilai_jual, 0, ',', '.'); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($row['lokasi_rak'] ?: '-'); ?></td>
                                                <td class="text-center">
                                                    <span class="badge <?php echo $status_class; ?>">
                                                        <?php echo $status_text; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot class="table-primary">
                                            <tr>
                                                <td colspan="6" class="text-end fw-bold">TOTAL:</td>
                                                <td class="text-end fw-bold">Rp <?php echo number_format($total_nilai_beli, 0, ',', '.'); ?></td>
                                                <td class="text-end fw-bold text-success">Rp <?php echo number_format($total_nilai_jual, 0, ',', '.'); ?></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Tab Barang Masuk -->
                            <div class="tab-pane fade" id="masuk" role="tabpanel">
                                <!-- Filter -->
                                <div class="filter-box mb-4">
                                    <div class="row align-items-end">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Rentang Tanggal:</label>
                                            <input type="text" class="form-control" id="dateRangeMasuk" placeholder="Pilih rentang tanggal">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold">Barang:</label>
                                            <select class="form-select" id="filterBarangMasuk">
                                                <option value="">Semua Barang</option>
                                                <?php
                                                $query = "SELECT id_barang, nama_barang FROM barang ORDER BY nama_barang";
                                                $result = mysqli_query($koneksi, $query);
                                                while ($barang = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $barang['id_barang'] . '">' . htmlspecialchars($barang['nama_barang']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold">Supplier:</label>
                                            <input type="text" class="form-control" id="filterSupplier" placeholder="Nama supplier">
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary w-100" onclick="filterMasuk()">
                                                <i class="fas fa-filter me-1"></i> Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Export Buttons -->
                                <div class="export-buttons mb-3">
                                    <button class="btn btn-outline-success btn-sm" onclick="exportToExcel('tabelMasuk')">
                                        <i class="fas fa-file-excel me-1"></i> Excel
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="printMasuk()">
                                        <i class="fas fa-print me-1"></i> Cetak
                                    </button>
                                </div>
                                
                                <!-- Tabel Barang Masuk -->
                                <div class="table-responsive">
                                    <table id="tabelMasuk" class="table table-hover table-striped">
                                        <thead class="table-success sticky-header">
                                            <tr>
                                                <th width="50">No</th>
                                                <th>Tanggal</th>
                                                <th>Nama Barang</th>
                                                <th width="100">Jumlah</th>
                                                <th>Supplier</th>
                                                <th>Keterangan</th>
                                                <th width="140">Tanggal Input</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT bm.*, b.nama_barang FROM barang_masuk bm 
                                                     JOIN barang b ON bm.id_barang = b.id_barang 
                                                     ORDER BY bm.tanggal_masuk DESC";
                                            $result = mysqli_query($koneksi, $query);
                                            $no = 1;
                                            $total_masuk = 0;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $total_masuk += $row['jumlah'];
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td>
                                                    <span class="badge bg-light text-dark">
                                                        <?php echo date('d/m/Y', strtotime($row['tanggal_masuk'])); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                                                <td class="text-center">
                                                    <span class="badge bg-success">
                                                        <?php echo number_format($row['jumlah']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['supplier'] ?: '-'); ?></td>
                                                <td><?php echo htmlspecialchars($row['keterangan'] ?: '-'); ?></td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?>
                                                    </small>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot class="table-success">
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold">TOTAL BARANG MASUK:</td>
                                                <td class="text-center fw-bold"><?php echo number_format($total_masuk); ?></td>
                                                <td colspan="3"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Tab Barang Keluar -->
                            <div class="tab-pane fade" id="keluar" role="tabpanel">
                                <!-- Filter -->
                                <div class="filter-box mb-4">
                                    <div class="row align-items-end">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Rentang Tanggal:</label>
                                            <input type="text" class="form-control" id="dateRangeKeluar" placeholder="Pilih rentang tanggal">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold">Barang:</label>
                                            <select class="form-select" id="filterBarangKeluar">
                                                <option value="">Semua Barang</option>
                                                <?php
                                                $query = "SELECT id_barang, nama_barang FROM barang ORDER BY nama_barang";
                                                $result = mysqli_query($koneksi, $query);
                                                while ($barang = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $barang['id_barang'] . '">' . htmlspecialchars($barang['nama_barang']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold">Penerima:</label>
                                            <input type="text" class="form-control" id="filterPenerima" placeholder="Nama penerima">
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary w-100" onclick="filterKeluar()">
                                                <i class="fas fa-filter me-1"></i> Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Export Buttons -->
                                <div class="export-buttons mb-3">
                                    <button class="btn btn-outline-success btn-sm" onclick="exportToExcel('tabelKeluar')">
                                        <i class="fas fa-file-excel me-1"></i> Excel
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="printKeluar()">
                                        <i class="fas fa-print me-1"></i> Cetak
                                    </button>
                                </div>
                                
                                <!-- Tabel Barang Keluar -->
                                <div class="table-responsive">
                                    <table id="tabelKeluar" class="table table-hover table-striped">
                                        <thead class="table-warning sticky-header">
                                            <tr>
                                                <th width="50">No</th>
                                                <th>Tanggal</th>
                                                <th>Nama Barang</th>
                                                <th width="100">Jumlah</th>
                                                <th>Penerima</th>
                                                <th>Keterangan</th>
                                                <th width="140">Tanggal Input</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT bk.*, b.nama_barang FROM barang_keluar bk 
                                                     JOIN barang b ON bk.id_barang = b.id_barang 
                                                     ORDER BY bk.tanggal_keluar DESC";
                                            $result = mysqli_query($koneksi, $query);
                                            $no = 1;
                                            $total_keluar = 0;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $total_keluar += $row['jumlah'];
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td>
                                                    <span class="badge bg-light text-dark">
                                                        <?php echo date('d/m/Y', strtotime($row['tanggal_keluar'])); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                                                <td class="text-center">
                                                    <span class="badge bg-warning text-dark">
                                                        <?php echo number_format($row['jumlah']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['penerima'] ?: '-'); ?></td>
                                                <td><?php echo htmlspecialchars($row['keterangan'] ?: '-'); ?></td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?>
                                                    </small>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <!-- Tambahkan script ini setelah library yang sudah ada -->
                                            <script>
                                            $(document).ready(function() {
                                                // Inisialisasi Date Range Pickers
                                                $('#dateRangeMasuk').daterangepicker({
                                                    locale: {
                                                        format: 'YYYY-MM-DD',
                                                        separator: ' s/d ',
                                                        applyLabel: 'Terapkan',
                                                        cancelLabel: 'Batal',
                                                        fromLabel: 'Dari',
                                                        toLabel: 'Sampai',
                                                        daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                                                        monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                                                                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                                                        firstDay: 1
                                                    }
                                                });
                                                
                                                $('#dateRangeKeluar').daterangepicker({
                                                    locale: {
                                                        format: 'YYYY-MM-DD',
                                                        separator: ' s/d ',
                                                        applyLabel: 'Terapkan',
                                                        cancelLabel: 'Batal',
                                                        fromLabel: 'Dari',
                                                        toLabel: 'Sampai',
                                                        daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                                                        monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                                                                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                                                        firstDay: 1
                                                    }
                                                });
                                                
                                                // Inisialisasi DataTables untuk semua tabel
                                                initDataTables();
                                                
                                                // Inisialisasi Chart
                                                initCharts();
                                            });

                                            // ====================================
                                            // FUNGSI FILTER
                                            // ====================================

                                            function filterStok() {
                                                const kategori = $('#filterKategoriStok').val();
                                                const status = $('#filterStatusStok').val();
                                                const sort = $('#sortStok').val();
                                                
                                                // Redirect dengan parameter filter
                                                let params = [];
                                                if (kategori) params.push(`kategori=${kategori}`);
                                                if (status) params.push(`status=${status}`);
                                                if (sort) params.push(`sort=${sort}`);
                                                
                                                window.location.href = params.length > 0 
                                                    ? `laporan.php?tab=stok&${params.join('&')}` 
                                                    : 'laporan.php?tab=stok';
                                            }

                                            function filterMasuk() {
                                                const dateRange = $('#dateRangeMasuk').val();
                                                const barang = $('#filterBarangMasuk').val();
                                                const supplier = $('#filterSupplier').val();
                                                
                                                // Bagi date range menjadi tanggal dari dan sampai
                                                let tanggal_dari = '';
                                                let tanggal_sampai = '';
                                                
                                                if (dateRange.includes(' s/d ')) {
                                                    const dates = dateRange.split(' s/d ');
                                                    tanggal_dari = dates[0];
                                                    tanggal_sampai = dates[1];
                                                }
                                                
                                                // Redirect dengan parameter filter
                                                let params = [];
                                                if (tanggal_dari) params.push(`tanggal_dari_masuk=${tanggal_dari}`);
                                                if (tanggal_sampai) params.push(`tanggal_sampai_masuk=${tanggal_sampai}`);
                                                if (barang) params.push(`barang_masuk=${barang}`);
                                                if (supplier) params.push(`supplier=${supplier}`);
                                                
                                                // Aktifkan tab masuk
                                                params.push('tab=masuk');
                                                
                                                window.location.href = params.length > 0 
                                                    ? `laporan.php?${params.join('&')}` 
                                                    : 'laporan.php?tab=masuk';
                                            }

                                            function filterKeluar() {
                                                const dateRange = $('#dateRangeKeluar').val();
                                                const barang = $('#filterBarangKeluar').val();
                                                const penerima = $('#filterPenerima').val();
                                                
                                                // Bagi date range menjadi tanggal dari dan sampai
                                                let tanggal_dari = '';
                                                let tanggal_sampai = '';
                                                
                                                if (dateRange.includes(' s/d ')) {
                                                    const dates = dateRange.split(' s/d ');
                                                    tanggal_dari = dates[0];
                                                    tanggal_sampai = dates[1];
                                                }
                                                
                                                // Redirect dengan parameter filter
                                                let params = [];
                                                if (tanggal_dari) params.push(`tanggal_dari_keluar=${tanggal_dari}`);
                                                if (tanggal_sampai) params.push(`tanggal_sampai_keluar=${tanggal_sampai}`);
                                                if (barang) params.push(`barang_keluar=${barang}`);
                                                if (penerima) params.push(`penerima=${penerima}`);
                                                
                                                // Aktifkan tab keluar
                                                params.push('tab=keluar');
                                                
                                                window.location.href = params.length > 0 
                                                    ? `laporan.php?${params.join('&')}` 
                                                    : 'laporan.php?tab=keluar';
                                            }

                                            // ====================================
                                            // FUNGSI EXPORT DAN CETAK
                                            // ====================================

                                            function exportToExcel(tableId) {
                                                const table = document.getElementById(tableId);
                                                
                                                // Buat workbook dari tabel
                                                const wb = XLSX.utils.book_new();
                                                const ws = XLSX.utils.table_to_sheet(table);
                                                
                                                // Tambahkan worksheet ke workbook
                                                XLSX.utils.book_append_sheet(wb, ws, "Laporan");
                                                
                                                // Simpan file
                                                const fileName = getFileName(tableId);
                                                XLSX.writeFile(wb, `${fileName}.xlsx`);
                                            }

                                            function exportToPDF() {
                                                alert('Fitur export PDF memerlukan library tambahan. Untuk sementara gunakan fitur Print lalu pilih "Save as PDF".');
                                                
                                                // Alternatif: Gunakan window.print() untuk cetak sebagai PDF
                                                window.print();
                                            }

                                            function printStok() {
                                                // Set judul untuk print
                                                const originalTitle = document.title;
                                                document.title = "Laporan Stok Barang - " + new Date().toLocaleDateString('id-ID');
                                                
                                                // Cetak hanya bagian stok
                                                const printContent = document.getElementById('stok').innerHTML;
                                                const originalBody = document.body.innerHTML;
                                                
                                                document.body.innerHTML = `
                                                    <div style="padding: 20px;">
                                                        <h2>Laporan Stok Barang</h2>
                                                        <p>Dicetak pada: ${new Date().toLocaleDateString('id-ID', { 
                                                            weekday: 'long', 
                                                            year: 'numeric', 
                                                            month: 'long', 
                                                            day: 'numeric',
                                                            hour: '2-digit',
                                                            minute: '2-digit'
                                                        })}</p>
                                                        <hr>
                                                        ${printContent}
                                                    </div>
                                                `;
                                                
                                                window.print();
                                                document.body.innerHTML = originalBody;
                                                document.title = originalTitle;
                                                location.reload(); // Reload untuk kembali ke tampilan normal
                                            }

                                            function printMasuk() {
                                                const originalTitle = document.title;
                                                document.title = "Laporan Barang Masuk - " + new Date().toLocaleDateString('id-ID');
                                                
                                                const printContent = document.getElementById('masuk').innerHTML;
                                                const originalBody = document.body.innerHTML;
                                                
                                                document.body.innerHTML = `
                                                    <div style="padding: 20px;">
                                                        <h2>Laporan Barang Masuk</h2>
                                                        <p>Dicetak pada: ${new Date().toLocaleDateString('id-ID', { 
                                                            weekday: 'long', 
                                                            year: 'numeric', 
                                                            month: 'long', 
                                                            day: 'numeric',
                                                            hour: '2-digit',
                                                            minute: '2-digit'
                                                        })}</p>
                                                        <hr>
                                                        ${printContent}
                                                    </div>
                                                `;
                                                
                                                window.print();
                                                document.body.innerHTML = originalBody;
                                                document.title = originalTitle;
                                                location.reload();
                                            }

                                            function printKeluar() {
                                                const originalTitle = document.title;
                                                document.title = "Laporan Barang Keluar - " + new Date().toLocaleDateString('id-ID');
                                                
                                                const printContent = document.getElementById('keluar').innerHTML;
                                                const originalBody = document.body.innerHTML;
                                                
                                                document.body.innerHTML = `
                                                    <div style="padding: 20px;">
                                                        <h2>Laporan Barang Keluar</h2>
                                                        <p>Dicetak pada: ${new Date().toLocaleDateString('id-ID', { 
                                                            weekday: 'long', 
                                                            year: 'numeric', 
                                                            month: 'long', 
                                                            day: 'numeric',
                                                            hour: '2-digit',
                                                            minute: '2-digit'
                                                        })}</p>
                                                        <hr>
                                                        ${printContent}
                                                    </div>
                                                `;
                                                
                                                window.print();
                                                document.body.innerHTML = originalBody;
                                                document.title = originalTitle;
                                                location.reload();
                                            }

                                            function getFileName(tableId) {
                                                const now = new Date();
                                                const dateStr = now.toISOString().split('T')[0];
                                                const timeStr = now.getHours().toString().padStart(2, '0') + 
                                                            now.getMinutes().toString().padStart(2, '0');
                                                
                                                let fileName = '';
                                                switch(tableId) {
                                                    case 'tabelStok':
                                                        fileName = `Laporan_Stok_${dateStr}_${timeStr}`;
                                                        break;
                                                    case 'tabelMasuk':
                                                        fileName = `Laporan_Barang_Masuk_${dateStr}_${timeStr}`;
                                                        break;
                                                    case 'tabelKeluar':
                                                        fileName = `Laporan_Barang_Keluar_${dateStr}_${timeStr}`;
                                                        break;
                                                    default:
                                                        fileName = `Laporan_${dateStr}_${timeStr}`;
                                                }
                                                
                                                return fileName;
                                            }

                                            // ====================================
                                            // INISIALISASI DATATABLES
                                            // ====================================

                                            function initDataTables() {
                                                // Inisialisasi DataTable untuk setiap tabel
                                                $('#tabelStok').DataTable({
                                                    "pageLength": 25,
                                                    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                                                    "language": {
                                                        "lengthMenu": "Tampilkan _MENU_ data",
                                                        "zeroRecords": "Tidak ada data",
                                                        "info": "Halaman _PAGE_ dari _PAGES_",
                                                        "infoEmpty": "Tidak ada data",
                                                        "infoFiltered": "(filter dari _MAX_ total data)",
                                                        "search": "Cari:",
                                                        "paginate": {
                                                            "first": "Pertama",
                                                            "last": "Terakhir",
                                                            "next": "Selanjutnya",
                                                            "previous": "Sebelumnya"
                                                        }
                                                    },
                                                    "dom": 'Bfrtip',
                                                    "buttons": [
                                                        {
                                                            extend: 'excel',
                                                            text: '<i class="fas fa-file-excel"></i> Excel',
                                                            className: 'btn btn-success btn-sm',
                                                            title: 'Laporan Stok'
                                                        },
                                                        {
                                                            extend: 'print',
                                                            text: '<i class="fas fa-print"></i> Cetak',
                                                            className: 'btn btn-secondary btn-sm',
                                                            title: 'Laporan Stok'
                                                        }
                                                    ]
                                                });
                                                
                                                $('#tabelMasuk').DataTable({
                                                    "pageLength": 25,
                                                    "order": [[1, 'desc']],
                                                    "language": {
                                                        "lengthMenu": "Tampilkan _MENU_ data",
                                                        "zeroRecords": "Tidak ada data",
                                                        "info": "Halaman _PAGE_ dari _PAGES_",
                                                        "infoEmpty": "Tidak ada data",
                                                        "infoFiltered": "(filter dari _MAX_ total data)",
                                                        "search": "Cari:",
                                                        "paginate": {
                                                            "first": "Pertama",
                                                            "last": "Terakhir",
                                                            "next": "Selanjutnya",
                                                            "previous": "Sebelumnya"
                                                        }
                                                    }
                                                });
                                                
                                                $('#tabelKeluar').DataTable({
                                                    "pageLength": 25,
                                                    "order": [[1, 'desc']],
                                                    "language": {
                                                        "lengthMenu": "Tampilkan _MENU_ data",
                                                        "zeroRecords": "Tidak ada data",
                                                        "info": "Halaman _PAGE_ dari _PAGES_",
                                                        "infoEmpty": "Tidak ada data",
                                                        "infoFiltered": "(filter dari _MAX_ total data)",
                                                        "search": "Cari:",
                                                        "paginate": {
                                                            "first": "Pertama",
                                                            "last": "Terakhir",
                                                            "next": "Selanjutnya",
                                                            "previous": "Sebelumnya"
                                                        }
                                                    }
                                                });
                                            }

                                            // ====================================
                                            // INISIALISASI CHART
                                            // ====================================

                                            function initCharts() {
                                                // Pie Chart - Distribusi Stok per Kategori
                                                const pieCtx = document.getElementById('pieChart').getContext('2d');
                                                
                                                <?php
                                                // Query untuk data pie chart
                                                $query = "SELECT k.nama_kategori, SUM(b.stok) as total_stok 
                                                        FROM barang b 
                                                        LEFT JOIN kategori k ON b.id_kategori = k.id_kategori 
                                                        GROUP BY k.nama_kategori 
                                                        ORDER BY total_stok DESC";
                                                $result = mysqli_query($koneksi, $query);
                                                
                                                $kategori_labels = [];
                                                $stok_data = [];
                                                $background_colors = [
                                                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', 
                                                    '#9966FF', '#FF9F40', '#8AC926', '#1982C4',
                                                    '#6A4C93', '#F15BB5'
                                                ];
                                                
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $kategori_labels[] = $row['nama_kategori'] ?: 'Tanpa Kategori';
                                                    $stok_data[] = $row['total_stok'];
                                                }
                                                ?>
                                                
                                                const pieChart = new Chart(pieCtx, {
                                                    type: 'pie',
                                                    data: {
                                                        labels: <?php echo json_encode($kategori_labels); ?>,
                                                        datasets: [{
                                                            data: <?php echo json_encode($stok_data); ?>,
                                                            backgroundColor: <?php echo json_encode(array_slice($background_colors, 0, count($kategori_labels))); ?>,
                                                            borderWidth: 1
                                                        }]
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
                                                        plugins: {
                                                            legend: {
                                                                position: 'right',
                                                            },
                                                            tooltip: {
                                                                callbacks: {
                                                                    label: function(context) {
                                                                        let label = context.label || '';
                                                                        if (label) {
                                                                            label += ': ';
                                                                        }
                                                                        label += context.raw.toLocaleString('id-ID') + ' unit';
                                                                        return label;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                });
                                                
                                                // Bar Chart - 10 Barang dengan Stok Terbanyak
                                                const barCtx = document.getElementById('barChart').getContext('2d');
                                                
                                                <?php
                                                $query = "SELECT nama_barang, stok FROM barang 
                                                        ORDER BY stok DESC LIMIT 10";
                                                $result = mysqli_query($koneksi, $query);
                                                
                                                $barang_labels = [];
                                                $barang_stok = [];
                                                
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $barang_labels[] = $row['nama_barang'];
                                                    $barang_stok[] = $row['stok'];
                                                }
                                                ?>
                                                
                                                const barChart = new Chart(barCtx, {
                                                    type: 'bar',
                                                    data: {
                                                        labels: <?php echo json_encode($barang_labels); ?>,
                                                        datasets: [{
                                                            label: 'Stok',
                                                            data: <?php echo json_encode($barang_stok); ?>,
                                                            backgroundColor: '#36A2EB',
                                                            borderColor: '#1E88E5',
                                                            borderWidth: 1
                                                        }]
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
                                                        scales: {
                                                            y: {
                                                                beginAtZero: true,
                                                                ticks: {
                                                                    callback: function(value) {
                                                                        return value.toLocaleString('id-ID');
                                                                    }
                                                                }
                                                            }
                                                        },
                                                        plugins: {
                                                            legend: {
                                                                display: false
                                                            },
                                                            tooltip: {
                                                                callbacks: {
                                                                    label: function(context) {
                                                                        return 'Stok: ' + context.raw.toLocaleString('id-ID') + ' unit';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                });
                                                
                                                // Line Chart - Trend 30 Hari
                                                const lineCtx = document.getElementById('lineChart').getContext('2d');
                                                
                                                <?php
                                                // Data untuk 30 hari terakhir
                                                $labels = [];
                                                $masuk_data = [];
                                                $keluar_data = [];
                                                
                                                for ($i = 29; $i >= 0; $i--) {
                                                    $date = date('Y-m-d', strtotime("-$i days"));
                                                    $labels[] = date('d M', strtotime($date));
                                                    
                                                    // Query barang masuk
                                                    $query_masuk = "SELECT SUM(jumlah) as total FROM barang_masuk 
                                                                WHERE DATE(tanggal_masuk) = '$date'";
                                                    $result_masuk = mysqli_query($koneksi, $query_masuk);
                                                    $masuk = mysqli_fetch_assoc($result_masuk);
                                                    $masuk_data[] = $masuk['total'] ?: 0;
                                                    
                                                    // Query barang keluar
                                                    $query_keluar = "SELECT SUM(jumlah) as total FROM barang_keluar 
                                                                    WHERE DATE(tanggal_keluar) = '$date'";
                                                    $result_keluar = mysqli_query($koneksi, $query_keluar);
                                                    $keluar = mysqli_fetch_assoc($result_keluar);
                                                    $keluar_data[] = $keluar['total'] ?: 0;
                                                }
                                                ?>
                                                
                                                const lineChart = new Chart(lineCtx, {
                                                    type: 'line',
                                                    data: {
                                                        labels: <?php echo json_encode($labels); ?>,
                                                        datasets: [
                                                            {
                                                                label: 'Barang Masuk',
                                                                data: <?php echo json_encode($masuk_data); ?>,
                                                                borderColor: '#4CAF50',
                                                                backgroundColor: 'rgba(76, 175, 80, 0.1)',
                                                                tension: 0.4,
                                                                fill: true
                                                            },
                                                            {
                                                                label: 'Barang Keluar',
                                                                data: <?php echo json_encode($keluar_data); ?>,
                                                                borderColor: '#FF9800',
                                                                backgroundColor: 'rgba(255, 152, 0, 0.1)',
                                                                tension: 0.4,
                                                                fill: true
                                                            }
                                                        ]
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
                                                        scales: {
                                                            y: {
                                                                beginAtZero: true,
                                                                ticks: {
                                                                    callback: function(value) {
                                                                        return value.toLocaleString('id-ID');
                                                                    }
                                                                }
                                                            }
                                                        },
                                                        plugins: {
                                                            tooltip: {
                                                                callbacks: {
                                                                    label: function(context) {
                                                                        return context.dataset.label + ': ' + context.raw.toLocaleString('id-ID') + ' unit';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                });
                                            }

                                            // ====================================
                                            // FUNGSI UNTUK MEMPERTAHANKAN TAB AKTIF
                                            // ====================================

                                            // Cek parameter tab di URL untuk menentukan tab aktif
                                            $(document).ready(function() {
                                                const urlParams = new URLSearchParams(window.location.search);
                                                const activeTab = urlParams.get('tab');
                                                
                                                if (activeTab) {
                                                    // Nonaktifkan semua tab
                                                    $('#stok-tab, #masuk-tab, #keluar-tab, #grafik-tab').removeClass('active');
                                                    $('#stok, #masuk, #keluar, #grafik').removeClass('show active');
                                                    
                                                    // Aktifkan tab yang dipilih
                                                    $(`#${activeTab}-tab`).addClass('active');
                                                    $(`#${activeTab}`).addClass('show active');
                                                }
                                            });

                                            // Fungsi untuk apply filter dari URL parameter
                                            function applyFilterFromUrl() {
                                                const urlParams = new URLSearchParams(window.location.search);
                                                
                                                // Terapkan filter untuk stok
                                                if (urlParams.get('kategori')) {
                                                    $('#filterKategoriStok').val(urlParams.get('kategori'));
                                                }
                                                if (urlParams.get('status')) {
                                                    $('#filterStatusStok').val(urlParams.get('status'));
                                                }
                                                if (urlParams.get('sort')) {
                                                    $('#sortStok').val(urlParams.get('sort'));
                                                }
                                                
                                                // Terapkan filter untuk masuk
                                                if (urlParams.get('tanggal_dari_masuk') && urlParams.get('tanggal_sampai_masuk')) {
                                                    const dateRange = `${urlParams.get('tanggal_dari_masuk')} s/d ${urlParams.get('tanggal_sampai_masuk')}`;
                                                    $('#dateRangeMasuk').val(dateRange);
                                                }
                                                if (urlParams.get('barang_masuk')) {
                                                    $('#filterBarangMasuk').val(urlParams.get('barang_masuk'));
                                                }
                                                if (urlParams.get('supplier')) {
                                                    $('#filterSupplier').val(urlParams.get('supplier'));
                                                }
                                                
                                                // Terapkan filter untuk keluar
                                                if (urlParams.get('tanggal_dari_keluar') && urlParams.get('tanggal_sampai_keluar')) {
                                                    const dateRange = `${urlParams.get('tanggal_dari_keluar')} s/d ${urlParams.get('tanggal_sampai_keluar')}`;
                                                    $('#dateRangeKeluar').val(dateRange);
                                                }
                                                if (urlParams.get('barang_keluar')) {
                                                    $('#filterBarangKeluar').val(urlParams.get('barang_keluar'));
                                                }
                                                if (urlParams.get('penerima')) {
                                                    $('#filterPenerima').val(urlParams.get('penerima'));
                                                }
                                            }

                                            // Panggil fungsi untuk menerapkan filter dari URL saat halaman dimuat
                                            $(document).ready(function() {
                                                applyFilterFromUrl();
                                            });
                                            </script>
                                        </tbody>
                                        <tfoot class="table-warning">
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold">TOTAL BARANG KELUAR:</td>
                                                <td class="text-center fw-bold"><?php echo number_format($total_keluar); ?></td>
                                                <td colspan="3"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Tab Grafik -->
                            <div class="tab-pane fade" id="grafik" role="tabpanel">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i> Distribusi Stok per Kategori</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart-container">
                                                    <canvas id="pieChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i> 10 Barang dengan Stok Terbanyak</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart-container">
                                                    <canvas id="barChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0"><i class="fas fa-chart-line me-2"></i> Trend Barang Masuk & Keluar (30 Hari)</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart-container" style="height: 400px;">
                                                    <canvas id="lineChart"></canvas>
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
    
    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    
    <!-- Date Range Picker -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- SheetJS for Excel export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // Initialize Date Range Pickers
        $('#dateRangeMasuk').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                separator: ' s/d ',
                applyLabel: 'Terapkan',
                cancelLabel: 'Batal',
                fromLabel: 'Dari',
                toLabel: 'Sampai',
                customRangeLabel: 'Kustom',
                daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                firstDay: 1
            }
        });
        
        $('#dateRangeKeluar').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                separator: ' s/d ',
                applyLabel: 'Terapkan',
                cancelLabel: 'Batal',
                fromLabel: 'Dari',
                toLabel: 'Sampai',
               