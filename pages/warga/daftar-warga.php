<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Mulai session
include '../../services/warga-database/warga.php';

$ketuaRt = ketuaRt();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#3973B4] h-screen flex items-center justify-center font-sans">

    <div class="bg-[#F3EEC0] rounded-xl p-10 w-[350px] md:w-[400px]">
        <h1 class="text-center text-2xl font-bold mb-8">REGISTER WARGA</h1>

        <?php if (isset($_SESSION['nama'])): ?>
            <p class="text-green-600 mb-4 text-sm text-center">
                Halo, <?= $_SESSION['nama'] ?>! Kamu sudah login.
            </p>
        <?php endif; ?>

        <form action="../../services/warga-database/warga.php?aksi=register" method="POST">
            <!-- Nama -->
            <div class="mb-4 flex items-center">
                <label for="nama" class="w-24 text-sm font-medium text-gray-700">Nama</label>
                <input id="nama" name="nama" type="text" placeholder="Tulis di sini.." class="flex-1 border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1" required />
            </div>

            <!-- Email -->
            <div class="mb-4 flex items-center">
                <label for="email" class="w-24 text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" placeholder="Tulis di sini.." class="flex-1 border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1" required />
            </div>

            <!-- Password -->
            <div class="mb-4 flex items-center">
                <label for="password" class="w-24 text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" placeholder="Tulis di sini.." class="flex-1 border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1" required />
            </div>

            <!-- No Rumah -->
            <div class="mb-4 flex items-center">
                <label for="noRumah" class="w-24 text-sm font-medium text-gray-700">No Rumah</label>
                <input id="noRumah" name="noRumah" type="text" placeholder="Tulis di sini.." class="flex-1 border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1" required />
            </div>

            <!-- RT -->
            <div class="mb-4 flex items-center">
                <label for="rt" class="w-24 text-sm font-medium text-gray-700">RT</label>
                <select id="idRt" name="idRt" required class="flex-1 border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1">
                    <option value="" disabled selected>Pilih RT</option>
                    <?php foreach ($ketuaRt as $rt): ?>
                        <option value=<?= $rt['idRt'] ?>> 
                            <?= $rt['nama'] ?> - RT: <?= $rt['rt'] ?> - RW: <?= $rt['rw'] ?> - <?= $rt['idRt'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tombol Daftar -->
            <button type="submit" class="w-full bg-[#3973B4] text-white py-2 rounded-md hover:bg-blue-700 transition mb-4">Daftar</button>
        </form>
    </div>

</body>
</html>
