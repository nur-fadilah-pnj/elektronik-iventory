<?php
require_once 'config/koneksi.php';

// Hash password admin
$password = 'admin123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Update password admin di database
$query = "UPDATE users SET password = '$hashed_password' WHERE username = 'admin'";

if (mysqli_query($koneksi, $query)) {
    echo "Admin password berhasil diupdate!<br>";
    echo "Username: admin<br>";
    echo "Password: admin123<br>";
    echo "<a href='login.php'>Login disini</a>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>