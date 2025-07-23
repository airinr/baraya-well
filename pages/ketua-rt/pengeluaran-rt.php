<?php
include '../../services/ketua-rt-database/ketua-rt.php';

// Pastikan session sudah dimulai jika idRt diambil dari $_SESSION
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$idRt = $_SESSION['idRt']; // pastikan sudah login & session tersedia

// Cek status sukses
$showSuccessPopup = false;
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    $showSuccessPopup = true;
}

// Ambil data pengeluaran dan kategori
$pengeluaran = getPengeluaran($idRt); // Asumsi ini mengambil data pengeluaran aktual
$kategori = getKategoriPengeluaran($idRt); // Asumsi ini mengambil data kategori pengeluaran
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Baraya Well - Pengeluaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar untuk tabel */
        .table-scroll-y::-webkit-scrollbar {
            height: 8px;
            background-color: #f1f1f1;
            border-radius: 4px;
        }
        .table-scroll-y::-webkit-scrollbar-thumb {
            background-color: #a0aec0; /* gray-400 */
            border-radius: 4px;
        }
        .table-scroll-y::-webkit-scrollbar-thumb:hover {
            background-color: #718096; /* gray-600 */
        }
    </style>
</head>

<body class="bg-blue-50 font-sans antialiased flex flex-col min-h-screen">

    <?php include '../../layouts/navbar-warga.php' ?>

    <main class="flex flex-1">
        <?php include '../../layouts/sidebar-rt.php' ?>

        <section class="flex-1 p-4 md:p-8 lg:p-10 space-y-8 overflow-y-auto md:ml-64">

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold text-blue-800 mb-2">Manajemen Pengeluaran Kas</h2>
                <p class="text-gray-600">Lihat detail pengeluaran bulanan dan kelola kategori.</p>
            </div>

            <?php include '../../layouts/saldo-rt.php' ?>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-xl text-gray-800">Data Kategori Pengeluaran</h3>
                    <button onclick="document.getElementById('popup-kategori').classList.remove('hidden')"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200 shadow-md flex items-center">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12A9 9 0 113 12a9 9 0 0118 0z"></path></svg>
                        Tambah Kategori
                    </button>
                </div>
                <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm table-scroll-y">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Persentase</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if ($kategori && $kategori->num_rows > 0): ?>
                                <?php while ($row = $kategori->fetch_assoc()): ?>
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($row['kategori']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= $row['persentase'] ?>%</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-center items-center space-x-2">
                                                </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada kategori pengeluaran.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-xl text-gray-800">Daftar Pengeluaran Bulanan</h3>
                    <button onclick="document.getElementById('popup-konfirmasi').classList.remove('hidden')"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200 shadow-md flex items-center">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12A9 9 0 113 12a9 9 0 0118 0z"></path></svg>
                        Tambah Pengeluaran
                    </button>
                </div>
                <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm table-scroll-y">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Keperluan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if ($pengeluaran && $pengeluaran->num_rows > 0): ?>
                                <?php while ($row = $pengeluaran->fetch_assoc()): ?>
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($row['tglPengeluaran']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($row['kategori']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-semibold">Rp. <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-center items-center space-x-2">
                                                </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data pengeluaran.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <div id="popup-kategori" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-[#E7FFF1] rounded-xl shadow-lg p-8 w-[350px] border-2 border-green-500 relative">
            <button onclick="document.getElementById('popup-kategori').classList.add('hidden')" class="absolute top-2 right-3 text-gray-700 text-xl">&times;</button>
            <h2 class="text-2xl font-bold text-center mb-6 text-green-700">Tambah Kategori</h2>
            <form method="POST" action="?aksi=tambah_kategori">
                <label class="block mb-2 font-medium text-gray-700">Nama Kategori</label>
                <input type="text" name="kategori" placeholder="Contoh: Kebersihan" required class="w-full mb-4 border-b border-black bg-transparent focus:outline-none py-1">
                <label class="block mb-2 font-medium text-gray-700">Persentase Kategori (%)</label>
                <select name="persentase" required class="w-full mb-4 border-b border-black bg-transparent focus:outline-none py-1">
                    <option value="">Pilih persentase</option>
                    <?php for ($i = 10; $i <= 100; $i += 10): ?>
                        <option value="<?= $i ?>"><?= $i ?>%</option>
                    <?php endfor; ?>
                </select>
                <button type="submit" class="w-full bg-green-600 text-white font-semibold py-2 rounded-md hover:bg-green-700 transition duration-200">
                    Simpan Kategori
                </button>
            </form>
        </div>
    </div>

    <div id="popup-konfirmasi" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg p-6 w-[350px] text-center border-2 border-blue-500 relative">
            <button onclick="document.getElementById('popup-konfirmasi').classList.add('hidden')" class="absolute top-2 right-3 text-gray-700 text-xl">&times;</button>
            <h2 class="text-xl font-bold text-blue-700 mb-4">Konfirmasi</h2>
            <p class="text-gray-700 mb-6">Apakah Anda yakin ingin menambahkan pengeluaran bulan ini?</p>
            <form id="formPengeluaran" method="POST" action="?aksi=tambah_pengeluaran">
                <button type="submit" name="refreshPengeluaran" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ya, Tambahkan</button>
            </form>
        </div>
    </div>

    <?php if ($showSuccessPopup): ?>
        <div id="popup-success" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
            <div class="bg-white w-full max-w-sm p-6 rounded-xl text-center border-2 border-green-600 shadow-2xl">
                <div class="w-16 h-16 mx-auto mb-4 bg-green-100 text-green-600 flex items-center justify-center rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-green-700 mb-2">Berhasil!</h2>
                <p class="text-gray-600 mb-4">Pengeluaran bulan ini berhasil ditambahkan.</p>
                <button onclick="document.getElementById('popup-success').classList.add('hidden')" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Tutup
                </button>
            </div>
        </div>
    <?php endif; ?>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const url = new URL(window.location);
            const status = url.searchParams.get('status');

            // Show success popup immediately if status is 'success'
            if (status === 'success') {
                const successPopup = document.getElementById('popup-success');
                if (successPopup) {
                    successPopup.classList.remove('hidden');
                }
                // Delay parameter removal to allow user to see the success message
                setTimeout(() => {
                    url.searchParams.delete('status');
                    window.history.replaceState({}, document.title, url.pathname);
                }, 2000); // Remove status after 2 seconds
            }

            // --- UNIVERSAL POPUP CLOSING LOGIC ---
            const allPopupWrappers = {
                'popup-kategori': document.getElementById('popup-kategori'),
                'popup-konfirmasi': document.getElementById('popup-konfirmasi'),
                'popup-success': document.getElementById('popup-success')
            };

            const allPopupContents = {
                'popup-kategori': allPopupWrappers['popup-kategori'] ? allPopupWrappers['popup-kategori'].querySelector('div') : null,
                'popup-konfirmasi': allPopupWrappers['popup-konfirmasi'] ? allPopupWrappers['popup-konfirmasi'].querySelector('div') : null,
                'popup-success': allPopupWrappers['popup-success'] ? allPopupWrappers['popup-success'].querySelector('div') : null
            };

            // Function to hide a specific popup
            function hidePopup(popupId) {
                const wrapper = document.getElementById(popupId);
                if (wrapper) {
                    wrapper.classList.add('hidden');
                }
            }

            // Add event listeners to 'X' buttons inside popups
            document.querySelectorAll('[id^="popup-"] button[onclick*="classList.add(\'hidden\')"]').forEach(button => {
                button.addEventListener('click', function(e) {
                    // Prevent immediate close of the parent wrapper from this click
                    e.stopPropagation();
                    // The inline onclick will handle hiding the specific popup
                });
            });

            // Add event listener to hide popup when clicking outside its content
            document.addEventListener('click', function(event) {
                for (const id in allPopupWrappers) {
                    const wrapper = allPopupWrappers[id];
                    const content = allPopupContents[id];

                    if (wrapper && !wrapper.classList.contains('hidden')) { // If wrapper is visible
                        // Check if the click occurred outside the content area
                        if (content && !content.contains(event.target)) {
                            hidePopup(id); // Hide the popup
                        }
                    }
                }
            });

            // Prevent clicks inside popup content from closing the popup (stopPropagation)
            for (const id in allPopupContents) {
                const content = allPopupContents[id];
                if (content) {
                    content.addEventListener('click', function(e) {
                        e.stopPropagation(); // Stop click from propagating to the document
                    });
                }
            }

            // Ensure buttons that open popups also stop propagation to prevent immediate re-close
            // Add this class to your buttons: `class="... popup-opener-button"`
            document.querySelectorAll('.bg-green-600, .bg-red-600, .bg-blue-600').forEach(btn => { // Target all buttons that might open a popup
                 btn.addEventListener('click', function(e) {
                    // Only stop propagation if the button's action is to open a popup
                    if (e.target.onclick && (e.target.onclick.toString().includes("classList.remove('hidden')"))) {
                         e.stopPropagation();
                    }
                 });
            });
        });
    </script>

</body>

</html>