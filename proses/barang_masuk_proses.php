<?php
// ../proses/barang_masuk_proses.php
session_start();
require_once '../config/koneksi.php';
requireLogin();

if ($_SESSION['level'] != 'admin') {
    die('<script>alert("Akses ditolak!"); window.history.back();</script>');
}

$aksi = $_GET['aksi'] ?? '';

switch ($aksi) {
    case 'tambah':
        tambahBarangMasuk();
        break;
    default:
        header('Location: ../pages/barang_masuk.php');
        exit();
}

function tambahBarangMasuk() {
    global $koneksi;
    
    // CEK APAKAH REQUEST METHOD POST
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $_SESSION['error'] = "Metode request tidak valid!";
        header('Location: ../pages/barang_masuk.php?pesan=gagal');
        exit();
    }
    
    // VALIDASI INPUT WAJIB
    if (empty($_POST['id_barang']) || empty($_POST['jumlah']) || empty($_POST['tanggal_masuk'])) {
        $_SESSION['error'] = "Data tidak lengkap!";
        header('Location: ../pages/barang_masuk.php?pesan=gagal');
        exit();
    }
    
    // AMBIL DAN VALIDASI DATA
    $id_barang = intval($_POST['id_barang']);
    $jumlah = intval($_POST['jumlah']);
    $tanggal_masuk = mysqli_real_escape_string($koneksi, $_POST['tanggal_masuk']);
    $supplier = !empty($_POST['supplier']) ? mysqli_real_escape_string($koneksi, $_POST['supplier']) : '';
    $keterangan = !empty($_POST['keterangan']) ? mysqli_real_escape_string($koneksi, $_POST['keterangan']) : '';
    
    // VALIDASI JUMLAH
    if ($jumlah <= 0) {
        $_SESSION['error'] = "Jumlah harus lebih dari 0!";
        header('Location: ../pages/barang_masuk.php?pesan=gagal');
        exit();
    }
    
    // CEK APAKAH BARANG ADA
    $cek_barang = mysqli_query($koneksi, "SELECT nama_barang FROM barang WHERE id_barang = '$id_barang'");
    if (mysqli_num_rows($cek_barang) == 0) {
        $_SESSION['error'] = "Barang tidak ditemukan!";
        header('Location: ../pages/barang_masuk.php?pesan=gagal');
        exit();
    }
    
    // MULAI TRANSAKSI
    mysqli_begin_transaction($koneksi);
    
    try {
        // 1. INSERT KE TABEL BARANG_MASUK
        $query1 = "INSERT INTO barang_masuk (id_barang, jumlah, tanggal_masuk, supplier, keterangan) 
                   VALUES ('$id_barang', '$jumlah', '$tanggal_masuk', '$supplier', '$keterangan')";
        
        if (!mysqli_query($koneksi, $query1)) {
            throw new Exception("Gagal menyimpan data barang masuk: " . mysqli_error($koneksi));
        }
        
        // 2. UPDATE STOK DI TABEL BARANG
        $query2 = "UPDATE barang SET stok = stok + $jumlah WHERE id_barang = '$id_barang'";
        
        if (!mysqli_query($koneksi, $query2)) {
            throw new Exception("Gagal update stok barang: " . mysqli_error($koneksi));
        }
        
        // COMMIT TRANSAKSI
        mysqli_commit($koneksi);
        
        // SIMPAN PESAN SUKSES
        $_SESSION['success'] = "Barang masuk berhasil ditambahkan!";
        header('Location: ../pages/barang_masuk.php?pesan=sukses');
        
    } catch (Exception $e) {
        // ROLLBACK TRANSAKSI JIKA ADA ERROR
        mysqli_rollback($koneksi);
        
        // SIMPAN PESAN ERROR
        $_SESSION['error'] = $e->getMessage();
        header('Location: ../pages/barang_masuk.php?pesan=gagal');
    }
    
    exit();
}
?>