<?php
require_once '../config/koneksi.php';
requireLogin();

// Ambil parameter filter
$kategori_filter = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$stok_filter = isset($_GET['stok']) ? $_GET['stok'] : '';
$sort_filter = isset($_GET['sort']) ? $_GET['sort'] : 'nama';

// Query sama seperti di barang.php dengan filter
$query = "SELECT b.*, k.nama_kategori FROM barang b 
         LEFT JOIN kategori k ON b.id_kategori = k.id_kategori 
         WHERE 1=1";

if (!empty($kategori_filter)) {
    $query .= " AND b.id_kategori = '$kategori_filter'";
}

if ($stok_filter == 'low') {
    $query .= " AND b.stok < 10";
} elseif ($stok_filter == 'out') {
    $query .= " AND b.stok = 0";
} elseif ($stok_filter == 'good') {
    $query .= " AND b.stok >= 10";
}

switch ($sort_filter) {
    case 'stok_asc': $query .= " ORDER BY b.stok ASC"; break;
    case 'stok_desc': $query .= " ORDER BY b.stok DESC"; break;
    case 'harga_asc': $query .= " ORDER BY b.harga_jual ASC"; break;
    case 'harga_desc': $query .= " ORDER BY b.harga_jual DESC"; break;
    default: $query .= " ORDER BY b.nama_barang ASC";
}

$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Barang</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            margin: 20px; 
            font-size: 12px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 { 
            color: #007bff; 
            margin: 0;
            font-size: 20px;
        }
        .header p { 
            color: #666;
            margin: 5px 0;
        }
        .info { 
            margin-bottom: 15px; 
            padding: 10px; 
            background-color: #f8f9fa; 
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px;
            font-size: 11px;
        }
        th { 
            background-color: #007bff; 
            color: white; 
            padding: 8px; 
            text-align: left;
            border: 1px solid #ddd;
        }
        td { 
            padding: 6px; 
            border: 1px solid #ddd;
        }
        tr:nth-child(even) { 
            background-color: #f2f2f2; 
        }
        .footer { 
            margin-top: 30px; 
            text-align: right; 
            font-style: italic;
            border-top: 1px solid #333;
            padding-top: 10px;
        }
        .total { 
            font-weight: bold; 
            background-color: #e9ecef; 
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-danger { color: #dc3545; }
        .text-success { color: #28a745; }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .bg-success { background-color: #28a745; color: white; }
        .bg-danger { background-color: #dc3545; color: white; }
        .bg-secondary { background-color: #6c757d; color: white; }
        @media print {
            body { margin: 10px; }
            .no-print { display: none !important; }
            .header { margin-top: 0; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA BARANG</h1>
        <p><strong>Sistem Stok Elektronik</strong></p>
        <p>Tanggal Cetak: <?php echo date('d/m/Y H:i:s'); ?></p>
    </div>
    
    <div class="info">
        <strong>Filter Terapkan:</strong><br>
        • Kategori: <?php echo $kategori_filter ? getKategoriNama($kategori_filter, $koneksi) : 'Semua Kategori'; ?><br>
        • Kondisi Stok: <?php 
            echo $stok_filter == 'low' ? 'Rendah (< 10)' : 
                 ($stok_filter == 'out' ? 'Habis (0)' : 
                 ($stok_filter == 'good' ? 'Cukup (≥ 10)' : 'Semua Stok')); 
        ?><br>
        • Urutan: <?php 
            echo $sort_filter == 'nama' ? 'Nama A-Z' : 
                 ($sort_filter == 'stok_asc' ? 'Stok Terendah' : 
                 ($sort_filter == 'stok_desc' ? 'Stok Tertinggi' : 
                 ($sort_filter == 'harga_asc' ? 'Harga Termurah' : 'Harga Termahal'))); 
        ?>
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nama Barang</th>
                <th width="80">Kategori</th>
                <th width="60">Stok</th>
                <th width="100">Harga Beli</th>
                <th width="100">Harga Jual</th>
                <th width="60">Satuan</th>
                <th width="70">Lokasi Rak</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total_stok = 0;
            $total_nilai_beli = 0;
            $total_nilai_jual = 0;
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $nilai_beli = $row['stok'] * $row['harga_beli'];
                    $nilai_jual = $row['stok'] * $row['harga_jual'];
                    $total_stok += $row['stok'];
                    $total_nilai_beli += $nilai_beli;
                    $total_nilai_jual += $nilai_jual;
                    
                    // Tentukan kelas stok
                    $stok_class = '';
                    if ($row['stok'] == 0) {
                        $stok_class = 'bg-secondary';
                    } elseif ($row['stok'] < 10) {
                        $stok_class = 'bg-danger';
                    } else {
                        $stok_class = 'bg-success';
                    }
                    
                    echo "<tr>";
                    echo "<td class='text-center'>$no</td>";
                    echo "<td>" . htmlspecialchars($row['nama_barang']) . "<br><small>ID: " . $row['id_barang'] . "</small></td>";
                    echo "<td>" . htmlspecialchars($row['nama_kategori']) . "</td>";
                    echo "<td class='text-center'><span class='badge $stok_class'>" . number_format($row['stok']) . "</span></td>";
                    echo "<td class='text-right'>Rp " . number_format($row['harga_beli'], 0, ',', '.') . "</td>";
                    echo "<td class='text-right'>Rp " . number_format($row['harga_jual'], 0, ',', '.') . "</td>";
                    echo "<td class='text-center'>" . htmlspecialchars($row['satuan']) . "</td>";
                    echo "<td class='text-center'>" . ($row['lokasi_rak'] ?: '-') . "</td>";
                    echo "</tr>";
                    $no++;
                }
                
                // Total
                echo "<tr class='total'>";
                echo "<td colspan='3'><strong>TOTAL</strong></td>";
                echo "<td class='text-center'><strong>" . number_format($total_stok) . "</strong></td>";
                echo "<td class='text-right'><strong>Rp " . number_format($total_nilai_beli, 0, ',', '.') . "</strong></td>";
                echo "<td class='text-right'><strong>Rp " . number_format($total_nilai_jual, 0, ',', '.') . "</strong></td>";
                echo "<td colspan='2'></td>";
                echo "</tr>";
            } else {
                echo "<tr><td colspan='8' style='text-align:center; padding:20px;'>Tidak ada data barang</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak oleh: Administrator</p>
        <p>Sistem Stok Elektronik © <?php echo date('Y'); ?></p>
    </div>
    
    <div class="no-print" style="text-align:center; margin-top:20px;">
        <button onclick="window.print()" style="padding:8px 15px; background-color:#007bff; color:white; border:none; border-radius:3px; cursor:pointer; margin:5px;">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
        <button onclick="window.close()" style="padding:8px 15px; background-color:#dc3545; color:white; border:none; border-radius:3px; cursor:pointer; margin:5px;">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>
    
    <script>
        // Auto print ketika halaman terbuka
        window.onload = function() {
            // Uncomment baris di bawah jika ingin auto print
            // window.print();
        }
    </script>
</body>
</html>
<?php
function getKategoriNama($id, $koneksi) {
    $query = "SELECT nama_kategori FROM kategori WHERE id_kategori = '$id'";
    $result = mysqli_query($koneksi, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['nama_kategori'];
    }
    return 'Tidak Diketahui';
}
?>