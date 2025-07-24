<?php
session_start();

include "../../services/warga-database/warga.php";

// Cek apakah pengguna sudah login
if (!isset($_SESSION["nama"])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: ../../login.php");
    exit();
}

$namaWarga = isset($_SESSION["nama"]) ? $_SESSION["nama"] : "Warga";
$idWarga = isset($_SESSION["idWarga"]) ? $_SESSION["idWarga"] : "000";
$blokRumah = isset($_SESSION["noRumah"]) ? $_SESSION["noRumah"] : "000";
$idRt = isset($_SESSION["idRt"]) ? $_SESSION["idRt"] : "00";

$dataKategori = getKategori($idRt);
$tagihan = getTagihanWarga($idWarga); // Gunakan $idWarga untuk getTagihanWarga
$riwayatPembayaran = getRiwayatPembayaran($idWarga);
$rt = getRTById($idRt);

// Pastikan $tagihan tidak null sebelum mengakses elemennya
$bulan_tagihan_raw = $tagihan['bulan_tagihan'] ?? date('Y-m-01'); // Default ke awal bulan ini
$jatuh_tempo = $tagihan['jatuh_tempo'] ?? date('Y-m-15'); // Default ke tanggal 15 bulan ini
$iuran = $tagihan['total'] ?? 30000; // Default nominal jika tidak ada tagihan
$sudahBayar = $tagihan['sudah_bayar'] ?? 0; // Default sudah_bayar
$denda = $tagihan['denda'] ?? 0; // Default denda

// Proses pembayaran jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['bayar_iuran_qris'])) {
        $pembayaran = bayarIuranQris($idWarga, $iuran, $denda); // Pastikan fungsi menerima denda jika ada
        if ($pembayaran) {
            header("Location: warga.php?status=berhasil");
            exit();
        } else {
            // Handle error for QRIS payment
            header("Location: warga.php?status=gagal_qris");
            exit();
        }
    } elseif (isset($_POST['bayar_iuran_cash'])) { // Perubahan di sini: Tangani pembayaran cash
        $pembayaran = bayarIuranCash($idWarga, $iuran, $denda); // Panggil fungsi bayarIuranCash
        if ($pembayaran) {
            header("Location: warga.php?status=berhasil");
            exit();
        } else {
            // Handle error for Cash payment
            header("Location: warga.php?status=gagal_cash");
            exit();
        }
    }
}

// Mengubah format bulan tagihan ke Bahasa Indonesia
$bulanIndo = [
    'January' => 'Januari',
    'February' => 'Februari',
    'March' => 'Maret',
    'April' => 'April',
    'May' => 'Mei',
    'June' => 'Juni',
    'July' => 'Juli',
    'August' => 'Agustus',
    'September' => 'September',
    'October' => 'Oktober',
    'November' => 'November',
    'December' => 'Desember',
];

$bulan_nama = date('F', strtotime($bulan_tagihan_raw)); // e.g., "July"
$tahun = date('Y', strtotime($bulan_tagihan_raw));

$bulan_tagihan_formatted = $bulanIndo[$bulan_nama] . ' ' . $tahun;


$status = $_GET['status'] ?? null; // Digunakan untuk menampilkan modal sukses

?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Baraya Well</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>

