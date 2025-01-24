<?php
// config/config.php

// Pengaturan database
$host = 'localhost';       // Host database
$username = 'root';        // Username database
$password = '';            // Password database
$dbname = 'bus_ticketing'; // Nama database

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengatur karakter encoding
$conn->set_charset("utf8");

?>