<!-- Sidebar -->
<aside class="w-64 bg-[#3674B5] text-white p-6 space-y-4" id="sidebar">
  <a href="beranda-rt.php" class="menu-link hover:underline py-2 px-4 rounded-md block">Beranda</a>
  <a href="pengeluaran-rt.php" class="menu-link hover:underline py-2 px-4 rounded-md block">Riwayat Pembayaran</a>
  <a href="pemasukan-rt.php" class="menu-link hover:underline py-2 px-4 rounded-md block">Pengumuman</a>
</aside>     

<script>
  const links = document.querySelectorAll(".menu-link");
  const currentPath = window.location.pathname;

  links.forEach(link => {
    if (link.getAttribute("href") && currentPath.includes(link.getAttribute("href").split('/').pop())) {
      link.classList.add("bg-yellow-100", "text-black", "font-medium");
    } else {
      link.classList.add("text-white");
    }
  });
</script>
