<?php
require_once 'config/koneksi.php';

echo "<h3>Checking Database Structure</h3>";

// Cek tabel users
$result = mysqli_query($koneksi, "SHOW TABLES");
echo "<h4>Available Tables:</h4>";
while ($row = mysqli_fetch_array($result)) {
    echo $row[0] . "<br>";
    
    // Tampilkan kolom untuk tabel users
    if ($row[0] == 'users' || $row[0] == 'user' || $row[0] == 'pengguna' || $row[0] == 'admin') {
        echo "<h5>Columns in " . $row[0] . ":</h5>";
        $cols = mysqli_query($koneksi, "DESCRIBE " . $row[0]);
        echo "<table border='1'><tr><th>Field</th><th>Type</th></tr>";
        while ($col = mysqli_fetch_assoc($cols)) {
            echo "<tr><td>" . $col['Field'] . "</td><td>" . $col['Type'] . "</td></tr>";
        }
        echo "</table>";
    }
}

// Cek session data
echo "<h4>Current Session Data:</h4>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>