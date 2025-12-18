<?php
require_once '../config/koneksi.php';
requireLogin();

if ($_SESSION['level'] != 'admin') {
    die('Akses ditolak!');
}

$aksi = $_GET['aksi'] ?? '';

switch ($aksi) {
    case 'tambah':
        tambahBarangKeluar();
        break;
    default:
        header('Location: ../pages/barang_keluar.php');
        exit();
}

function tambahBarangKeluar() {
    global $koneksi;
    
    $id_barang = escape($_POST['id_barang']);
    $jumlah = escape($_POST['jumlah']);
    $tanggal_keluar = escape($_POST['tanggal_keluar']);
    $penerima = escape($_POST['penerima']);
    $keterangan = escape($_POST['keterangan']);
    
    // Cek stok tersedia
    $query_cek = "SELECT stok FROM barang WHERE id_barang = '$id_barang'";
    $result_cek = mysqli_query($koneksi, $query_cek);
    $barang = mysqli_fetch_assoc($result_cek);
    
    if ($barang['stok'] < $jumlah) {
        header('Location: ../pages/barang_keluar.php?pesan=stok_kurang');
        exit();
    }
    
    // Mulai transaksi
    mysqli_begin_transaction($koneksi);
    
    try {
        // 1. Insert ke tabel barang_keluar
        $query1 = "INSERT INTO barang_keluar (id_barang, jumlah, tanggal_keluar, penerima, keterangan) 
                   VALUES ('$id_barang', '$jumlah', '$tanggal_keluar', '$penerima', '$keterangan')";
        
        if (!mysqli_query($koneksi, $query1)) {
            throw new Exception("Gagal menyimpan data barang keluar");
        }
        
        // 2. Update stok di tabel barang
        $query2 = "UPDATE barang SET stok = stok - $jumlah WHERE id_barang = '$id_barang'";
        
        if (!mysqli_query($koneksi, $query2)) {
            throw new Exception("Gagal update stok barang");
        }
        
        // Commit transaksi
        mysqli_commit($koneksi);
        
        header('Location: ../pages/barang_keluar.php?pesan=sukses');
        
    } catch (Exception $e) {
        // Rollback transaksi jika ada error
        mysqli_rollback($koneksi);
        header('Location: ../pages/barang_keluar.php?pesan=gagal');
    }
    
    exit();
}
?>