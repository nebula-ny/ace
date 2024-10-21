<?php
// Informasi database
$servername = "localhost";  // Server database, biasanya "localhost"
$username = "root";         // Username MySQL (biasanya root jika di localhost)
$password = "";             // Password MySQL (kosong jika di localhost)
$dbname = "ACE";  // Nama database

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
