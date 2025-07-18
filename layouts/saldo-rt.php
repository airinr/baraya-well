<?php
include_once '../../services/ketua-rt-database/ketua-rt.php';

$idRt = $_SESSION['idRt'];

$total_pemasukan = getTotalPemasukan($idRt);
$total_pengeluaran = getTotalPengeluaran($idRt);
$sisa = $total_pemasukan - $total_pengeluaran;

?>

<!-- Saldo -->
<div class="bg-[#3674B5] text-white p-6 rounded-xl">
        <p class="text-lg">Total</p>
        <p class="text-3xl font-bold">Rp. <?= number_format($sisa, 0, ',', '.') ?></p>

</div>