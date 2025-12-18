<?php
require_once '../config/koneksi.php';
requireLogin();

if ($_SESSION['level'] != 'admin') {
    die('Akses ditolak!');
}

$aksi = $_GET['aksi'] ?? '';

switch ($aksi) {
    case 'tambah':
        tambahBarang();
        break;
    case 'edit':
        editBarang();
        break;
    case 'hapus':
        hapusBarang();
        break;
    case 'get_barang':
        getBarang();
        break;
    default:
        header('Location: ../pages/barang.php');
        exit();
}

function tambahBarang() {
    global $koneksi;
    
    $nama_barang = escape($_POST['nama_barang']);
    $id_kategori = escape($_POST['id_kategori']);
    $stok = escape($_POST['stok']);
    $harga_beli = escape($_POST['harga_beli']);
    $harga_jual = escape($_POST['harga_jual']);
    $satuan = escape($_POST['satuan']);
    $lokasi_rak = escape($_POST['lokasi_rak']);
    
    $query = "INSERT INTO barang (nama_barang, id_kategori, stok, harga_beli, harga_jual, satuan, lokasi_rak) 
              VALUES ('$nama_barang', '$id_kategori', '$stok', '$harga_beli', '$harga_jual', '$satuan', '$lokasi_rak')";
    
    if (mysqli_query($koneksi, $query)) {
        header('Location: ../pages/barang.php?pesan=sukses_tambah');
    } else {
        header('Location: ../pages/barang.php?pesan=gagal');
    }
    exit();
}

function editBarang() {
    global $koneksi;
    
    $id_barang = escape($_POST['id_barang']);
    $nama_barang = escape($_POST['nama_barang']);
    $id_kategori = escape($_POST['id_kategori']);
    $stok = escape($_POST['stok']);
    $harga_beli = escape($_POST['harga_beli']);
    $harga_jual = escape($_POST['harga_jual']);
    $satuan = escape($_POST['satuan']);
    $lokasi_rak = escape($_POST['lokasi_rak']);
    
    $query = "UPDATE barang SET 
              nama_barang = '$nama_barang',
              id_kategori = '$id_kategori',
              stok = '$stok',
              harga_beli = '$harga_beli',
              harga_jual = '$harga_jual',
              satuan = '$satuan',
              lokasi_rak = '$lokasi_rak',
              updated_at = NOW()
              WHERE id_barang = '$id_barang'";
    
    if (mysqli_query($koneksi, $query)) {
        header('Location: ../pages/barang.php?pesan=sukses_edit');
    } else {
        header('Location: ../pages/barang.php?pesan=gagal');
    }
    exit();
}

function hapusBarang() {
    global $koneksi;
    
    $id_barang = escape($_GET['id']);
    
    $query = "DELETE FROM barang WHERE id_barang = '$id_barang'";
    
    if (mysqli_query($koneksi, $query)) {
        header('Location: ../pages/barang.php?pesan=sukses_hapus');
    } else {
        header('Location: ../pages/barang.php?pesan=gagal');
    }
    exit();
}

function getBarang() {
    global $koneksi;
    
    $id_barang = escape($_GET['id']);
    
    $query = "SELECT * FROM barang WHERE id_barang = '$id_barang'";
    $result = mysqli_query($koneksi, $query);
    $barang = mysqli_fetch_assoc($result);
    
    echo json_encode($barang);
    exit();
}
?>