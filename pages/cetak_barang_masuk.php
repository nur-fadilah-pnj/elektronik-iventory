<?php
require_once '../config/koneksi.php';
requireLogin();

// Ambil parameter filter
$tanggal_dari = isset($_GET['tanggal_dari']) ? $_GET['tanggal_dari'] : '';
$tanggal_sampai = isset($_GET['tanggal_sampai']) ? $_GET['tanggal_sampai'] : '';
$supplier_filter = isset($_GET['supplier']) ? urldecode($_GET['supplier']) : '';

// Query data barang masuk dengan filter
$query = "SELECT bm.*, b.nama_barang, b.stok FROM barang_masuk bm 
         JOIN barang b ON bm.id_barang = b.id_barang 
         WHERE 1=1";

if (!empty($tanggal_dari)) {
    $query .= " AND DATE(bm.tanggal_masuk) >= '$tanggal_dari'";
}
if (!empty($tanggal_sampai)) {
    $query .= " AND DATE(bm.tanggal_masuk) <= '$tanggal_sampai'";
}
if (!empty($supplier_filter)) {
    $query .= " AND bm.supplier = '" . mysqli_real_escape_string($koneksi, $supplier_filter) . "'";
}

$query .= " ORDER BY bm.tanggal_masuk DESC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Barang Masuk</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
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
            color: #28a745; 
            margin: 0;
            font-size: 20px;
        }
        .header p { 
            margin: 5px 0;
        }
        .info { 
            margin-bottom: 15px; 
            padding: 10px; 
            background-color: #f8f9fa; 
            border-radius: 5px;
            border-left: 4px solid #28a745;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px;
            font-size: 11px;
        }
        th { 
            background-color: #28a745; 
            color: white; 
            padding: 8px; 
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
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
        }
        @media print {
            body { margin: 10px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN BARANG MASUK</h1>
        <p><strong>Sistem Stok Elektronik</strong></p>
        <p>Tanggal Cetak: <?php echo date('d/m/Y H:i:s'); ?></p>
    </div>
    
    <div class="info">
        <strong>Filter Terapkan:</strong><br>
        • Periode: <?php 
            if ($tanggal_dari && $tanggal_sampai) {
                echo date('d/m/Y', strtotime($tanggal_dari)) . ' - ' . date('d/m/Y', strtotime($tanggal_sampai));
            } elseif ($tanggal_dari) {
                echo 'Dari ' . date('d/m/Y', strtotime($tanggal_dari));
            } elseif ($tanggal_sampai) {
                echo 'Sampai ' . date('d/m/Y', strtotime($tanggal_sampai));
            } else {
                echo 'Semua Tanggal';
            }
        ?><br>
        • Supplier: <?php echo $supplier_filter ? htmlspecialchars($supplier_filter) : 'Semua Supplier'; ?>
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="80">Tanggal</th>
                <th>Nama Barang</th>
                <th width="60">Jumlah</th>
                <th>Supplier</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total_jumlah = 0;
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $total_jumlah += $row['jumlah'];
                    
                    echo "<tr>";
                    echo "<td class='text-center'>$no</td>";
                    echo "<td>" . date('d/m/Y', strtotime($row['tanggal_masuk'])) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_barang']) . "</td>";
                    echo "<td class='text-center'><span class='badge' style='background-color:#28a745;color:white;'>" . 
                         number_format($row['jumlah']) . "</span></td>";
                    echo "<td>" . htmlspecialchars($row['supplier'] ?: '-') . "</td>";
                    echo "<td>" . htmlspecialchars($row['keterangan'] ?: '-') . "</td>";
                    echo "</tr>";
                    $no++;
                }
                
                // Total
                echo "<tr class='total'>";
                echo "<td colspan='3'><strong>TOTAL</strong></td>";
                echo "<td class='text-center'><strong>" . number_format($total_jumlah) . "</strong></td>";
                echo "<td colspan='2'></td>";
                echo "</tr>";
            } else {
                echo "<tr><td colspan='6' class='text-center'>Tidak ada data barang masuk</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak oleh: Administrator</p>
        <p>Sistem Stok Elektronik © <?php echo date('Y'); ?></p>
    </div>
    
    <div class="no-print" style="text-align:center; margin-top:20px;">
        <button onclick="window.print()" style="padding:8px 15px; background-color:#28a745; color:white; border:none; cursor:pointer;">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
        <button onclick="window.close()" style="padding:8px 15px; background-color:#dc3545; color:white; border:none; cursor:pointer; margin-left:10px;">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>
</body>
</html>