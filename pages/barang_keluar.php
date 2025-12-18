<?php
require_once '../config/koneksi.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Keluar - Sistem Stok Barang Elektronik</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
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
        }
        .badge {
            font-size: 0.85em;
            padding: 5px 10px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
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
            color: #ffc107;
        }
        .pagination .page-item.active .page-link {
            background-color: #ffc107;
            border-color: #ffc107;
            color: white;
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
                        <a class="nav-link active" href="barang_keluar.php">
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-arrow-up me-2"></i> Barang Keluar
                        </h5>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahKeluarModal">
                            <i class="fas fa-plus me-1"></i> Tambah Barang Keluar
                        </button>
                    </div>
                    <div class="card-body">
                        <?php
                        // Tampilkan pesan sukses/error
                        if (isset($_GET['pesan'])) {
                            $pesan = $_GET['pesan'];
                            if ($pesan == 'sukses') {
                                echo '<div class="alert alert-success alert-dismissible fade show">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Barang keluar berhasil dicatat!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                      </div>';
                            } elseif ($pesan == 'gagal') {
                                echo '<div class="alert alert-danger alert-dismissible fade show">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        Terjadi kesalahan!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                      </div>';
                            } elseif ($pesan == 'stok_kurang') {
                                echo '<div class="alert alert-warning alert-dismissible fade show">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Stok tidak mencukupi!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                      </div>';
                            }
                        }
                        ?>
                        
                        <!-- Tabel Data Barang Keluar -->
                        <div class="table-responsive">
                            <table id="tabelKeluar" class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Barang</th>
                                        <th width="100">Jumlah</th>
                                        <th>Penerima</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Input</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT bk.*, b.nama_barang FROM barang_keluar bk 
                                             JOIN barang b ON bk.id_barang = b.id_barang 
                                             ORDER BY bk.tanggal_keluar DESC";
                                    $result = mysqli_query($koneksi, $query);
                                    $no = 1;
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
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
                                                <?php echo $row['jumlah']; ?>
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
                                    <?php 
                                        }
                                    } else {
                                        echo '<tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-inbox fa-2x mb-3"></i><br>
                                                        Belum ada data barang keluar
                                                    </div>
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
    </div>

    <!-- Modal Tambah Barang Keluar -->
    <div class="modal fade" id="tambahKeluarModal" tabindex="-1" aria-labelledby="tambahKeluarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="tambahKeluarModalLabel">
                        <i class="fas fa-arrow-up me-2"></i> Tambah Barang Keluar
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../proses/barang_keluar_proses.php?aksi=tambah" method="POST" id="formKeluar">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-box me-1"></i> Barang <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="id_barang" id="selectBarangKeluar" required>
                                    <option value="">Pilih Barang...</option>
                                    <?php
                                    $query = "SELECT * FROM barang WHERE stok > 0 ORDER BY nama_barang";
                                    $result = mysqli_query($koneksi, $query);
                                    while ($barang = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $barang['id_barang'] . '" 
                                                data-stok="' . $barang['stok'] . '"
                                                data-harga="' . $barang['harga_jual'] . '">
                                                ' . htmlspecialchars($barang['nama_barang']) . ' 
                                                (Stok: ' . $barang['stok'] . ')
                                              </option>';
                                    }
                                    ?>
                                </select>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Stok tersedia: <span id="stokTersedia" class="fw-bold">0</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-hashtag me-1"></i> Jumlah <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control" name="jumlah" id="jumlahKeluar" 
                                       required min="1" placeholder="Masukkan jumlah">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar me-1"></i> Tanggal Keluar <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" name="tanggal_keluar" 
                                       value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user me-1"></i> Penerima
                                </label>
                                <input type="text" class="form-control" name="penerima" 
                                       placeholder="Nama penerima">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-sticky-note me-1"></i> Keterangan
                            </label>
                            <textarea class="form-control" name="keterangan" rows="3" 
                                      placeholder="Keterangan pengeluaran barang"></textarea>
                        </div>
                        
                        <!-- Info Barang -->
                        <div class="alert alert-info mt-3" id="infoBarang" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <small><strong>Stok Tersedia:</strong> <span id="infoStok">0</span></small><br>
                                    <small><strong>Harga Jual:</strong> Rp <span id="infoHarga">0</span></small>
                                </div>
                                <div class="col-md-6">
                                    <small><strong>Total Nilai:</strong> Rp <span id="infoTotal">0</span></small><br>
                                    <small><strong>Sisa Stok:</strong> <span id="infoSisa">0</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
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
    
    <!-- SweetAlert2 (Optional untuk notifikasi yang lebih baik) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        $('#tabelKeluar').DataTable({
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
            "responsive": true
        });
        
        // Update informasi barang saat dipilih
        $('#selectBarangKeluar').change(function() {
            var selectedOption = $(this).find(':selected');
            var stok = selectedOption.data('stok') || 0;
            var harga = selectedOption.data('harga') || 0;
            
            // Update tampilan
            $('#stokTersedia').text(stok);
            $('#jumlahKeluar').attr('max', stok);
            $('#jumlahKeluar').val(1);
            
            // Tampilkan info barang
            if (stok > 0) {
                updateInfoBarang(stok, harga, 1);
                $('#infoBarang').show();
            } else {
                $('#infoBarang').hide();
            }
        });
        
        // Update info saat jumlah berubah
        $('#jumlahKeluar').on('input', function() {
            var stok = parseInt($('#selectBarangKeluar').find(':selected').data('stok') || 0);
            var harga = parseFloat($('#selectBarangKeluar').find(':selected').data('harga') || 0);
            var jumlah = parseInt($(this).val()) || 0;
            
            if (jumlah > 0 && stok > 0) {
                updateInfoBarang(stok, harga, jumlah);
            }
        });
        
        // Fungsi update info barang
        function updateInfoBarang(stok, harga, jumlah) {
            var total = harga * jumlah;
            var sisa = stok - jumlah;
            
            $('#infoStok').text(stok.toLocaleString('id-ID'));
            $('#infoHarga').text(harga.toLocaleString('id-ID'));
            $('#infoTotal').text(total.toLocaleString('id-ID'));
            $('#infoSisa').text(sisa.toLocaleString('id-ID'));
            
            // Jika sisa stok kurang dari 5, tampilkan warning
            if (sisa < 5 && sisa >= 0) {
                $('#infoSisa').addClass('text-danger fw-bold');
            } else {
                $('#infoSisa').removeClass('text-danger fw-bold');
            }
        }
        
        // Validasi form
        $('#formKeluar').submit(function(e) {
            var jumlah = parseInt($('#jumlahKeluar').val());
            var stokTersedia = parseInt($('#stokTersedia').text().replace(/\./g, '') || 0);
            
            // Validasi dasar
            if (jumlah <= 0 || isNaN(jumlah)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: 'Jumlah harus lebih dari 0!',
                    confirmButtonColor: '#ffc107'
                });
                e.preventDefault();
                return false;
            }
            
            // Validasi stok
            if (jumlah > stokTersedia) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Tidak Cukup',
                    html: 'Jumlah melebihi stok tersedia!<br><br>' +
                          'Stok tersedia: <strong>' + stokTersedia.toLocaleString('id-ID') + '</strong><br>' +
                          'Jumlah diminta: <strong>' + jumlah.toLocaleString('id-ID') + '</strong>',
                    confirmButtonColor: '#ffc107'
                });
                e.preventDefault();
                return false;
            }
            
            // Konfirmasi sebelum submit
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Barang Keluar',
                html: 'Apakah Anda yakin ingin mencatat barang keluar?<br><br>' +
                      '<strong>' + $('#selectBarangKeluar').find(':selected').text() + '</strong><br>' +
                      'Jumlah: <strong>' + jumlah + '</strong>',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
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
        $('#tambahKeluarModal').on('shown.bs.modal', function () {
            $('#selectBarangKeluar').focus();
        });
    });
    </script>
</body>
</html>