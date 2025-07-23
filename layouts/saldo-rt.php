<?php
include_once '../../services/ketua-rt-database/ketua-rt.php';

// Pastikan session sudah dimulai jika idRt diambil dari $_SESSION
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$idRt = $_SESSION['idRt'];

$total_pemasukan = getTotalPemasukan($idRt);
$total_pengeluaran = getTotalPengeluaran($idRt);
$sisa = $total_pemasukan - $total_pengeluaran;

// Determine colors for balance
$sisa_color_class = 'text-white'; // Default to white
if ($sisa < 0) {
    $sisa_color_class = 'text-red-300'; // Red for negative, a lighter red for better contrast on dark blue
}
// If $sisa is 0 or positive, it will remain 'text-white'
?>

<div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 rounded-xl shadow-lg">
    <h3 class="text-xl font-semibold mb-4">Ringkasan Kas RT</h3>

    <div class="flex justify-between items-center mb-2">
        <p class="text-md">Total Pemasukan:</p>
        <p class="text-lg font-medium">Rp. <?= number_format($total_pemasukan, 0, ',', '.') ?></p>
    </div>

    <div class="flex justify-between items-center mb-4">
        <p class="text-md">Total Pengeluaran:</p>
        <p class="text-lg font-medium">Rp. <?= number_format($total_pengeluaran, 0, ',', '.') ?></p>
    </div>

    <div class="border-t border-blue-400 pt-4 flex justify-between items-center">
        <p class="text-lg font-semibold">Sisa Saldo:</p>
        <p class="text-3xl font-extrabold <?= $sisa_color_class ?>">Rp. <?= number_format($sisa, 0, ',', '.') ?></p>
    </div>
</div>