<body class="bg-slate-50">

    <?php include '../../layouts/navbar-warga.php' ?>

    <?php
    // Data dinamis (contoh)
    $nama_warga = $namaWarga;

    // Data untuk QR Code
    // Format yang umum untuk QRIS: MerchantName.TransactionID.Amount
    // Pastikan $iuran sudah memperhitungkan denda jika itu yang ingin discan
    $qris_amount = $iuran + $denda;
    $data_barcode = "IuranWarga.ID{$idWarga}." . urlencode($qris_amount) . ".00";
    $barcode_url = "https://api.qrserver.com/v1/create-qr-code/?data=" . $data_barcode . "&size=250x250&qzone=1";
    ?>

    <main class="flex-1 p-6 md:p-8 overflow-y-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            <div class="lg:col-span-2 space-y-8">

                <div id="status-card" class="<?php echo $sudahBayar ? 'bg-green-100 border-l-4 border-green-500' : 'bg-red-100 border-l-4 border-red-500'; ?> p-6 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <i data-lucide="<?php echo $sudahBayar ? 'check-circle' : 'alert-circle'; ?>" class="w-10 h-10 <?php echo $sudahBayar ? 'text-green-500' : 'text-red-500'; ?> mr-4"></i>
                        <div>
                            <h3 class="text-xl font-bold <?php echo $sudahBayar ? 'text-green-800' : 'text-red-800'; ?>">
                                <?php echo $sudahBayar ? 'Terima kasih sudah membayar!' : 'Anda Memiliki Tagihan Iuran'; ?>
                            </h3>
                            <p class="<?php echo $sudahBayar ? 'text-green-700' : 'text-red-700'; ?>">
                                <?php echo $sudahBayar ? 'Pembayaran iuran bulan ini telah diterima.  Untuk pembayaran cash, data akan masuk setelah diterima ketua rt.' : 'Segera lakukan pembayaran sebelum jatuh tempo.'; ?>
                            </p>
                        </div>
                    </div>
                </div>


                <div class="bg-white p-6 rounded-xl shadow-md space-y-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Hallo, <?php echo $namaWarga; ?></h3>
                        <p class="text-sm text-gray-500">Tagihan untuk bulan <strong><?php echo $bulan_tagihan_formatted; ?></strong></p>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <p class="text-gray-500">Jumlah Tagihan</p>
                            <p class="text-4xl font-extrabold <?php echo $sudahBayar ? 'text-gray-400' : 'text-blue-600'; ?> leading-tight">
                                Rp <?php echo number_format($iuran, 0, ',', '.'); ?>
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Jatuh tempo: <?php echo date('d F Y', strtotime($jatuh_tempo)); ?>
                            </p>

                            <?php if ($denda > 0): ?>
                                <p class="text-sm text-red-600 mt-1">
                                    * Denda Rp <?php echo number_format($denda, 0, ',', '.'); ?> karena melewati tanggal 15
                                </p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <?php if (!$sudahBayar): ?>
                                <button id="pay-now-button"
                                    class="w-full sm:w-auto bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-all flex items-center justify-center gap-2">
                                    <i data-lucide="wallet" class="w-5 h-5"></i>
                                    <span>Bayar Sekarang</span>
                                </button>
                            <?php else: ?>
                                <button disabled
                                    class="w-full sm:w-auto bg-green-500 text-white font-bold py-3 px-6 rounded-lg flex items-center justify-center gap-2">
                                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                                    <span>Sudah Bayar</span>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Pembayaran Terakhir</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b-2">
                                    <th class="p-3 text-sm font-semibold text-gray-500">Tanggal Bayar</th>
                                    <th class="p-3 text-sm font-semibold text-gray-500">Denda</th>
                                    <th class="p-3 text-sm font-semibold text-gray-500">Jumlah</th>
                                    <th class="p-3 text-sm font-semibold text-gray-500">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($riwayatPembayaran)) : ?>
                                    <?php foreach ($riwayatPembayaran as $index => $row) : ?>
                                        <tr class="<?= $index % 2 === 1 ? 'bg-slate-50' : ''; ?> border-b border-gray-100">
                                            <td class="p-3 text-gray-600"><?= date('d F Y', strtotime($row['tglPembayaran'])) ?></td>
                                            <td class="p-3 text-gray-600">Rp <?= number_format($row['denda'], 0, ',', '.') ?></td>
                                            <td class="p-3 text-gray-600">Rp <?= number_format($row['totalBayar'], 0, ',', '.') ?></td>
                                            <?php
                                            $keterangan = $row['keterangan'];
                                            $bgClass = $keterangan == 'lunas' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800';
                                            ?>

                                            <td class="p-3">
                                                <span class="<?= $bgClass ?> text-xs font-semibold px-2 py-1 rounded-full">
                                                    <?= htmlspecialchars($keterangan) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="p-3 text-center text-gray-500">Belum ada riwayat pembayaran</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Info Penggunaan Iuran</h3>
                    <ul class="space-y-3 text-gray-600">
                        <?php foreach ($dataKategori as $kategori): ?>
                            <li class="flex items-center">
                                <i data-lucide="<?= htmlspecialchars($kategori['ikon'] ?? 'info'); ?>" class="w-5 h-5 text-blue-500 mr-3"></i>
                                <span><?= htmlspecialchars($kategori['kategori']); ?> (<?php echo $kategori["persentase"] ?>%)</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <img src="https://placehold.co/80x80/c084fc/FFFFFF?text=A" alt="Foto Bendahara" class="w-20 h-20 rounded-full mx-auto mb-4 border-4 border-white shadow-md">
                    <h3 class="font-bold text-gray-800"><?php echo $rt['nama'] ?></h3>
                    <p class="text-sm text-gray-500 mb-4">Ketua RT <?php echo $rt['idRt'] ?></p>
                    </a>
                </div>
            </div>
        </div>
    </main>


    <div id="payment-modal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-2xl transform transition-all">
            <div class="flex justify-between items-center pb-4 border-b">
                <h3 class="text-xl font-bold text-gray-800">Pilih Metode Pembayaran</h3>
                <button id="close-payment-modal-button" class="p-1 rounded-full hover:bg-gray-200">
                    <i data-lucide="x" class="w-6 h-6 text-gray-600"></i>
                </button>
            </div>
            <div class="py-6">
                <div class="space-y-4">
                    <a href="#" id="qris-payment-button" class="flex items-center p-4 border rounded-lg hover:bg-slate-50 hover:border-blue-500 transition-all">
                        <div class="bg-sky-100 p-3 rounded-lg mr-4"><i data-lucide="qr-code" class="w-6 h-6 text-sky-600"></i></div>
                        <div>
                            <p class="font-semibold text-gray-800">QRIS</p>
                            <p class="text-sm text-gray-500">Scan kode QR</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto"></i>
                    </a>
                    <form method="POST" class="w-full">
                        <input type="hidden" name="bayar_iuran_cash" value="1">
                        <button type="submit" class="flex items-center p-4 border rounded-lg w-full text-left hover:bg-slate-50 hover:border-blue-500 transition-all">
                            <div class="bg-violet-100 p-3 rounded-lg mr-4"><i data-lucide="hand-coins" class="w-6 h-6 text-violet-600"></i></div>
                            <div>
                                <p class="font-semibold text-gray-800">Cash</p>
                                <p class="text-sm text-gray-500">Pembayaran langsung ke Ketua RT</p>
                            </div>
                            <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="barcode-modal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-sm p-8 rounded-xl shadow-2xl text-center">
            <h3 class="text-2xl font-bold text-gray-800">Pembayaran QRIS</h3>
            <p class="text-gray-500 mt-2 mb-4">Scan QR Code di bawah ini untuk membayar.</p>
            <img src="<?php echo $barcode_url; ?>" alt="Barcode Pembayaran" class="mx-auto rounded-lg">
            <div class="mt-4 text-left bg-slate-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Nama: <span class="font-semibold"><?php echo $nama_warga; ?></span></p>
                <p class="text-sm text-gray-600">Tagihan: <span class="font-semibold">Iuran <?php echo $bulan_tagihan_formatted; ?></span></p>
                <p class="text-lg text-gray-800 mt-2">Total: <span class="font-bold text-blue-600">Rp <?php echo number_format($iuran + $denda, 0, ',', '.'); ?></span></p>
            </div>
            <form method="POST">
                <input type="hidden" name="bayar_iuran_qris" value="1"> <button type="submit" class="mt-6 w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700">
                    Konfirmasi Pembayaran QRIS
                </button>
            </form>
        </div>
    </div>

    <div id="success-modal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-sm p-8 rounded-xl shadow-2xl text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full mx-auto flex items-center justify-center mb-6">
                <i data-lucide="check" class="w-12 h-12 text-green-600"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">Pembayaran Berhasil!</h3>
            <p class="text-gray-500 mt-2 mb-6">Terima kasih telah melakukan pembayaran iuran bulan ini.</p>
            <button id="close-success-modal" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700">
                Kembali ke Dasbor
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();

            const payNowButton = document.getElementById('pay-now-button');
            const paymentModal = document.getElementById('payment-modal');
            const closePaymentModalButton = document.getElementById('close-payment-modal-button');
            // const paymentMethods = document.querySelectorAll('.payment-method'); // Ini tidak lagi digunakan untuk cash
            const qrisPaymentButton = document.getElementById('qris-payment-button');

            const barcodeModal = document.getElementById('barcode-modal');
            const successModal = document.getElementById('success-modal');
            const closeSuccessModalButton = document.getElementById('close-success-modal');
            const statusCard = document.getElementById('status-card');

            const openPaymentModal = () => paymentModal.classList.remove('hidden');
            const closePaymentModal = () => paymentModal.classList.add('hidden');

            const openBarcodeModal = () => barcodeModal.classList.remove('hidden');
            const closeBarcodeModal = () => barcodeModal.classList.add('hidden');

            const closeSuccessModal = () => {
                successModal.classList.add('hidden');
                // Hapus ?status=berhasil dari URL dan refresh halaman untuk memuat ulang data dari database
                const url = new URL(window.location);
                url.searchParams.delete('status');
                window.history.replaceState({}, document.title, url);
                window.location.reload(); // Refresh halaman untuk menampilkan status terbaru dari database
            };

            // Event listeners
            payNowButton?.addEventListener('click', openPaymentModal);
            closePaymentModalButton?.addEventListener('click', closePaymentModal);
            paymentModal?.addEventListener('click', (e) => e.target === paymentModal && closePaymentModal());

            qrisPaymentButton?.addEventListener('click', (e) => {
                e.preventDefault(); // Mencegah navigasi default link
                closePaymentModal();
                openBarcodeModal();
            });

            barcodeModal?.addEventListener('click', (e) => e.target === barcodeModal && closeBarcodeModal());


            closeSuccessModalButton?.addEventListener('click', closeSuccessModal);
            successModal?.addEventListener('click', (e) => {
                if (!e.target.closest('.bg-white')) {
                    closeSuccessModal();
                }
            });

            // Jika halaman dibuka dengan ?status=berhasil, tampilkan modal sukses
            const params = new URLSearchParams(window.location.search);
            if (params.get('status') === 'berhasil') {
                openSuccessModal();
            }
        });
    </script>

</body>

</html>