<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin RT</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Header -->
  <header class="bg-blue-700 text-white p-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
      <h1 class="text-xl font-bold">Dashboard Admin RT 05</h1>
      <span class="text-sm">Selamat datang, Admin!</span>
    </div>
  </header>

  <!-- Main Layout -->
  <div class="flex max-w-7xl mx-auto mt-6">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md p-4 rounded-lg mr-4">
      <nav class="space-y-3">
        <a href="#" class="block text-blue-700 font-medium hover:underline">🏠 Beranda</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600">➕ Pemasukan</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600">➖ Pengeluaran</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600">📊 Rekapitulasi</a>
      </nav>
    </aside>

    <!-- Konten -->
    <main class="flex-1 bg-white p-6 rounded-lg shadow-md">
      <!-- Saldo -->
      <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">Saldo Kas</h2>
        <div class="bg-green-100 text-green-800 p-4 rounded-md shadow-inner">
          <p class="text-2xl font-bold">Rp 2.500.000</p>
        </div>
      </div>

      <!-- Tabel Pemasukan -->
      <div class="mb-8">
        <div class="flex justify-between items-center mb-2">
          <h3 class="font-semibold text-gray-700">Data Pemasukan</h3>
          <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">+ Tambah</button>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full border border-gray-200 text-sm">
            <thead class="bg-gray-200">
              <tr>
                <th class="p-2 border">Tanggal</th>
                <th class="p-2 border">Sumber</th>
                <th class="p-2 border">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="p-2 border">01 Juli 2025</td>
                <td class="p-2 border">Iuran Warga</td>
                <td class="p-2 border">Rp 500.000</td>
              </tr>
              <!-- Tambahkan data lain di sini -->
            </tbody>
          </table>
        </div>
      </div>

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
    </main>
  </div>

</body>
</html>
