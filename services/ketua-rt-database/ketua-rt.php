<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "baraya_well";

$conn = new mysqli($host, $user, $pass, $db);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

function loginRt($username, $password)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM rt WHERE nama = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Login berhasil, simpan ke session
            $_SESSION['idRt'] = $user['idRt'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['rt'] = $user['rt'];
            $_SESSION['rw'] = $user['rw'];

            header("Location: pages/ketua-rt/beranda-rt.php");
            exit();
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Akun tidak ditemukan!'); window.history.back();</script>";
    }

    $stmt->close();
}



function getPemasukan($idRt)
{
    global $conn;
    $query = "SELECT pembayaran.tglPembayaran, warga.nama, pembayaran.totalBayar FROM pembayaran, warga, rt WHERE pembayaran.idWarga = warga.idWarga AND warga.idRt = rt.idRt AND rt.idRt = '$idRt' ";
    return $conn->query($query);
}

function getPengeluaran($idRt)
{
    global $conn;
    $query = "SELECT * FROM pengeluaran, kategori, rt WHERE pengeluaran.idKategori = kategori.idKategori AND pengeluaran.idRt = rt.idRt AND rt.idRt = '$idRt'";
    return $conn->query($query);
}

function getWarga($idRt)
{
    global $conn;
    $query = "SELECT warga.idWarga, warga.nama, warga.email, warga.noRumah FROM warga, rt WHERE warga.idRt = rt.idRt AND rt.idRt = '$idRt' ";
    return $conn->query($query);
}

function getTotalPemasukan($idRt)
{
    global $conn;
    $query = "SELECT SUM(totalBayar) AS total FROM pembayaran, warga, rt WHERE pembayaran.idWarga = warga.idWarga AND warga.idRt= rt.idRt AND rt.idRt = '$idRt' ";
    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['total'] ?? 0;
    } else {
        return 0;
    }
}


function insertWarga()
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

        // Cek email unik
        $cek = $conn->prepare("SELECT idWarga FROM warga WHERE email = ?");
        $cek->bind_param("s", $email);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows > 0) {
            echo "<script>alert('Email sudah digunakan!'); window.history.back();</script>";
            return;
        }

        // Generate idWarga otomatis
        $result = $conn->query("SELECT MAX(idWarga) AS kode_terakhir FROM warga");
        $row = $result->fetch_assoc();
        $kode_terakhir = $row['kode_terakhir'];

        $idWarga = $kode_terakhir
            ? "W" . str_pad(intval(substr($kode_terakhir, 1)) + 1, 3, "0", STR_PAD_LEFT)
            : "W001";

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO warga (idWarga, nama, email, password, noRumah, idRt) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $idWarga, $nama, $email, $hashed_password, $noRumah, $idRt);

        if ($stmt->execute()) {
            echo "<script>alert('Data warga berhasil ditambahkan!'); window.location.href='../../pages/ketua-rt/warga-rt.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan warga: " . $conn->error . "'); window.history.back();</script>";
        }

        $stmt->close();
    }
}

function getIdWarga()
{
    global $conn;

    // Generate idWarga otomatis
    $result = $conn->query("SELECT MAX(idWarga) AS kode_terakhir FROM warga");
    $row = $result->fetch_assoc();
    $kode_terakhir = $row['kode_terakhir'];

    $idWarga = $kode_terakhir
        ? "W" . str_pad(intval(substr($kode_terakhir, 1)) + 1, 3, "0", STR_PAD_LEFT)
        : "W001";



    return $idWarga;
}

function updateWarga()
{
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idWarga = $_POST['idWarga'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $noRumah = $_POST['noRumah'];

        $stmt = $conn->prepare("UPDATE warga SET nama = ?, email = ?, noRumah = ? WHERE idWarga = ?");
        $stmt->bind_param("ssss", $nama, $email, $noRumah, $idWarga);

        if ($stmt->execute()) {
            echo "<script>alert('Data warga berhasil diperbarui!'); window.location.href='../../pages/ketua-rt/warga-rt.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data: " . $conn->error . "'); window.history.back();</script>";
        }

        $stmt->close();
    }
}

function hapusWarga()
{
    global $conn;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['noRumah'])) {
        $noRumah = mysqli_real_escape_string($conn, $_POST['noRumah']);

        $query = "DELETE FROM warga WHERE noRumah = '$noRumah'";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil dihapus!'); window.location.href='../../pages/ketua-rt/warga-rt.php';</script>";
            exit();
        } else {
            echo "Gagal menghapus data: " . mysqli_error($conn);
        }
    }
}

