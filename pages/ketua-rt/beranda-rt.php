<?php
include_once '../../services/ketua-rt-database/ketua-rt.php';

// Pastikan session sudah dimulai jika idRt diambil dari $_SESSION
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$idRt = $_SESSION['idRt'];

$total_pemasukan = getTotalPemasukan($idRt);
$total_pengeluaran = getTotalPengeluaran($idRt);
$sisa = $total_pemasukan - $total_pengeluaran;

$currentMonth = date('m');
$currentYear = date('Y');

$pengeluaran_bulanan = getPengeluaranBulanan($idRt, $currentMonth, $currentYear);

// Determine colors for balance
$sisa_color_class = 'text-white'; // Default to white
if ($sisa < 0) {
  $sisa_color_class = 'text-red-300'; // Red for negative, a lighter red for better contrast on dark blue
}
// If $sisa is 0 or positive, it will remain 'text-white'
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Beranda Pengeluaran Kas RT</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    /* Custom scrollbar (optional) */
    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }

    .scrollbar-hide {
      -ms-overflow-style: none;
      /* IE and Edge */
      scrollbar-width: none;
      /* Firefox */
    }
  </style>
</head>

<body class="bg-blue-50 min-h-screen font-sans antialiased flex flex-col">
  <?php include '../../layouts/navbar-warga.php' ?>

  <div class="flex flex-1">
    <?php include '../../layouts/sidebar-rt.php' ?>

    <main class="flex-1 p-4 md:p-8 lg:p-10 overflow-y-auto md:ml-64">

      <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-2xl font-bold text-blue-800 mb-2">Ringkasan Pengeluaran Kas</h2>
        <p class="text-gray-600">Pantau dan kelola semua pengeluaran kas lingkungan RT Anda.</p>
      </div>

      <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 md:p-8 rounded-lg shadow-lg mb-6 text-white text-center">
        <p class="text-sm opacity-90 mb-1">Saldo Kas Tersedia</p>
        <h2 class="text-4xl md:text-5xl font-extrabold mb-2 <?= $sisa_color_class ?>">Rp. <?= number_format($sisa, 0, ',', '.') ?></h2>
        <button class="text-blue-200 hover:text-white text-sm font-medium flex items-center justify-center mx-auto">
          Lihat Detail
          <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <a href="../ketua-rt/pengeluaran-rt.php" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-4 px-6 rounded-lg shadow-md flex items-center justify-center transition duration-300 ease-in-out">
          <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12A9 9 0 113 12a9 9 0 0118 0z"></path>
          </svg>
          Tambah Pengeluaran
        </a>
        <a href="../ketua-rt/pemasukan-rt.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-4 px-6 rounded-lg shadow-md flex items-center justify-center transition duration-300 ease-in-out">
          <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V4m0 12v4m-6-2h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
          </svg>
          Kas Masuk
        </a>
        <a href="../ketua-rt/warga-rt.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-4 px-6 rounded-lg shadow-md flex items-center justify-center transition duration-300 ease-in-out">
          <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-4m3 4v-4m3 4v-4m-9 8h10a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
          </svg>
          Lihat Anggota
        </a>
      </div>

      <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h3 class="text-xl md:text-2xl font-semibold text-blue-800 mb-4">Pengeluaran Bulan Juli 2025</h3>
        <div class="flex items-center justify-between mb-4">
          <p class="text-red-600 text-3xl md:text-4xl font-bold">Rp. <?= number_format($total_pengeluaran, 0, ',', '.') ?></p>
          <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
          </svg>
        </div>



        <?php foreach ($pengeluaran_bulanan as $data):
          $nama = $data['kategori'];
          $persentase = $data['persentase'];
          $pengeluaran = $data['nominal'];
          $alokasi = ($persentase / 100) * $total_pemasukan;
          $progress = $alokasi > 0 ? ($pengeluaran / $alokasi) * 100 : 0;
        ?>
          <div class="flex items-center">
            <span class="w-1/5 text-gray-700"><?= htmlspecialchars($nama) ?></span>
            <div class="w-2/3 bg-gray-200 rounded-full h-3">
              <div class="bg-blue-500 h-3 rounded-full" style="width: <?= $data['persentase'] ?>%;"></div>
            </div>
            <span class="ml-3 text-sm text-gray-600">
              Rp <?= number_format($pengeluaran, 0, ',', '.') ?>
            </span>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl md:text-2xl font-semibold text-blue-800 mb-4">Aktivitas Terbaru</h3>
        <div class="space-y-4 max-h-80 overflow-y-auto scrollbar-hide">
          <div class="flex items-center justify-between pb-3 border-b border-blue-100 last:border-b-0">
            <div>
              <p class="text-gray-400 text-sm">20 Juli 2025</p>
              <p class="font-medium text-gray-800">Airin membayar cash sebesar Rp. 35.000</p>
              <span class="text-xs text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">Denda: Rp 5.000</span>
            </div>
            <button class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75">
              Terima
            </button>
          </div>
        </div>
        <div class="text-center mt-6">
          <button class="text-blue-600 hover:text-blue-800 font-semibold px-4 py-2 rounded-lg transition duration-300 ease-in-out">
            Lihat Semua Pengeluaran
          </button>
        </div>
      </div>
    </main>
  </div>

</body>

</html>