<nav class="flex items-center justify-between px-8 py-4 shadow sticky top-0 z-50 bg-white">
  <!-- Logo -->
  <div class="flex items-center space-x-2">
    <img src="/BARAYA/src/assets/images/logo-baraya-well.png" alt="Logo" class="h-8">
    <h1 class="text-xl font-semibold">
      <span class="text-blue-600">Baraya</span>
      <span class="text-yellow-500 font-medium">Well</span>
    </h1>
  </div>

  <!-- Navigation Menu -->
  <ul class="flex space-x-8">
    <li><a href="#home" class="font-semibold text-black hover:text-blue-600">Home</a></li>
    <li><a href="#about-us" class="font-semibold text-black hover:text-blue-600">About Us</a></li>
    <li><a href="#contact-us" class="font-semibold text-black hover:text-blue-600">Contact</a></li>
  </ul>

    <!-- Profile Dropdown -->
    <div class="relative">
        <button id="profile-menu-button" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <!-- <span class="font-semibold text-sm text-gray-800 hidden sm:block"><?php echo htmlspecialchars($nama_warga) . " (" . htmlspecialchars($noRumah) . ")"; ?></span> -->
            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-200">
                <i data-lucide="user-round" class="w-5 h-5 text-gray-600"></i>
            </span>
        </button>

        <!-- Dropdown Menu -->
        <div id="profile-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-30 border">
            <a href="#" class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors">
                <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>
                Logout
            </a>
        </div>
    </div>
</nav>

<script>
    // --- Profile Dropdown Logic ---
        const profileMenuButton = document.getElementById('profile-menu-button');
        const profileMenu = document.getElementById('profile-menu');

        if (profileMenuButton) {
            profileMenuButton.addEventListener('click', (event) => {
                event.stopPropagation();
                profileMenu.classList.toggle('hidden');
            });
        }

        window.addEventListener('click', (event) => {
            if (profileMenu && !profileMenu.classList.contains('hidden')) {
                if (!profileMenu.contains(event.target) && !profileMenuButton.contains(event.target)) {
                    profileMenu.classList.add('hidden');
                }
            }
        });
</script>
