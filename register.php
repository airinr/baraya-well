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
        <h1 class="text-center text-2xl font-bold mb-8">REGISTER</h1>

        <form action="">
            <!-- Email -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email</label>
                <input id="email" type="text" placeholder="Tulis di sini.." class="w-full border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1" />
            </div>

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
                <select id="role" class="w-full border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1">
                    <option value="" disabled selected>Pilih peran Anda</option>
                    <option value="warga">Warga</option>
                    <option value="ketua">Ketua RT</option>
                </select>
            </div>

            
        </form>

        <!-- Tombol Login -->
            <button onclick="window.location.href='pages/ketua-rt/daftar-rt.php'" class="w-full bg-[#3973B4] text-white py-2 rounded-md hover:bg-blue-700 transition mb-4">Register</button>

        <!-- Link ke Daftar -->
        <p class="text-center text-sm text-gray-700">
            Sudah punya akun?
            <a href="login.php" class="text-blue-600 hover:underline">Masuk disini</a>
        </p>
    </div>

</body>

</html>