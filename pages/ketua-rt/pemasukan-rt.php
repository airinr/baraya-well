<?php
include '../../services/ketua-rt-database/ketua-rt.php';

$pemasukan = getPemasukan($_SESSION['idRt']);
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
  <?php include '../../layouts/navbar-warga.php' ?>

  <main class="flex min-h-screen">

    <!-- Sidebar -->
    <?php include '../../layouts/sidebar-rt.php' ?>

    <!-- Konten Utama -->
    <section class="flex-1 p-10 space-y-6">

      <!-- Total Saldo -->
      <?php include '../../layouts/saldo-rt.php' ?>

      <!-- Tabel Pemasukan -->
      <div class="mb-8">
        <div class="flex justify-between items-center mb-2">
          <h3 class="font-semibold text-gray-700">Data Pemasukan</h3>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full border border-gray-200 text-sm">
            <thead class="bg-gray-200">
              <tr>
                <th class="p-2 border">Tanggal</th>
                <th class="p-2 border">Nama Warga</th>
                <th class="p-2 border">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($pemasukan && $pemasukan->num_rows > 0): ?>
                <?php while ($row = $pemasukan->fetch_assoc()): ?>
                  <tr>
                    <td class="p-2 border"><?= $row['tglPembayaran'] ?></td>
                    <td class="p-2 border"><?= htmlspecialchars($row['nama']) ?></td>
                    <td class="p-2 border">Rp<?= $row['totalBayar'] ?></td> <!-- contoh dummy -->
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


      </div>
      </div>


    </section>
  </main>
</body>

</html>