function pengeluaranRt($idRt)
{
    global $conn;

    // Pastikan format tanggal konsisten
    $tanggal = date('Y-m-d');

    // 1. Ambil total pemasukan dari RT
    $sqlPemasukan = "SELECT SUM(totalBayar) AS total 
                     FROM pembayaran 
                     JOIN warga ON pembayaran.idWarga = warga.idWarga 
                     JOIN rt ON warga.idRt = rt.idRt 
                     WHERE rt.idRt = '$idRt'";
    $result = $conn->query($sqlPemasukan);
    $totalPemasukan = $result->fetch_assoc()['total'];

    if (!$totalPemasukan || $totalPemasukan <= 0) {
        return; // Tidak ada pemasukan, tidak perlu lanjut
    }

    // 2. Ambil semua kategori pengeluaran dan persentasenya
    $sqlKategori = "SELECT idKategori, persentase FROM kategori";
    $kategoriResult = $conn->query($sqlKategori);

    while ($row = $kategoriResult->fetch_assoc()) {
        $idKategori = $row['idKategori'];
        $persen = $row['persentase'];
        $jumlah = ($persen / 100) * $totalPemasukan;

        // 3. Cek apakah sudah ada data untuk kategori + tanggal + RT
        $check = $conn->query("SELECT * FROM pengeluaran 
                               WHERE idKategori = '$idKategori' 
                               AND tglPengeluaran = '$tanggal'
                               AND idRt = '$idRt'");
        if ($check->num_rows == 0) {
            // 4. Buat idPengeluaran unik (otomatis N001, N002, dst)
            $getLast = $conn->query("SELECT idPengeluaran FROM pengeluaran ORDER BY idPengeluaran DESC LIMIT 1");
            if ($getLast->num_rows > 0) {
                $lastId = $getLast->fetch_assoc()['idPengeluaran'];
                $lastNum = (int)substr($lastId, 1); // Ambil angka dari Nxxx
                $newNum = $lastNum + 1;
                $idPengeluaran = 'N' . str_pad($newNum, 3, '0', STR_PAD_LEFT);
            } else {
                $idPengeluaran = 'N001';
            }

            // 5. Masukkan ke database
            $conn->query("INSERT INTO pengeluaran (idPengeluaran, tglPengeluaran, nominal, idRt, idKategori)
                          VALUES ('$idPengeluaran', '$tanggal', '$jumlah', '$idRt', '$idKategori')");
        }
    }
}


function getTotalPengeluaran($idRt)
{
    global $conn;
    $query = "SELECT SUM(nominal) AS total FROM pengeluaran WHERE idRt = '$idRt' ";
    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        return (int) ($row['total'] ?? 0); // Casting ke integer
    } else {
        return 0;
    }
}

function insertKategori($kategori, $persentase)
{
    global $conn;

    // Ambil idRt dari session
    $idRt = $_SESSION['idRt'] ?? null;
    if (!$idRt) {
        return false; // Tidak bisa insert jika belum login
    }

    // Ambil ID terakhir dari tabel kategori
    $queryLastId = "SELECT idKategori FROM kategori ORDER BY idKategori DESC LIMIT 1";
    $result = $conn->query($queryLastId);

    if ($result && $result->num_rows > 0) {
        $lastId = $result->fetch_assoc()['idKategori'];
        $number = (int)substr($lastId, 1);
        $newNumber = $number + 1;
        $newId = 'K' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    } else {
        $newId = 'K001';
    }

    // Eksekusi insert
    $query = "INSERT INTO kategori (idKategori, kategori, persentase, idRt)
              VALUES ('$newId', '$kategori', '$persentase', '$idRt')";

    return $conn->query($query);
}

function getKategoriPengeluaran($idRt) {
    global $conn;
    $query = "SELECT * FROM kategori WHERE idRt = '$idRt'";
    return $conn->query($query);
}





if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    switch ($aksi) {
        case "register":
            registerRt();
            break;

        case "tambah_warga":
            insertWarga();
            break;

        case "edit_warga":
            updateWarga();
            break;

        case "hapus_warga":
            hapusWarga();
            break;

        case "tambah_pengeluaran":
            $idRt = $_SESSION['idRt'] ?? null;
            if ($idRt) {
                pengeluaranRt($idRt);
            }
            break;

        case "tambah_kategori":
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $kategori = $_POST['kategori'] ?? '';
                $persentase = $_POST['persentase'] ?? 0;

                if (insertKategori($kategori, $persentase)) {
                    echo "<script>alert('Kategori berhasil ditambahkan!'); window.location.href=document.referrer;</script>";
                } else {
                    echo "<script>alert('Gagal menambahkan kategori.'); window.history.back();</script>";
                }
            }
            break;

        default:
            echo "Fungsi '$aksi' tidak dikenali.";
            break;
    }
}

