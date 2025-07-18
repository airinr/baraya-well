  <?php
  session_start();
  include_once 'services/ketua-rt-database/ketua-rt.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if ($role === 'ketua') {
      loginRt($username, $password);
    } else {
      loginWarga($username,$password);
    }
  }
  ?>


  <!DOCTYPE html>
  <html lang="id">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>

  <body class="bg-[#3973B4] h-screen flex items-center justify-center font-sans">

    <div class="bg-[#F3EEC0] rounded-xl p-10 w-[350px] md:w-[400px]">
      <h1 class="text-center text-2xl font-bold mb-8">LOGIN</h1>

      <form method="POST" action="" class="space-y-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
          <input name="username" type="text" required class="w-full border-b border-gray-700 bg-transparent py-1" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input name="password" type="password" required class="w-full border-b border-gray-700 bg-transparent py-1" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Daftar Sebagai?</label>
          <select name="role" required class="w-full border-b border-gray-700 bg-transparent py-1">
            <option value="" disabled selected>Pilih peran Anda</option>
            <option value="warga">Warga</option>
            <option value="ketua">Ketua RT</option>
          </select>
        </div>

        <button type="submit" name="login" class="w-full bg-[#3973B4] text-white py-2 rounded-md hover:bg-blue-700 transition">
          Login
        </button>
      </form>



      <!-- Link ke Daftar -->
      <p class="text-center text-sm text-gray-700">
        Belum punya akun?
        <a href="register.php" class="text-blue-600 hover:underline">Daftar disini</a>
      </p>
    </div>

  </body>

  </html>