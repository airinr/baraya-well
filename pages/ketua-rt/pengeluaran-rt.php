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
          <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">+ Tambah</button>
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
              <tr>
                <td class="p-2 border">02 Juli 2025</td>
                <td class="p-2 border">Perbaikan Jalan</td>
                <td class="p-2 border">Rp 300.000</td>
              </tr>
              <!-- Tambahkan data lain di sini -->
            </tbody>
          </table>
        </div>
      </div>


    </section>
  </main>
</body>
</html>
