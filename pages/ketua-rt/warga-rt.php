<?php
include '../../services/ketua-rt-database/ketua-rt.php';

$idRt = $_SESSION['idRt'];

$warga = getWarga($idRt);
$idWarga = getIdWarga();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Baraya Well</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white font-sans">

    <!-- Navbar -->
    <?php include '../../layouts/navbar-warga.php' ?>

    <main class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include '../../layouts/sidebar-rt.php' ?>

        <!-- Konten Utama -->
        <section class="flex-1 p-10 space-y-6">
            <!-- Total Saldo -->
            <?php include '../../layouts/saldo-rt.php' ?>

            <!-- Tabel Warga -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-semibold text-gray-700">Data Warga</h3>
                    <button onclick="document.getElementById('popup-warga').classList.remove('hidden')" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">+ Tambah</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="p-2 border">Id Warga</th>
                                <th class="p-2 border">No Rumah</th>
                                <th class="p-2 border">Nama Kepala Keluarga</th>
                                <th class="p-2 border">Email</th>
                                <th class="p-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($warga && $warga->num_rows > 0): ?>
                                <?php while ($row = $warga->fetch_assoc()): ?>
                                    <tr>
                                        <td class="p-2 border"><?= $row['idWarga'] ?></td>
                                        <td class="p-2 border"><?= $row['noRumah'] ?></td>
                                        <td class="p-2 border"><?= htmlspecialchars($row['nama']) ?></td>
                                        <td class="p-2 border"><?= $row['email'] ?></td>
                                        <td class="p-2 border">
                                            <div class="flex justify-center items-center space-x-2">
                                                <button onclick="openEditPopup('<?= $row['idWarga'] ?>','<?= $row['noRumah'] ?>','<?= htmlspecialchars($row['nama'], ENT_QUOTES) ?>','<?= $row['email'] ?>')" class="bg-yellow-400 text-white px-2 py-1 rounded text-xs hover:bg-yellow-500">Update</button>
                                                <button onclick="openDeletePopup('<?= $row['noRumah'] ?>')" class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center p-4">Tidak ada data warga.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <!-- Popup Tambah Warga -->
    <div id="popup-warga" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div id="popup-content" class="bg-white rounded-xl shadow-lg p-8 w-[350px] border-2 border-blue-400 relative">
            <button onclick="document.getElementById('popup-warga').classList.add('hidden')" class="absolute top-2 right-3 text-gray-700 text-xl">&times;</button>
            <h2 class="text-2xl font-bold text-center mb-6 text-blue-700">Tambah Warga</h2>
            <form method="POST" action="../../services/ketua-rt-database/ketua-rt.php?aksi=tambah_warga">
                <input type="hidden" name="idRt" value="R001">

                <label class="block mb-2 font-medium text-gray-700">ID Warga</label>
                <input type="text" value="<?= $idWarga ?>" disabled class="w-full mb-4 border-b border-black bg-gray-100 cursor-not-allowed py-1">

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

    <!-- Popup Edit Warga -->
    <div id="popup-edit" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div id="popup-edit-content" class="bg-white rounded-xl shadow-lg p-8 w-[350px] border-2 border-yellow-400 relative">
            <button onclick="document.getElementById('popup-edit').classList.add('hidden')" class="absolute top-2 right-3 text-gray-700 text-xl">&times;</button>
            <h2 class="text-2xl font-bold text-center mb-6 text-yellow-600">Edit Warga</h2>
            <form method="POST" action="../../services/ketua-rt-database/ketua-rt.php?aksi=edit_warga">

                <!-- ID Warga (tidak bisa diedit) -->
                <input type="text" id="editIdWargaDisplay" disabled class="..." />
                <input type="hidden" name="idWarga" id="editIdWarga" />


                <!-- Nomor Rumah -->
                <label class="block mb-2 font-medium text-gray-700">Nomor Rumah</label>
                <input type="text" name="noRumah" id="editNoRumah" required class="w-full mb-4 border-b border-black bg-transparent py-1">

                <!-- Nama Kepala Keluarga -->
                <label class="block mb-2 font-medium text-gray-700">Nama Kepala Keluarga</label>
                <input type="text" name="nama" id="editNamaKepala" required class="w-full mb-4 border-b border-black bg-transparent py-1">

                <!-- Email -->
                <label class="block mb-2 font-medium text-gray-700">Email</label>
                <input type="text" name="email" id="editEmailWarga" required class="w-full mb-4 border-b border-black bg-transparent py-1">

                <button type="submit" class="w-full bg-yellow-500 text-white font-semibold py-2 rounded-md hover:bg-yellow-600 transition duration-200">
                    Perbarui
                </button>
            </form>
        </div>
    </div>


    <!-- Popup Hapus Warga -->
    <div id="popup-delete" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div id="popup-delete-content" class="bg-white rounded-xl shadow-lg p-8 w-[350px] border-2 border-red-400 relative">
            <button onclick="document.getElementById('popup-delete').classList.add('hidden')" class="absolute top-2 right-3 text-gray-700 text-xl">&times;</button>
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


    <!-- JS popup -->
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

        ['popup-content', 'popup-edit-content', 'popup-delete-content'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });

        document.addEventListener('click', function(event) {
            const popupIds = ['popup-content', 'popup-edit-content', 'popup-delete-content'];
            const popups = {
                'popup-content': 'popup-warga',
                'popup-edit-content': 'popup-edit',
                'popup-delete-content': 'popup-delete'
            };

            for (let id of popupIds) {
                const content = document.getElementById(id);
                const wrapper = document.getElementById(popups[id]);
                if (!wrapper.classList.contains('hidden') && !content.contains(event.target)) {
                    wrapper.classList.add('hidden');
                }
            }
        });

        document.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>

</body>

</html>