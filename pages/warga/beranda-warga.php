<?php 
    session_start();

$namaWarga = isset($_SESSION["nama"]) ? $_SESSION["nama"] : "Warga";



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

  <!-- Navbar -->
  <?php include '../../layouts/navbar-warga.php' ?>

    <?php
        // Data dinamis (contoh)
        $nama_warga = $namaWarga;
        $blok_rumah = "A-12";
        $iuran = 75000;
        $bulan_tagihan = "Juli 2025";

        // Data untuk QR Code
        // Format yang umum untuk QRIS: MerchantName.TransactionID.Amount
        $data_barcode = "IuranWarga.ID12345.$iuran.00"; 
        $barcode_url = "https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode($data_barcode) . "&size=250x250&qzone=1";
    ?>

    <!-- Area Konten -->
    <main class="flex-1 p-6 md:p-8 overflow-y-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Kolom Kiri: Status & Riwayat -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Kartu Status Pembayaran -->
                <div class="bg-red-100 border-l-4 border-red-500 p-6 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <i data-lucide="alert-circle" class="w-10 h-10 text-red-500 mr-4"></i>
                        <div>
                            <h3 class="text-xl font-bold text-red-800">Anda Memiliki Tagihan Iuran</h3>
                            <p class="text-red-700">Segera lakukan pembayaran sebelum jatuh tempo.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Kartu Tagihan -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Tagihan Bulan Ini: <?php echo $bulan_tagihan; ?></h3>
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div>
                            <p class="text-gray-500">Jumlah Tagihan</p>
                            <p class="text-4xl font-bold text-blue-600">Rp <?php echo number_format($iuran, 0, ',', '.'); ?></p>
                            <p class="text-sm text-gray-500 mt-1">Jatuh tempo: 31 Juli 2025</p>
                        </div>
                        <button id="pay-now-button" class="mt-4 sm:mt-0 w-full sm:w-auto bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center space-x-2">
                            <i data-lucide="wallet" class="w-5 h-5"></i>
                            <span>Bayar Sekarang</span>
                        </button>
                    </div>
                </div>

                <!-- Riwayat Pembayaran -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Pembayaran Terakhir</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b-2">
                                    <th class="p-3 text-sm font-semibold text-gray-500">Bulan</th>
                                    <th class="p-3 text-sm font-semibold text-gray-500">Tanggal Bayar</th>
                                    <th class="p-3 text-sm font-semibold text-gray-500">Jumlah</th>
                                    <th class="p-3 text-sm font-semibold text-gray-500">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100">
                                    <td class="p-3 font-medium">Juni 2025</td>
                                    <td class="p-3 text-gray-600">10 Juni 2025</td>
                                    <td class="p-3 text-gray-600">Rp 75.000</td>
                                    <td class="p-3"><span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">Lunas</span></td>
                                </tr>
                                <tr class="bg-slate-50 border-b border-gray-100">
                                    <td class="p-3 font-medium">Mei 2025</td>
                                    <td class="p-3 text-gray-600">05 Mei 2025</td>
                                    <td class="p-3 text-gray-600">Rp 75.000</td>
                                    <td class="p-3"><span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">Lunas</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Info & Kontak -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Info Penggunaan Iuran</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center"><i data-lucide="shield-check" class="w-5 h-5 text-blue-500 mr-3"></i><span>Keamanan Lingkungan</span></li>
                        <li class="flex items-center"><i data-lucide="trash-2" class="w-5 h-5 text-green-500 mr-3"></i><span>Pengelolaan Sampah</span></li>
                        <li class="flex items-center"><i data-lucide="lightbulb" class="w-5 h-5 text-yellow-500 mr-3"></i><span>Penerangan Jalan</span></li>
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <img src="https://placehold.co/80x80/c084fc/FFFFFF?text=A" alt="Foto Bendahara" class="w-20 h-20 rounded-full mx-auto mb-4 border-4 border-white shadow-md">
                    <h3 class="font-bold text-gray-800">Ahmad Subagja</h3>
                    <p class="text-sm text-gray-500 mb-4">Ketua RT 05</p>
                    <a href="#" class="w-full bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 transition-colors flex items-center justify-center space-x-2">
                        <i data-lucide="message-circle" class="w-5 h-5"></i>
                        <span>Hubungi</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
        

    <!-- Payment Modal -->
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
                        <div><p class="font-semibold text-gray-800">QRIS</p><p class="text-sm text-gray-500">Scan kode QR</p></div>
                        <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto"></i>
                    </a>
                    <a href="#" class="payment-method flex items-center p-4 border rounded-lg hover:bg-slate-50 hover:border-blue-500 transition-all">
                        <div class="bg-violet-100 p-3 rounded-lg mr-4"><i data-lucide="hand-coins" class="w-6 h-6 text-violet-600"></i></div>
                        <div><p class="font-semibold text-gray-800">Cash</p><p class="text-sm text-gray-500">Melakukan Pembayaran</p></div>
                        <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 ml-auto"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- QRIS/Barcode Modal -->
    <div id="barcode-modal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-sm p-8 rounded-xl shadow-2xl text-center">
            <h3 class="text-2xl font-bold text-gray-800">Pembayaran QRIS</h3>
            <p class="text-gray-500 mt-2 mb-4">Scan QR Code di bawah ini untuk membayar.</p>
            <img src="<?php echo $barcode_url; ?>" alt="Barcode Pembayaran" class="mx-auto rounded-lg">
            <div class="mt-4 text-left bg-slate-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Nama: <span class="font-semibold"><?php echo $nama_warga; ?></span></p>
                <p class="text-sm text-gray-600">Tagihan: <span class="font-semibold">Iuran <?php echo $bulan_tagihan; ?></span></p>
                <p class="text-lg text-gray-800 mt-2">Total: <span class="font-bold text-blue-600">Rp <?php echo number_format($iuran, 0, ',', '.'); ?></span></p>
            </div>
            <button id="close-barcode-modal-button" class="mt-6 w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700">
                Tutup & Konfirmasi Pembayaran
            </button>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-sm p-8 rounded-xl shadow-2xl text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full mx-auto flex items-center justify-center mb-6">
                <i data-lucide="check" class="w-12 h-12 text-green-600"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">Pembayaran Berhasil!</h3>
            <p class="text-gray-500 mt-2 mb-6">Terima kasih telah melakukan pembayaran iuran bulan ini.</p>
            <button id="close-success-modal-button" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700">
                Kembali ke Dasbor
            </button>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // --- Get Elements ---
        const payNowButton = document.getElementById('pay-now-button');
        const paymentModal = document.getElementById('payment-modal');
        const closePaymentModalButton = document.getElementById('close-payment-modal-button');
        const paymentMethods = document.querySelectorAll('.payment-method');
        const qrisPaymentButton = document.getElementById('qris-payment-button');
        
        const barcodeModal = document.getElementById('barcode-modal');
        const closeBarcodeModalButton = document.getElementById('close-barcode-modal-button');

        const successModal = document.getElementById('success-modal');
        const closeSuccessModalButton = document.getElementById('close-success-modal-button');
        const statusCard = document.getElementById('status-card');

        // --- Modal Functions ---
        const openPaymentModal = () => paymentModal.classList.remove('hidden');
        const closePaymentModal = () => paymentModal.classList.add('hidden');
        
        const openBarcodeModal = () => barcodeModal.classList.remove('hidden');
        const closeBarcodeModal = () => barcodeModal.classList.add('hidden');

        const openSuccessModal = () => successModal.classList.remove('hidden');
        const closeSuccessModal = () => {
            successModal.classList.add('hidden');
            // Update status card to "Lunas"
            statusCard.innerHTML = `
                <div class="flex items-center">
                    <i data-lucide="check-circle-2" class="w-10 h-10 text-green-500 mr-4"></i>
                    <div>
                        <h3 class="text-xl font-bold text-green-800">Iuran Bulan Ini Lunas</h3>
                        <p class="text-green-700">Terima kasih atas pembayaran Anda tepat waktu.</p>
                    </div>
                </div>
            `;
            statusCard.className = 'bg-green-100 border-l-4 border-green-500 p-6 rounded-lg shadow-md';
            lucide.createIcons();
        };

        // --- Event Listeners ---

        // Open Payment Selection Modal
        payNowButton.addEventListener('click', openPaymentModal);
        closePaymentModalButton.addEventListener('click', closePaymentModal);
        paymentModal.addEventListener('click', (e) => e.target === paymentModal && closePaymentModal());

        // Open Barcode Modal
        qrisPaymentButton.addEventListener('click', (e) => {
            e.preventDefault();
            closePaymentModal();
            openBarcodeModal();
        });
        closeBarcodeModalButton.addEventListener('click', () => {
            closeBarcodeModal();
            // Simulate processing and show success
            setTimeout(openSuccessModal, 500);
        });
        barcodeModal.addEventListener('click', (e) => e.target === barcodeModal && closeBarcodeModal());

        // Handle other payment methods (show success directly)
        paymentMethods.forEach(method => {
            method.addEventListener('click', (e) => {
                e.preventDefault();
                closePaymentModal();
                setTimeout(openSuccessModal, 500);
            });
        });

        // Close Success Modal
        closeSuccessModalButton.addEventListener('click', closeSuccessModal);
        successModal.addEventListener('click', (e) => e.target === successModal && closeSuccessModal());

    </script>
</body>
</html>
