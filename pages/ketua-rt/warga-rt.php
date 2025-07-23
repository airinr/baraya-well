<?php
include '../../services/ketua-rt-database/ketua-rt.php';

// Pastikan session sudah dimulai jika idRt diambil dari $_SESSION
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$idRt = $_SESSION['idRt'];

$warga = getWarga($idRt);
$idWarga = getIdWarga(); // Assuming this generates a new ID for the form
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Baraya Well - Data Warga</title>
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
                <h2 class="text-2xl font-bold text-blue-800 mb-2">Manajemen Data Warga</h2>
                <p class="text-gray-600">Kelola informasi kepala keluarga yang terdaftar di lingkungan RT Anda.</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-xl text-gray-800">Daftar Warga</h3>
                    <button onclick="document.getElementById('popup-warga').classList.remove('hidden')"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 shadow-md flex items-center popup-opener-button">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12A9 9 0 113 12a9 9 0 0118 0z"></path></svg>
                        Tambah Warga
                    </button>
                </div>
                <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm table-scroll-y">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Id Warga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">No Rumah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama Kepala Keluarga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if ($warga && $warga->num_rows > 0): ?>
                                <?php while ($row = $warga->fetch_assoc()): ?>
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $row['idWarga'] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= $row['noRumah'] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($row['nama']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= $row['email'] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-center items-center space-x-2">
                                                <button onclick="openEditPopup('<?= $row['idWarga'] ?>','<?= $row['noRumah'] ?>','<?= htmlspecialchars($row['nama'], ENT_QUOTES) ?>','<?= $row['email'] ?>')"
                                                    class="bg-yellow-500 text-white px-3 py-1 rounded-md text-xs hover:bg-yellow-600 transition duration-200 popup-opener-button">
                                                    Edit
                                                </button>
                                                <button onclick="openDeletePopup('<?= $row['noRumah'] ?>')"
                                                    class="bg-red-500 text-white px-3 py-1 rounded-md text-xs hover:bg-red-600 transition duration-200 popup-opener-button">
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data warga.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <div id="popup-warga" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div id="popup-content" class="bg-white rounded-xl shadow-lg p-8 w-[350px] border-2 border-blue-400 relative">
            <button onclick="document.getElementById('popup-warga').classList.add('hidden')" class="absolute top-2 right-3 text-gray-700 text-xl close-popup-button">&times;</button>
            <h2 class="text-2xl font-bold text-center mb-6 text-blue-700">Tambah Warga</h2>
            <form method="POST" action="../../services/ketua-rt-database/ketua-rt.php?aksi=tambah_warga">
                <input type="hidden" name="idRt" value="R001">

                <label class="block mb-2 font-medium text-gray-700">ID Warga</label>
                <input type="text" value="<?= htmlspecialchars($idWarga) ?>" disabled class="w-full mb-4 border-b border-black bg-gray-100 cursor-not-allowed py-1">

                <label class="block mb-2 font-medium text-gray-700">Nama Kepala Keluarga</label>
                <input type="text" name="nama" required class="w-full mb-4 border-b border-black bg-transparent focus:outline-none py-1">

                <label class="block mb-2 font-medium text-gray-700">Email</label>
                <input type="email" name="email" required class="w-full mb-4 border-b border-black bg-transparent focus:outline-none py-1">

                <label class="block mb-2 font-medium text-gray-700">Password</label>
                <input type="text" name="password" required class="w-full mb-4 border-b border-black bg-transparent focus:outline-none py-1">

                <label class="block mb-2 font-medium text-gray-700">Nomor Rumah</label>
                <input type="text" name="noRumah" required class="w-full mb-4 border-b border-black bg-transparent focus:outline-none py-1">

                <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-700 transition duration-200">
                    Simpan
                </button>
            </form>
        </div>
    </div>

    <div id="popup-edit" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div id="popup-edit-content" class="bg-white rounded-xl shadow-lg p-8 w-[350px] border-2 border-yellow-400 relative">
            <button onclick="document.getElementById('popup-edit').classList.add('hidden')" class="absolute top-2 right-3 text-gray-700 text-xl close-popup-button">&times;</button>
            <h2 class="text-2xl font-bold text-center mb-6 text-yellow-600">Edit Warga</h2>
            <form method="POST" action="../../services/ketua-rt-database/ketua-rt.php?aksi=edit_warga">
                <input type="text" id="editIdWargaDisplay" disabled class="w-full mb-4 border-b border-black bg-gray-100 cursor-not-allowed py-1" />
                <input type="hidden" name="idWarga" id="editIdWarga" />
                <label class="block mb-2 font-medium text-gray-700">Nomor Rumah</label>
                <input type="text" name="noRumah" id="editNoRumah" required class="w-full mb-4 border-b border-black bg-transparent py-1">
                <label class="block mb-2 font-medium text-gray-700">Nama Kepala Keluarga</label>
                <input type="text" name="nama" id="editNamaKepala" required class="w-full mb-4 border-b border-black bg-transparent py-1">
                <label class="block mb-2 font-medium text-gray-700">Email</label>
                <input type="text" name="email" id="editEmailWarga" required class="w-full mb-4 border-b border-black bg-transparent py-1">
                <button type="submit" class="w-full bg-yellow-500 text-white font-semibold py-2 rounded-md hover:bg-yellow-600 transition duration-200">
                    Perbarui
                </button>
            </form>
        </div>
    </div>


    <div id="popup-delete" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div id="popup-delete-content" class="bg-white rounded-xl shadow-lg p-8 w-[350px] border-2 border-red-400 relative">
            <button onclick="document.getElementById('popup-delete').classList.add('hidden')" class="absolute top-2 right-3 text-gray-700 text-xl close-popup-button">&times;</button>
            <h2 class="text-2xl font-bold text-center mb-6 text-red-600">Hapus Warga</h2>
            <p class="text-center text-gray-700 mb-6">Yakin ingin menghapus warga dengan No Rumah <span id="deleteNoRumah" class="font-semibold text-red-500"></span>?</p>
            <form method="POST" action="../../services/ketua-rt-database/ketua-rt.php?aksi=hapus_warga">
                <input type="hidden" name="noRumah" id="deleteInputNoRumah">
                <button type="submit" class="w-full bg-red-600 text-white font-semibold py-2 rounded-md hover:bg-red-700 transition duration-200">
                    Hapus
                </button>
            </form>
        </div>
    </div>


    <script>
        function openEditPopup(idWarga, noRumah, nama, email) {
            document.getElementById('editIdWargaDisplay').value = idWarga; // yang tampil
            document.getElementById('editIdWarga').value = idWarga; // yang dikirim

            document.getElementById('editNoRumah').value = noRumah;
            document.getElementById('editNamaKepala').value = nama;
            document.getElementById('editEmailWarga').value = email;
            document.getElementById('popup-edit').classList.remove('hidden');
        }

        function openDeletePopup(noRumah) {
            document.getElementById('deleteNoRumah').textContent = noRumah;
            document.getElementById('deleteInputNoRumah').value = noRumah;
            document.getElementById('popup-delete').classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Define all popup wrappers by their IDs
            const allPopupWrappers = {
                'popup-warga': document.getElementById('popup-warga'),
                'popup-edit': document.getElementById('popup-edit'),
                'popup-delete': document.getElementById('popup-delete')
            };

            // Define the actual content divs inside each popup wrapper
            const allPopupContents = {
                'popup-warga': allPopupWrappers['popup-warga'] ? allPopupWrappers['popup-warga'].querySelector('div') : null,
                'popup-edit': allPopupWrappers['popup-edit'] ? allPopupWrappers['popup-edit'].querySelector('div') : null,
                'popup-delete': allPopupWrappers['popup-delete'] ? allPopupWrappers['popup-delete'].querySelector('div') : null
            };

            // Function to hide a specific popup
            function hidePopup(popupId) {
                const wrapper = document.getElementById(popupId);
                if (wrapper) {
                    wrapper.classList.add('hidden');
                }
            }

            // --- UNIVERSAL POPUP CLOSING LOGIC ---

            // 1. Hide popup when clicking on the "X" button
            document.querySelectorAll('.close-popup-button').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation(); // Prevent click from propagating to the wrapper/document
                    // The inline onclick `document.getElementById('popup-id').classList.add('hidden')`
                    // already handles hiding the specific popup.
                    // If you wanted to use `hidePopup(id)` here, you'd need to pass the parent popup ID
                    // const parentPopupId = e.target.closest('[id^="popup-"]').id;
                    // hidePopup(parentPopupId);
                });
            });

            // 2. Hide popup when clicking outside its content area
            document.addEventListener('click', function(event) {
                for (const id in allPopupWrappers) {
                    const wrapper = allPopupWrappers[id];
                    const content = allPopupContents[id];

                    if (wrapper && !wrapper.classList.contains('hidden')) { // If wrapper is currently visible
                        if (content && !content.contains(event.target)) { // And click is outside content
                            hidePopup(id); // Hide the popup
                        }
                    }
                }
            });

            // 3. Prevent clicks *inside* popup content from closing the popup (stopPropagation)
            for (const id in allPopupContents) {
                const content = allPopupContents[id];
                if (content) {
                    content.addEventListener('click', function(e) {
                        e.stopPropagation(); // Stop click from propagating to the document
                    });
                }
            }
            
            // 4. Prevent clicks on buttons that *open* popups from propagating and immediately closing them again
            document.querySelectorAll('.popup-opener-button').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation(); // Stop click from propagating to the document
                });
            });

            // Original generic button stopPropagation (can be removed if popup-opener-button is used consistently)
            // document.querySelectorAll('button').forEach(btn => {
            //     btn.addEventListener('click', function(e) {
            //         e.stopPropagation();
            //     });
            // });
        });
    </script>

</body>

</html>