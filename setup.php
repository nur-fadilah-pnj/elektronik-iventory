<?php
// Setup Database Lengkap dengan Password Admin
$host = 'localhost';
$user = 'root';
$pass = ''; // Kosong jika tidak ada password
$dbname = 'elektronik_inventory';

// Koneksi ke MySQL
$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("Koneksi MySQL gagal: " . mysqli_connect_error());
}

echo "<h3>Setup Database Sistem Stok Barang Elektronik</h3>";
echo "===============================================<br><br>";

// 1. Buat Database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname 
        CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
if (mysqli_query($conn, $sql)) {
    echo "✓ Database '$dbname' berhasil dibuat<br>";
} else {
    echo "✗ Error membuat database: " . mysqli_error($conn) . "<br>";
}

// Pilih database
mysqli_select_db($conn, $dbname);

// 2. Buat Tabel users
$sql = "CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    level ENUM('admin', 'user') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB";
if (mysqli_query($conn, $sql)) {
    echo "✓ Tabel 'users' berhasil dibuat<br>";
} else {
    echo "✗ Error membuat tabel users: " . mysqli_error($conn) . "<br>";
}

// 3. Buat Tabel kategori
$sql = "CREATE TABLE IF NOT EXISTS kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    deskripsi TEXT
) ENGINE=InnoDB";
if (mysqli_query($conn, $sql)) {
    echo "✓ Tabel 'kategori' berhasil dibuat<br>";
} else {
    echo "✗ Error membuat tabel kategori: " . mysqli_error($conn) . "<br>";
}

// 4. Buat Tabel barang
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
) ENGINE=InnoDB";
if (mysqli_query($conn, $sql)) {
    echo "✓ Tabel 'barang' berhasil dibuat<br>";
} else {
    echo "✗ Error membuat tabel barang: " . mysqli_error($conn) . "<br>";
}

// 5. Buat Tabel barang_masuk
$sql = "CREATE TABLE IF NOT EXISTS barang_masuk (
    id_masuk INT AUTO_INCREMENT PRIMARY KEY,
    id_barang INT NOT NULL,
    jumlah INT NOT NULL,
    tanggal_masuk DATE NOT NULL,
    supplier VARCHAR(200),
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB";
if (mysqli_query($conn, $sql)) {
    echo "✓ Tabel 'barang_masuk' berhasil dibuat<br>";
} else {
    echo "✗ Error membuat tabel barang_masuk: " . mysqli_error($conn) . "<br>";
}

// 6. Buat Tabel barang_keluar
$sql = "CREATE TABLE IF NOT EXISTS barang_keluar (
    id_keluar INT AUTO_INCREMENT PRIMARY KEY,
    id_barang INT NOT NULL,
    jumlah INT NOT NULL,
    tanggal_keluar DATE NOT NULL,
    penerima VARCHAR(200),
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB";
if (mysqli_query($conn, $sql)) {
    echo "✓ Tabel 'barang_keluar' berhasil dibuat<br>";
} else {
    echo "✗ Error membuat tabel barang_keluar: " . mysqli_error($conn) . "<br>";
}

// 7. Insert data kategori
$sql = "INSERT IGNORE INTO kategori (nama_kategori, deskripsi) VALUES 
        ('Smartphone', 'Telepon pintar dan aksesoris'),
        ('Laptop & Komputer', 'Laptop, PC, dan komponen'),
        ('TV & Monitor', 'Televisi dan monitor komputer'),
        ('Audio', 'Speaker, headphone, dan perangkat audio'),
        ('Aksesoris', 'Kabel, charger, dan aksesoris elektronik')";
if (mysqli_query($conn, $sql)) {
    echo "✓ Data kategori berhasil dimasukkan<br>";
} else {
    echo "✗ Error memasukkan kategori: " . mysqli_error($conn) . "<br>";
}

// 8. Insert user admin dengan password yang BENAR
$password = 'admin123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Hapus user admin lama jika ada
$sql = "DELETE FROM users WHERE username = 'admin'";
mysqli_query($conn, $sql);

// Insert user admin baru
$sql = "INSERT INTO users (username, password, nama_lengkap, level) 
        VALUES ('admin', '$hashed_password', 'Administrator', 'admin')";
if (mysqli_query($conn, $sql)) {
    echo "✓ User admin berhasil dibuat!<br>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;Username: <strong>admin</strong><br>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;Password: <strong>admin123</strong><br>";
    
    // Verifikasi password
    $verify = password_verify('admin123', $hashed_password);
    echo "&nbsp;&nbsp;&nbsp;&nbsp;Password verifikasi: " . ($verify ? "✓ SUCCESS" : "✗ FAILED") . "<br>";
} else {
    echo "✗ Error membuat user admin: " . mysqli_error($conn) . "<br>";
}

// 9. Insert contoh data barang
$sql = "INSERT IGNORE INTO barang (nama_barang, id_kategori, stok, harga_beli, harga_jual, satuan, lokasi_rak) VALUES 
        ('Samsung Galaxy S23', 1, 15, 8500000, 10500000, 'pcs', 'RAK-A1'),
        ('iPhone 14 Pro', 1, 8, 12500000, 15500000, 'pcs', 'RAK-A2'),
        ('MacBook Air M2', 2, 5, 14500000, 18500000, 'unit', 'RAK-B1'),
        ('Asus ROG Strix G15', 2, 12, 18500000, 22500000, 'unit', 'RAK-B2'),
        ('LG OLED TV 55\"', 3, 6, 11500000, 14500000, 'unit', 'RAK-C1'),
        ('JBL Speaker Flip 5', 4, 25, 1500000, 2200000, 'pcs', 'RAK-D1'),
        ('Charger Type-C Fast', 5, 50, 85000, 150000, 'pcs', 'RAK-E1')";
if (mysqli_query($conn, $sql)) {
    echo "✓ Contoh data barang berhasil dimasukkan<br>";
} else {
    echo "✗ Error memasukkan data barang: " . mysqli_error($conn) . "<br>";
}

// 10. Cek user yang ada di database
echo "<br><strong>Data User di Database:</strong><br>";
$sql = "SELECT id_user, username, nama_lengkap, LENGTH(password) as pass_length FROM users";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo "- {$row['username']} ({$row['nama_lengkap']}) - Password length: {$row['pass_length']}<br>";
}

echo "<br><hr>";
echo "<h3 style='color: green;'>✅ SETUP SELESAI!</h3>";
echo "<p>Silakan login dengan:</p>";
echo "<div style='background: #e9ffe9; padding: 15px; border-radius: 5px;'>";
echo "<strong>URL Login:</strong> <a href='login.php' target='_blank'>login.php</a><br>";
echo "<strong>Username:</strong> admin<br>";
echo "<strong>Password:</strong> admin123<br>";
echo "</div>";
echo "<br><a href='login.php' class='btn btn-success' style='padding: 10px 20px;'>▶ Login Sekarang</a>";

mysqli_close($conn);
?>