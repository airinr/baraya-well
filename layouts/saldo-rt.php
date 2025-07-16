<?php
include_once '../../services/ketua-rt-database/ketua-rt.php';


$total_pemasukan = getTotalPemasukan();

?>

<!-- Saldo -->
<div class="bg-[#3674B5] text-white p-6 rounded-xl">
        <p class="text-lg">Total</p>
        <p class="text-3xl font-bold">Rp. <?php $total_pemasukan ?></p>
</div>