<?php

// include "../koneksi.php";
// include __DIR__ . '/../../koneksi.php';

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "baraya_well"; 

    // Membuat koneksi
    $conn = new mysqli($host, $user, $pass, $db);   

function registerWarga()
{
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $_POST['nama'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $noRumah = $_POST['noRumah'] ?? '';
        $idRt = $_POST['idRt'] ?? '';

        if (empty($nama) || empty($email) || empty($password) || empty($noRumah) || empty($idRt)) {
            echo "<script>alert('Semua field wajib diisi'); window.history.back();</script>";
            return;
        }

        $result = $conn->query("SELECT MAX(idWarga) AS kode_terakhir FROM warga");
        $row = $result->fetch_assoc();
        $kode_terakhir = $row['kode_terakhir'];

        $kode_baru = $kode_terakhir
            ? "W" . str_pad(intval(substr($kode_terakhir, 1)) + 1, 3, "0", STR_PAD_LEFT)
            : "W001";

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO warga (idWarga, nama, email, password, noRumah, idRt) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssii", $kode_baru, $nama, $email, $hashed_password, $noRumah, $idRt);

        if ($stmt->execute()) {
            $_SESSION['idWarga'] = $kode_baru;
            $_SESSION['nama'] = $nama;
            $_SESSION['email'] = $email;
            $_SESSION['noRumah'] = $noRumah;
            $_SESSION['idRt'] = $idRt;

            echo "<script>alert('Pendaftaran berhasil!'); window.location.href='../../pages/warga/beranda-warga.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data: " . $conn->error . "'); window.history.back();</script>";
        }

        $stmt->close();
        $conn->close();
    }
}

function getWargaData($koneksi, $id_warga) 
{
    $query = "SELECT warga.nama, warga.noRumah, rt.rt, rt.rw 
              FROM warga 
              JOIN rt ON warga.idRt = rt.idRt 
              WHERE warga.idWarga = '$id_warga'";
              
    $hasil = mysqli_query($koneksi, $query);
    return mysqli_fetch_assoc($hasil) ?: [];
}

function getBulanIniStatus($koneksi, $id_warga, $iuran_tetap) {
    $bulan_sekarang_angka = date('m');
    $tahun_sekarang = date('Y');

    $query = "SELECT totalBayar FROM pembayaran 
              WHERE idWarga = '$id_warga' 
              AND MONTH(tglPembayaran) = '$bulan_sekarang_angka' 
              AND YEAR(tglPembayaran) = '$tahun_sekarang'";
              
    $hasil = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($hasil) > 0) {
        $data_pembayaran = mysqli_fetch_assoc($hasil);
        return [
            'status' => 'LUNAS',
            'iuran' => $data_pembayaran['totalBayar']
        ];
    } else {
        return [
            'status' => 'BELUM LUNAS',
            'iuran' => $iuran_tetap
        ];
    }
}

function getRiwayatPembayaran($koneksi, $id_warga, $limit = 3) {
    $query = "SELECT * FROM pembayaran 
              WHERE idWarga = '$id_warga' 
              ORDER BY tglPembayaran DESC 
              LIMIT $limit";
              
    return mysqli_query($koneksi, $query);
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
