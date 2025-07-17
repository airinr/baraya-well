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

        <form action="../../services/warga-database/warga.php?aksi=register" method="POST">
            <!-- Nama -->
            <div class="mb-4 flex items-center">
                <label for="nama" class="w-24 text-sm font-medium text-gray-700" >Nama</label>
                <input id="nama" name="nama" type="text" placeholder="Tulis di sini.." class="flex-1 border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1" />
            </div>

            <!-- Email -->
            <div class="mb-4 flex items-center">
                <label for="email" class="w-24 text-sm font-medium text-gray-700" >Email</label>
                <input id="email" name="email" type="email" placeholder="Tulis di sini.." class="flex-1 border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1" />
            </div>

            <!-- Password -->
            <div class="mb-4 flex items-center">
                <label for="password" class="w-24 text-sm font-medium text-gray-700" >Password</label>
                <input id="password" name="password" type="password" placeholder="Tulis di sini.." class="flex-1 border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1" />
            </div>

            <!-- Alamat -->
            <div class="mb-4 flex items-center">
                <label for="alamat" class="w-24 text-sm font-medium text-gray-700" >No Rumah</label>
                <input id="noRumah" name="noRumah" type="text" placeholder="Tulis di sini.." class="flex-1 border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1" />
            </div>

            <!-- RT -->
            <div class="mb-4 flex items-center">
                <label for="rt" class="w-24 text-sm font-medium text-gray-700" >RT</label>
                <input id="rt" name="rt" type="number" placeholder="Tulis di sini.." class="flex-1 border-b border-gray-700 bg-transparent focus:outline-none focus:border-blue-500 py-1" />
            </div>

            <!-- Tombol Daftar -->
            <button type="submit" class="w-full bg-[#3973B4] text-white py-2 rounded-md hover:bg-blue-700 transition mb-4">Daftar</button>
        </form>

    </div>

</body>

</html>