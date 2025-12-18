<?php
// Setup database
$host = 'localhost';
$user = 'root';
$pass = '';

$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("Koneksi MySQL gagal: " . mysqli_connect_error());
}

echo "Membuat database...<br>";

// Buat database
$sql = "CREATE DATABASE IF NOT EXISTS elektronik_inventory";
mysqli_query($conn, $sql);
mysqli_select_db($conn, 'elektronik_inventory');

// Buat tabel users
$sql = "CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    level ENUM('admin', 'user') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $sql);
echo "Tabel users dibuat<br>";

// Buat tabel kategori
$sql = "CREATE TABLE IF NOT EXISTS kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    deskripsi TEXT
)";
mysqli_query($conn, $sql);
echo "Tabel kategori dibuat<br>";

// Buat tabel barang
$sql = "CREATE TABLE IF NOT EXISTS barang (
    id_barang INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(200) NOT NULL,
    id_kategori INT,
    stok INT DEFAULT 0,
    harga_beli DECIMAL(12,2) NOT NULL,
    harga_jual DECIMAL(12,2) NOT NULL,
    satuan VARCHAR(50) DEFAULT 'pcs',
    lokasi_rak VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysqli_query($conn, $sql);
echo "Tabel barang dibuat<br>";

// Insert data contoh
$password = password_hash('admin123', PASSWORD_DEFAULT);
$sql = "INSERT IGNORE INTO users (username, password, nama_lengkap) 
        VALUES ('admin', '$password', 'Administrator')";
mysqli_query($conn, $sql);
echo "User admin dibuat<br>";

echo "<h3>Setup berhasil! <a href='login.php'>Login sekarang</a></h3>";
?>