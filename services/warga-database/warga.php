<?php

// include "../koneksi.php";
// include __DIR__ . '/../../koneksi.php';

$host = "localhost";
$user = "root";
$pass = "";
$db   = "baraya_well";

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);

function ketuaRt()
{
    global $conn;

    $query = "SELECT * FROM rt";
    $result = $conn->query($query);

    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}


function registerWarga()
{
    global $conn;

     if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $_POST['nama'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $noRumah = $_POST['noRumah'] ?? '';
        $idRt = $_POST['idRt'] ?? '';

        // Validasi field kosong
        if (empty($nama) || empty($email) || empty($password) || empty($noRumah) || empty($idRt)) {
            echo "<script>alert('Semua field wajib diisi'); window.history.back();</script>";
            return;
        }

        // Ambil ID terakhir
        $result = $conn->query("SELECT MAX(idWarga) AS kode_terakhir FROM warga");
        $row = $result->fetch_assoc();
        $kode_terakhir = $row['kode_terakhir'];

        $kode_baru = $kode_terakhir
            ? "W" . str_pad((int)substr($kode_terakhir, 1) + 1, 3, "0", STR_PAD_LEFT)
            : "W001";

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert ke database
        $stmt = $conn->prepare("INSERT INTO warga (idWarga, nama, email, password, noRumah, idRt) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $kode_baru, $nama, $email, $hashed_password, $noRumah, $idRt);

        if ($stmt->execute()) {
            // Set session
            $_SESSION['idWarga'] = $kode_baru;
            $_SESSION['nama'] = $nama;
            $_SESSION['email'] = $email;
            $_SESSION['noRumah'] = $noRumah;
            $_SESSION['idRt'] = $idRt;

            echo "<script>alert('Pendaftaran berhasil!'); window.location.href='../../login.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data: " . $conn->error . "'); window.history.back();</script>";
        }

        $stmt->close();
    }

    // Tutup koneksi
    $conn->close();
}

function loginWarga($username, $password)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM warga WHERE nama = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Login berhasil, simpan ke session
            $_SESSION['idWarga'] = $user['idWarga'];
            $_SESSION['idRt']    = $user['idRt'];
            $_SESSION['nama']    = $user['nama'];
            $_SESSION['email']   = $user['email'];
            $_SESSION['noRumah'] = $user['noRumah'];

            header("Location: ../../pages/warga/beranda-warga.php");
            exit();
        } else {
            echo "<script>alert('Password salah!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Akun tidak ditemukan!'); window.history.back();</script>";
    }

    $stmt->close();
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

function getBulanIniStatus($koneksi, $id_warga, $iuran_tetap)
{
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

function getRiwayatPembayaran($koneksi, $id_warga, $limit = 3)
{
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
        registerWarga();
    } else {
        echo "Fungsi '$aksi' tidak dikenali.";
    }
}
