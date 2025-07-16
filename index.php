<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Baraya Well</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans text-gray-800">

    <!-- Navbar -->
    <?php include 'layouts/navbar.php' ?>

    <!-- Hero Section -->
    <section class="flex flex-col-reverse md:flex-row items-center px-6 py-12 md:py-20 max-w-7xl mx-auto" id="home">
        <img src="src/assets/images/logo-baraya-well.png" alt="Hero Image" class="h-20" />
        <div class="md:w-1/2 text-center md:text-left space-y-4">
            <h1 class="text-4xl md:text-5xl font-extrabold">BARAYA WELL</h1>
            <p class="text-lg">Solusi keuangan warga</p>
            <a href="pages/warga/beranda-warga.php" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-md mt-4 hover:bg-blue-700">Login</a>
        </div>
        <div class="md:w-1/2">
            <div class="clip-triangle overflow-hidden">
                <img src="src/assets/images/landing-2.jpg" alt="Hero Image" class="w-full object-cover" />
            </div>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section class="px-6 py-12 max-w-5xl mx-auto text-center" id="about-us">
        <h2 class="text-2xl font-semibold mb-4">Siapa Kita?</h2>
        <p class="text-gray-700 mb-10">
            Baraya Well adalah platform digital yang dirancang khusus untuk membantu pengelolaan keuangan warga, seperti iuran bulanan, denda, dan dana sosial lainnya. Kami hadir untuk menjawab kebutuhan RT, RW, atau komunitas dalam mencatat transaksi keuangan dengan lebih transparan, efisien, dan mudah diakses oleh semua pihak.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-yellow-100 p-6 rounded-lg">
                <div class="text-4xl mb-2">📊</div>
                <p class="font-semibold">Pencatatan Keuangan</p>
            </div>
            <div class="bg-blue-100 p-6 rounded-lg">
                <div class="text-4xl mb-2">🧾</div>
                <p class="font-semibold">Transparan</p>
            </div>
            <div class="bg-yellow-100 p-6 rounded-lg">
                <div class="text-4xl mb-2">✔️</div>
                <p class="font-semibold">Praktis</p>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="text-center py-10">
        <h3 class="text-xl font-semibold mb-4">Bergabung dengan Kami!</h3>
        <a href="#" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Daftar RT</a>
    </section>

    <!-- Footer / Hubungi Kami -->
    <footer class="bg-blue-700 text-white p-6" id="contact-us">
        <h4 class="text-lg font-semibold">HUBUNGI KAMI</h4>
        <div class="px-10">
            <p>Kelompok RPL IF 5:</p>
            <ul class="px-6">
                <li>1. Airin Ristiana - 10123194</li>
                <li>2. Mutiara Annur - 10123</li>
                <li>3. Fathya Nurulhasanah - 10123190</li>
                <li>4. Annisa Nuraeni - 10123193</li>
                <li>5. Rizza Alyda Yahya - 10123212</li>
            </ul>
        </div>

    </footer>

    <style>
        /* Triangle style for hero image */
        .clip-triangle img {
            clip-path: polygon(100% 0, 100% 100%, 0% 100%);
        }
    </style>
</body>

</html>