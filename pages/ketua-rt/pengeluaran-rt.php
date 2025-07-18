<?php
include '../../services/ketua-rt-database/ketua-rt.php';

// Panggil fungsi pengeluaran berbasis persentase berdasarkan id RT
$idRt = $_SESSION['idRt']; // pastikan sudah login & session tersedia


// Kemudian ambil pengeluaran
$pengeluaran = getPengeluaran($idRt);
// Tambahkan ini setelah ambil pengeluaran
$kategori = getKategoriPengeluaran($idRt);

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

      <!-- Tabel Kategori -->
      <div>
        <div class="flex justify-between items-center mb-2">
          <h3 class="font-semibold text-gray-700">Data Kategori Pengeluaran</h3>
          <button onclick="document.getElementById('popup-kategori').classList.remove('hidden')" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
            + Tambah Kategori
          </button>
        </div>
        <div class="overflow-x-auto mb-6">
          <table class="w-full border border-gray-200 text-sm">
            <thead class="bg-gray-100">
              <tr>
                <th class="p-2 border">Nama Kategori</th>
                <th class="p-2 border">Persentase</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($kategori && $kategori->num_rows > 0): ?>
                <?php while ($row = $kategori->fetch_assoc()): ?>
                  <tr>
                    <td class="p-2 border"><?= htmlspecialchars($row['kategori']) ?></td>
                    <td class="p-2 border"><?= $row['persentase'] ?>%</td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="2" class="text-center p-4">Belum ada kategori.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>



      <!-- Tabel Pengeluaran -->
      <div>
        <div class="flex justify-between items-center mb-2">
          <h3 class="font-semibold text-gray-700">Data Pengeluaran</h3>
          <form method="POST" action="?aksi=tambah_pengeluaran">
            <button type="submit" name="refreshPengeluaran" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
              + Tambah Pengeluaran
            </button>
          </form>


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

  <!-- POPUP TAMBAH KATEGORI -->
  <div id="popup-kategori" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-[#E7FFF1] rounded-xl shadow-lg p-8 w-[350px] border-2 border-green-500 relative">

      <button onclick="document.getElementById('popup-kategori').classList.add('hidden')" class="absolute top-2 right-3 text-gray-700 text-xl">&times;</button>

      <h2 class="text-2xl font-bold text-center mb-6 text-green-700">Tambah Kategori</h2>

      <form method="POST" action="?aksi=tambah_kategori">
        <label class="block mb-2 font-medium text-gray-700">Nama Kategori</label>
        <input type="text" name="kategori" placeholder="Contoh: Kebersihan" required class="w-full mb-4 border-b border-black bg-transparent focus:outline-none py-1">

        <label class="block mb-2 font-medium text-gray-700">Persentase Kategori (%)</label>
        <select name="persentase" required class="w-full mb-4 border-b border-black bg-transparent focus:outline-none py-1">
          <option value="">Pilih persentase</option>
          <option value="10">10%</option>
          <option value="20">20%</option>
          <option value="30">30%</option>
          <option value="40">40%</option>
          <option value="50">50%</option>
          <option value="60">60%</option>
          <option value="70">70%</option>
          <option value="80">80%</option>
          <option value="90">90%</option>
          <option value="100">100%</option>
        </select>


        <button type="submit" class="w-full bg-green-600 text-white font-semibold py-2 rounded-md hover:bg-green-700 transition duration-200">
          Simpan Kategori
        </button>
      </form>
    </div>
  </div>


</body>

</html>