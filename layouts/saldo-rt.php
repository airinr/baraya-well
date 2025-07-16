<?php
include_once '../../services/ketua-rt-database/ketua-rt.php';


$total_pemasukan = getTotalPemasukan();
$total_pengeluaran = getTotalPengeluaran();
$sisa = $total_pemasukan - $total_pengeluaran;

?>

<!-- Saldo -->
<div class="bg-[#3674B5] text-white p-6 rounded-xl">
        <p class="text-lg">Total</p>
        <p class="text-3xl font-bold">Rp. <?= number_format($sisa, 0, ',', '.') ?></p>

</div>