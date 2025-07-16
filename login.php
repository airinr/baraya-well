<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#3973B4] h-screen flex items-center justify-center font-sans">

  <div class="bg-[#F3EEC0] rounded-xl p-10 w-[350px] md:w-[400px]">
    <h1 class="text-center text-2xl font-bold mb-8">LOGIN</h1>

    <!-- Username -->
    <div class="mb-6">
      <label class="block text-sm font-medium text-gray-700 mb-1" for="username">Username</label>
      <input id="username" type="text" placeholder="Tulis di sini.." class="w-full border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1" />
    </div>

    <!-- Password -->
    <div class="mb-8">
      <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Password</label>
      <input id="password" type="password" placeholder="Tulis di sini.." class="w-full border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1" />
    </div>

    <!-- role -->
    <div class="mb-6">
      <label class="block text-sm font-medium text-gray-700 mb-1" for="role">Daftar Sebagai?</label>
      <select id="role" name="role" class="w-full border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1">
        <option value="" disabled selected>Pilih peran Anda</option>
        <option value="warga">Warga</option>
        <option value="ketua">Ketua RT</option>
      </select>
    </div>

    <!-- Tombol Login -->
    <!-- <a href="pages/ketua-rt/beranda-rt.php" class="w-full bg-[#3973B4] text-white py-2 rounded-md hover:bg-blue-700 transition mb-4"> Login </a> -->
    <button onclick="window.location.href='pages/ketua-rt/beranda-rt.php'" class="w-full bg-[#3973B4] text-white py-2 rounded-md hover:bg-blue-700 transition mb-4">Login</button>

    <!-- Link ke Daftar -->
    <p class="text-center text-sm text-gray-700">
      Belum punya akun?
      <a href="register.php" class="text-blue-600 hover:underline">Daftar disini</a>
    </p>
  </div>

</body>

</html>