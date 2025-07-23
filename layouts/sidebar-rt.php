<?php
// Dapatkan nama file yang sedang aktif
// Contoh: Jika URL adalah http://localhost/kasrt/pages/rt/pengeluaran-rt.php
// Maka $current_page akan menjadi 'pengeluaran-rt.php'
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="fixed top-0 left-0 w-full md:w-64 bg-blue-900 text-white p-4 h-screen flex flex-col z-40">
    <div class="mb-8 mt-12 md:mt-0"> <h2 class="text-xl font-bold">Menu Admin RT</h2>
        <p class="text-blue-200 text-sm">Selamat Datang!</p>
    </div>

    <nav class="flex-grow">
        <ul>
            <li class="mb-3">
                <a href="beranda-rt.php" class="flex items-center p-2 rounded-lg hover:bg-blue-700 transition duration-200
                    <?php echo ($current_page == 'beranda-rt.php') ? 'bg-blue-700' : ''; ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1H3m10 0l-2-2m2 2l-7-7m7 7H6"></path></svg>
                    <span>Beranda</span>
                </a>
            </li>
            <li class="mb-3">
                <a href="pengeluaran-rt.php" class="flex items-center p-2 rounded-lg hover:bg-blue-700 transition duration-200
                    <?php echo ($current_page == 'pengeluaran-rt.php') ? 'bg-blue-700' : ''; ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-4m3 4v-4m3 4v-4m-9 8h10a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span>Pengeluaran</span>
                </a>
            </li>
            <li class="mb-3">
                <a href="pemasukan-rt.php" class="flex items-center p-2 rounded-lg hover:bg-blue-700 transition duration-200
                    <?php echo ($current_page == 'pemasukan-rt.php') ? 'bg-blue-700' : ''; ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Pemasukan</span>
                </a>
            </li>
            <li class="mb-3">
                <a href="warga-rt.php" class="flex items-center p-2 rounded-lg hover:bg-blue-700 transition duration-200
                    <?php echo ($current_page == 'warga-rt.php') ? 'bg-blue-700' : ''; ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M10 20v-2a3 3 0 013-3h4a3 3 0 013 3v2M3 8a2 2 0 012-2h3"></path></svg>
                    <span>Anggota</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="mt-auto pt-6">
        <a href="#" class="flex items-center p-2 rounded-lg text-red-300 hover:bg-blue-700 hover:text-red-100 transition duration-200">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span>Keluar</span>
        </a>
    </div>
</aside>