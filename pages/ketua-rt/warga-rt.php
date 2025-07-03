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
    <?php include '../../layouts/header-rt.php' ?>

    <!-- Main Layout -->
    <div class="flex max-w-7xl mx-auto mt-6">

        <!-- side bar -->
        <?php include '../../layouts/sidebar-rt.php' ?>

        <!-- Konten -->
        <main class="flex-1 bg-white p-6 rounded-lg shadow-md">
            <?php include '../../layouts/saldo-rt.php' ?>

            <!-- Tabel Pengeluaran -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-semibold text-gray-700">Data Warga</h3>
                    <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">+ Tambah</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="p-2 border w-[160px]">No Rumah</th>
                                <th class="p-2 border">Nama</th>
                                <th class="p-2 border text-center w-[160px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-2 border">002</td>
                                <td class="p-2 border">Airin Ristiana</td>
                                <td class="p-2 border text-center">
                                    <div class="flex justify-center items-center space-x-2">
                                        <!-- Tombol Update -->
                                        <a href="#" class="bg-yellow-400 text-white px-2 py-1 rounded text-xs hover:bg-yellow-500">Update</a>
                                        <!-- Tombol Delete -->
                                        <a href="#" onclick="return confirm('Yakin ingin menghapus data ini?')" class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </main>
    </div>

</body>

</html>