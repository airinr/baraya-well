<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "baraya_well"; // Ganti dengan nama database kamu

    // Membuat koneksi
    $conn = new mysqli($host, $user, $pass, $db);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }


?>
