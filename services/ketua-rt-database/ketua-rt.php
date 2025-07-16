<?php

// include "../koneksi.php";
// include __DIR__ . '/../../koneksi.php';

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "baraya_well"; 

    // Membuat koneksi
    $conn = new mysqli($host, $user, $pass, $db);   

function registerRt()
{
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $_POST['nama'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $alamat = $_POST['alamat'] ?? '';
        $rt = $_POST['rt'] ?? '';
        $rw = $_POST['rw'] ?? '';

        if (empty($nama) || empty($email) || empty($password) || empty($alamat) || empty($rt) || empty($rw)) {
            echo "<script>alert('Semua field wajib diisi'); window.history.back();</script>";
            return;
        }

        $result = $conn->query("SELECT MAX(idRt) AS kode_terakhir FROM rt");
        $row = $result->fetch_assoc();
        $kode_terakhir = $row['kode_terakhir'];

        $kode_baru = $kode_terakhir
            ? "R" . str_pad(intval(substr($kode_terakhir, 1)) + 1, 3, "0", STR_PAD_LEFT)
            : "R001";

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO rt (idRt, nama, email, password, alamat, rt, rw) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssii", $kode_baru, $nama, $email, $hashed_password, $alamat, $rt, $rw);

        if ($stmt->execute()) {
            $_SESSION['idRt'] = $kode_baru;
            $_SESSION['nama'] = $nama;
            $_SESSION['email'] = $email;
            $_SESSION['rt'] = $rt;
            $_SESSION['rw'] = $rw;

            echo "<script>alert('Pendaftaran berhasil!'); window.location.href='../../pages/ketua-rt/beranda-rt.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data: " . $conn->error . "'); window.history.back();</script>";
        }

        $stmt->close();
        $conn->close();
    }
}

function getPemasukan()
{
    global $conn;
    $query = "SELECT * FROM pembayaran, warga WHERE pembayaran.idWarga = warga.idWarga"; 
    return $conn->query($query);
}

function getPengeluaran()
{
    global $conn;
    $query = "SELECT * FROM pembayaran, warga WHERE pembayaran.idWarga = warga.idWarga"; 
    return $conn->query($query);
}

function getWarga()
{
    global $conn;
    $query = "SELECT * FROM warga, rt WHERE warga.idRt = rt.idRt"; 
    return $conn->query($query);
}

function getTotalPemasukan()
{
    global $conn;
    $query = "SELECT SUM(totalBayar) AS total FROM pembayaran";
    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['total'] ?? 0;
    } else {
        return 0;
    }
}



// Jika dipanggil via URL
if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];
    if ($aksi == "register") {
        registerRt();
    } else {
        echo "Fungsi '$aksi' tidak dikenali.";
    }
}
