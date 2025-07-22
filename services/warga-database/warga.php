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

function getKategori($idRt)
{
    global $conn;

    $kategori = [];

    // Query data kategori berdasarkan id_rt
    $query = "SELECT * FROM kategori WHERE idRt = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $idRt);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Ambil hasil dan simpan ke array
        while ($row = mysqli_fetch_assoc($result)) {
            $kategori[] = $row;
        }

        mysqli_stmt_close($stmt);
    }

    return $kategori;
}

function bayarIuran($idWarga)
{
    global $conn;

    $tanggalBayar = date('Y-m-d');
    $tglJatuhTempo = date('Y') . '-' . date('m') . '-15';

    $denda = 0;
    if (strtotime($tanggalBayar) > strtotime($tglJatuhTempo)) {
        $denda = 5000;
    }

    $jumlahIuran = 30000;
    $totalBayar = $jumlahIuran + $denda;

    $bulanIni = date('Y-m');
    $cek = $conn->prepare("SELECT 1 FROM pembayaran WHERE idWarga = ? AND DATE_FORMAT(tglPembayaran, '%Y-%m') = ?");
    $cek->bind_param("ss", $idWarga, $bulanIni);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        return false; // Sudah membayar bulan ini
    }

    // Ambil ID terakhir
    $result = $conn->query("SELECT idPembayaran FROM pembayaran ORDER BY idPembayaran DESC LIMIT 1");
    if ($row = $result->fetch_assoc()) {
        $lastId = (int)substr($row['idPembayaran'], 1); // Hilangkan 'P' dan ubah ke int
        $newId = 'P' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $newId = 'P001';
    }

    $idPembayaran = $newId;
    $idKodeBayar = "000";

    // Masukkan data
    $stmt = $conn->prepare("INSERT INTO pembayaran (idPembayaran, tglJatuhTempo, tglPembayaran, jumlahIuran, denda, totalBayar, idWarga, idKodeBayar)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "sssiiiss",
        $idPembayaran,
        $tglJatuhTempo,
        $tanggalBayar,
        $jumlahIuran,
        $denda,
        $totalBayar,
        $idWarga,
        $idKodeBayar
    );

    if ($stmt->execute()) {
        header("Location: ../../pages/warga/beranda-warga.php?status=berhasil");
        exit();
    } else {
        echo "<script>alert('Gagal membayar iuran.'); window.history.back();</script>";
        return false;
    }
}

function getTagihanWarga($idWarga)
{
    global $conn;

    $tanggalSekarang = date('Y-m-d');
    $bulan_tagihan = date('F Y');
    $tglJatuhTempo = date('Y') . '-' . date('m') . '-15';
    $iuran = 30000;
    $denda = (strtotime($tanggalSekarang) > strtotime($tglJatuhTempo)) ? 5000 : 0;
    $totalTagihan = $iuran + $denda;

    $bulanIni = date('Y-m');

    $cek = $conn->prepare("SELECT 1 FROM pembayaran WHERE idWarga = ? AND DATE_FORMAT(tglPembayaran, '%Y-%m') = ?");
    $cek->bind_param("ss", $idWarga, $bulanIni);
    $cek->execute();
    $cek->store_result();

    $sudahBayar = $cek->num_rows > 0;

    return [
        'bulan_tagihan' => $bulan_tagihan,
        'jatuh_tempo' => $tglJatuhTempo,
        'iuran' => $iuran,
        'denda' => $denda,
        'total' => $totalTagihan,
        'sudah_bayar' => $sudahBayar,
    ];
}

function getRiwayatPembayaran($id_warga, $limit = 5) {
    global $conn;

    $query = "SELECT * 
              FROM pembayaran 
              WHERE idWarga = ? 
              ORDER BY tglPembayaran DESC 
              LIMIT ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $id_warga, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    $riwayat = [];
    while ($row = $result->fetch_assoc()) {
        $riwayat[] = $row;
    }

    return $riwayat;
}

function getRTById($idRt) {
    global $conn;

    $query = "SELECT * FROM rt WHERE idRT = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $idRt);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc(); 
}



