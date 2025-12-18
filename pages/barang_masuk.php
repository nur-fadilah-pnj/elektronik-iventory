<?php
require_once '../config/koneksi.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Masuk - Sistem Stok Barang Elektronik</title>
    
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
            border-color: #28a745;
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            transition: all 0.3s;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }
        .modal-header.bg-success {
            background-color: #28a745 !important;
            color: white;
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
            color: #28a745;
        }
        .pagination .page-item.active .page-link {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
        .stats-card {
            border-left: 4px solid #28a745;
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
                        <a class="nav-link active" href="barang_masuk.php">
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
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
                           data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="../proses/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a></li>
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
                                <h6 class="card-subtitle mb-2 text-muted">Total Barang Masuk</h6>
                                <h3 class="mb-0 text-success">
                                    <?php
                                    $query = "SELECT COUNT(*) as total FROM barang_masuk";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo $data['total'];
                                    ?>
                                </h3>
                            </div>
                            <i class="fas fa-arrow-down fa-2x text-success opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card stats-card hover-shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Total Unit Masuk</h6>
                                <h3 class="mb-0 text-success">
                                    <?php
                                    $query = "SELECT SUM(jumlah) as total FROM barang_masuk";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo $data['total'] ? number_format($data['total']) : '0';
                                    ?>
                                </h3>
                            </div>
                            <i class="fas fa-cubes fa-2x text-success opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card stats-card hover-shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Bulan Ini</h6>
                                <h3 class="mb-0 text-success">
                                    <?php
                                    $query = "SELECT SUM(jumlah) as total FROM barang_masuk 
                                             WHERE MONTH(tanggal_masuk) = MONTH(CURRENT_DATE())";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo $data['total'] ? number_format($data['total']) : '0';
                                    ?>
                                </h3>
                            </div>
                            <i class="fas fa-calendar-alt fa-2x text-success opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card stats-card hover-shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Hari Ini</h6>
                                <h3 class="mb-0 text-success">
                                    <?php
                                    $query = "SELECT SUM(jumlah) as total FROM barang_masuk 
                                             WHERE tanggal_masuk = CURDATE()";
                                    $result = mysqli_query($koneksi, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    echo $data['total'] ? number_format($data['total']) : '0';
                                    ?>
                                </h3>
                            </div>
                            <i class="fas fa-calendar-day fa-2x text-success opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Card -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-arrow-down me-2"></i> Data Barang Masuk
                        </h5>
                        <div>
                            <button class="btn btn-light btn-sm me-2" onclick="printTable()">
                                <i class="fas fa-print me-1"></i> Cetak
                            </button>
                            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#tambahMasukModal">
                                <i class="fas fa-plus me-1"></i> Tambah Barang Masuk
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        // Tampilkan pesan sukses/error
                        if (isset($_GET['pesan'])) {
                            $pesan = $_GET['pesan'];
                            if ($pesan == 'sukses') {
                                echo '<div class="alert alert-success alert-dismissible fade show">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Barang masuk berhasil dicatat!
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
                        
                        <!-- Filter Tanggal -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Filter Tanggal:</label>
                                <input type="date" class="form-control" id="filterTanggal" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                               
                                </button>
                            </div>
                        </div>
                        
                        <!-- Tabel Data Barang Masuk -->
                        <div class="table-responsive">
                            <table id="tabelMasuk" class="table table-hover table-striped">
                                <thead class="table-light sticky-header">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Barang</th>
                                        <th width="100">Jumlah</th>
                                        <th>Supplier</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Input</th>
                                        <th width="80">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT bm.*, b.nama_barang, b.stok FROM barang_masuk bm 
                                             JOIN barang b ON bm.id_barang = b.id_barang 
                                             ORDER BY bm.tanggal_masuk DESC";
                                    $result = mysqli_query($koneksi, $query);
                                    $no = 1;
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no++; ?></td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                <?php echo date('d/m/Y', strtotime($row['tanggal_masuk'])); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($row['nama_barang']); ?>
                                            <br>
                                            <small class="text-muted">
                                                Stok saat ini: <span class="badge bg-info"><?php echo $row['stok']; ?></span>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success">
                                                <?php echo number_format($row['jumlah']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['supplier'] ?: '-'); ?></td>
                                        <td>
                                            <?php echo htmlspecialchars($row['keterangan'] ?: '-'); ?>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-info" 
                                                    onclick="viewDetail(<?php echo $row['id_masuk']; ?>)"
                                                    title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php 
                                        }
                                    } else {
                                        echo '<tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-inbox fa-2x mb-3"></i><br>
                                                        Belum ada data barang masuk
                                                    </div>
                                                </td>
                                              </tr>';
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-success">
                                        <td colspan="3" class="text-end fw-bold">TOTAL:</td>
                                        <td class="text-center fw-bold">
                                            <?php
                                            $query_total = "SELECT SUM(jumlah) as total FROM barang_masuk";
                                            $result_total = mysqli_query($koneksi, $query_total);
                                            $total = mysqli_fetch_assoc($result_total);
                                            echo number_format($total['total'] ?: 0);
                                            ?>
                                        </td>
                                        <td colspan="4"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Barang Masuk -->
    <div class="modal fade" id="tambahMasukModal" tabindex="-1" aria-labelledby="tambahMasukModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="tambahMasukModalLabel">
                        <i class="fas fa-arrow-down me-2"></i> Tambah Barang Masuk
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../proses/barang_masuk_proses.php?aksi=tambah" method="POST" id="formMasuk">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-box me-1"></i> Barang <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="id_barang" id="selectBarang" required>
                                    <option value="">Pilih Barang...</option>
                                    <?php
                                    $query = "SELECT * FROM barang ORDER BY nama_barang";
                                    $result = mysqli_query($koneksi, $query);
                                    while ($barang = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $barang['id_barang'] . '" 
                                                data-stok="' . $barang['stok'] . '"
                                                data-harga="' . $barang['harga_beli'] . '">
                                                ' . htmlspecialchars($barang['nama_barang']) . ' 
                                                (Stok: ' . number_format($barang['stok']) . ')
                                              </option>';
                                    }
                                    ?>
                                </select>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Stok saat ini: <span id="stokSaatIni" class="fw-bold">0</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-hashtag me-1"></i> Jumlah <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control" name="jumlah" id="jumlah" 
                                       required min="1" placeholder="Masukkan jumlah" value="1">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar me-1"></i> Tanggal Masuk <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" name="tanggal_masuk" 
                                       value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-truck me-1"></i> Supplier
                                </label>
                                <input type="text" class="form-control" name="supplier" 
                                       placeholder="Nama supplier/perusahaan">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-sticky-note me-1"></i> Keterangan
                            </label>
                            <textarea class="form-control" name="keterangan" rows="3" 
                                      placeholder="Keterangan tambahan (No. Invoice, PO, dll)"></textarea>
                        </div>
                        
                        <!-- Info Perhitungan -->
                        <div class="alert alert-info mt-3" id="infoBarang" style="display: none;">
                            <div class="row">
                                <div class="col-md-4">
                                    <small><strong>Stok Saat Ini:</strong> <span id="infoStok">0</span></small>
                                </div>
                                <div class="col-md-4">
                                    <small><strong>Harga Beli:</strong> Rp <span id="infoHarga">0</span></small>
                                </div>
                                <div class="col-md-4">
                                    <small><strong>Total Nilai:</strong> Rp <span id="infoTotal">0</span></small>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <small><strong>Stok Setelah Masuk:</strong> <span id="infoStokBaru" class="fw-bold text-success">0</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-info-circle me-2"></i> Detail Barang Masuk
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
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        var table = $('#tabelMasuk').DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(disaring dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            "order": [[1, 'desc']],
            "pageLength": 10,
            "responsive": true,
            "dom": '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>'
        });
        
        // Update informasi barang saat dipilih
        $('#selectBarang').change(function() {
            var selectedOption = $(this).find(':selected');
            var stok = selectedOption.data('stok') || 0;
            var harga = selectedOption.data('harga') || 0;
            
            // Update tampilan
            $('#stokSaatIni').text(stok.toLocaleString('id-ID'));
            $('#jumlah').val(1);
            
            // Tampilkan info barang
            if (stok >= 0) {
                updateInfoBarang(stok, harga, 1);
                $('#infoBarang').show();
            } else {
                $('#infoBarang').hide();
            }
        });
        
        // Update info saat jumlah berubah
        $('#jumlah').on('input', function() {
            var stok = parseInt($('#selectBarang').find(':selected').data('stok') || 0);
            var harga = parseFloat($('#selectBarang').find(':selected').data('harga') || 0);
            var jumlah = parseInt($(this).val()) || 0;
            
            if (jumlah > 0 && stok >= 0) {
                updateInfoBarang(stok, harga, jumlah);
            }
        });
        
        // Fungsi update info barang
        function updateInfoBarang(stok, harga, jumlah) {
            var total = harga * jumlah;
            var stokBaru = parseInt(stok) + parseInt(jumlah);
            
            $('#infoStok').text(stok.toLocaleString('id-ID'));
            $('#infoHarga').text(harga.toLocaleString('id-ID'));
            $('#infoTotal').text(total.toLocaleString('id-ID'));
            $('#infoStokBaru').text(stokBaru.toLocaleString('id-ID'));
        }
        
        // Fungsi filter berdasarkan tanggal
        window.filterByDate = function() {
            var filterDate = $('#filterTanggal').val();
            if (filterDate) {
                // Format tanggal untuk pencarian
                var formattedDate = filterDate.split('-').reverse().join('/');
                table.search(formattedDate).draw();
            }
        };
        
        // Fungsi reset filter
        window.resetFilter = function() {
            $('#filterTanggal').val('');
            table.search('').draw();
        };
        
        // Fungsi print tabel
        window.printTable = function() {
            var printContents = document.getElementById('tabelMasuk').outerHTML;
            var originalContents = document.body.innerHTML;
            
            document.body.innerHTML = 
                '<html><head><title>Cetak Data Barang Masuk</title>' +
                '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">' +
                '</head><body>' +
                '<div class="container mt-4">' +
                '<h3 class="text-center mb-4">Laporan Barang Masuk</h3>' +
                '<p class="text-center">Tanggal: <?php echo date("d F Y"); ?></p>' +
                printContents +
                '</div></body></html>';
            
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        };
        
        // Fungsi view detail
        window.viewDetail = function(id) {
            $.ajax({
                url: '../proses/barang_masuk_proses.php',
                type: 'GET',
                data: {aksi: 'detail', id: id},
                success: function(response) {
                    $('#detailContent').html(response);
                    $('#detailModal').modal('show');
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: 'Gagal memuat detail data',
                        confirmButtonColor: '#28a745'
                    });
                }
            });
        };
        
        // Validasi form dengan SweetAlert
        $('#formMasuk').submit(function(e) {
            var jumlah = parseInt($('#jumlah').val());
            var barang = $('#selectBarang').val();
            
            // Validasi dasar
            if (!barang) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: 'Pilih barang terlebih dahulu!',
                    confirmButtonColor: '#28a745'
                });
                e.preventDefault();
                return false;
            }
            
            if (jumlah <= 0 || isNaN(jumlah)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: 'Jumlah harus lebih dari 0!',
                    confirmButtonColor: '#28a745'
                });
                e.preventDefault();
                return false;
            }
            
            // Konfirmasi sebelum submit
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Barang Masuk',
                html: 'Apakah Anda yakin ingin mencatat barang masuk?<br><br>' +
                      '<strong>' + $('#selectBarang').find(':selected').text() + '</strong><br>' +
                      'Jumlah: <strong>' + jumlah + '</strong><br>' +
                      'Tanggal: <strong>' + $('input[name="tanggal_masuk"]').val() + '</strong>',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form jika dikonfirmasi
                    $(this).unbind('submit').submit();
                }
            });
            
            return false;
        });
        
        // Auto-focus pada input pertama di modal
        $('#tambahMasukModal').on('shown.bs.modal', function () {
            $('#selectBarang').focus();
        });
        
        // Auto-hide alert setelah 5 detik
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    });
    </script>
</body>
</html>