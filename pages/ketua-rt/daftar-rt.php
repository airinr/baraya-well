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
            <!-- Alamat -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="alamat">alamat</label>
                <input id="alamat" type="text" placeholder="Tulis di sini.." class="w-full border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1" />
            </div>

            <!-- RT -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="rt">RT</label>
                <input id="rt" type="number" placeholder="Tulis di sini.." class="w-full border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1" />
            </div>

            <!-- RW -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="rw">rw</label>
                <input id="rw" type="number" placeholder="Tulis di sini.." class="w-full border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1" />
            </div>

            <!-- Tombol Login -->
            <button onclick="window.location.href='pages/ketua-rt/beranda-rt.php'" class="w-full bg-[#3973B4] text-white py-2 rounded-md hover:bg-blue-700 transition mb-4">Daftar</button>
        </form>

    </div>

</body>

</html>