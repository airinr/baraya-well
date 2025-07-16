<?php
include '../../services/ketua-rt-database/ketua-rt.php';

$pengeluaran = getPengeluaran();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Baraya Well</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white font-sans">

  <!-- Navbar -->
  <?php include '../../layouts/navbar.php' ?>

  <main class="flex min-h-screen">

    <!-- Sidebar -->
    <?php include '../../layouts/sidebar-rt.php' ?>

    <!-- Konten Utama -->
    <section class="flex-1 p-10 space-y-6">

      <!-- Total Saldo -->
      <?php include '../../layouts/saldo-rt.php' ?>

      <!-- Tabel Pengeluaran -->
      <div>
        <div class="flex justify-between items-center mb-2">
          <h3 class="font-semibold text-gray-700">Data Pengeluaran</h3>
          <button onclick="document.getElementById('popup-pengeluaran').classList.remove('hidden')" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">+ Tambah</button>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full border border-gray-200 text-sm">
            <thead class="bg-gray-200">
              <tr>
                <th class="p-2 border">Tanggal</th>
                <th class="p-2 border">Keperluan</th>
                <th class="p-2 border">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($pengeluaran && $pengeluaran->num_rows > 0): ?>
                <?php while ($row = $pengeluaran->fetch_assoc()): ?>
                  <tr>
                    <td class="p-2 border"><?= $row['tglPengeluaran'] ?></td>
                    <td class="p-2 border"><?= htmlspecialchars($row['kategori']) ?></td>
                    <td class="p-2 border">Rp<?= $row['nominal'] ?></td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="3" class="text-center p-4">Tidak ada data pemasukan.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </main>

  <!-- POPUP PENGELUARAN -->
  <div id="popup-pengeluaran" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-[#FFF8DC] rounded-xl shadow-lg p-8 w-[350px] border-2 border-blue-400 relative">

      <!-- Tombol Close -->
      <button onclick="document.getElementById('popup-pengeluaran').classList.add('hidden')" class="absolute top-2 right-3 text-gray-700 text-xl">&times;</button>

      <h2 class="text-2xl font-bold text-center mb-6">PENGELUARAN</h2>

      <form>
        <label class="block mb-2 font-medium">Tanggal Pengeluaran</label>
        <input type="date" placeholder="Tulis di sini.." class="w-full mb-4 border-b border-black bg-transparent focus:outline-none py-1" id="tglPengeluaran">

        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-1" for="kategori">Kategori</label>
          <select id="kategori" name="kategori" class="w-full border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1">
            <option value="" disabled selected>Kategori Pengeluaran</option>
            <option value="kebersihan">Kebersihan</option>
            <option value="keamanan">Keamanan</option>
          </select>
        </div>

        <label class="block text-sm font-medium text-gray-700 mb-1">Nominal</label>
        <input type="number" placeholder="Tulis di sini.." class="w-full mb-4 border-b border-black bg-transparent focus:outline-none py-1" id="nominal">

        <button type="submit" class="w-full bg-[#3674B5] text-white font-semibold py-2 rounded-md hover:bg-blue-700 transition duration-200">
          Tambah
        </button>
      </form>
    </div>
  </div>


</body>

</html>