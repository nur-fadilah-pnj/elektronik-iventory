<?php
// Cek apakah session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah koneksi sudah dibuat untuk mencegah error redeclaration
if (!isset($koneksi)) {
    // Koneksi ke database
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db   = 'elektronik_inventory';

    $koneksi = mysqli_connect($host, $user, $pass, $db);

    // Cek koneksi
    if (!$koneksi) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }
}

// Fungsi untuk mencegah SQL injection
if (!function_exists('escape')) {
    function escape($data) {
        global $koneksi;
        if (is_array($data)) {
            return array_map('escape', $data);
        }
        return mysqli_real_escape_string($koneksi, trim(htmlspecialchars($data)));
    }
}

// Fungsi helper untuk cek login
if (!function_exists('isLoggedIn')) {
    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}

// Fungsi helper untuk require login
if (!function_exists('requireLogin')) {
    function requireLogin() {
        if (!isLoggedIn()) {
            $redirect = isset($_SERVER['PHP_SELF']) && strpos($_SERVER['PHP_SELF'], 'pages/') !== false ? '../login.php' : 'login.php';
            header('Location: ' . $redirect);
            exit();
        }
    }
}

// Fungsi untuk format rupiah
if (!function_exists('formatRupiah')) {
    function formatRupiah($angka) {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}
?>