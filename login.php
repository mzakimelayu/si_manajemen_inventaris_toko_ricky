<?php
  // cek apakah ada session yang aktif
  session_start();
  if (isset($_SESSION['dataPengguna'])) {
      // Jika ada, redirect ke halaman dashboard
      header("Location: dashboard.php");
      exit();
  }

  // Panggil file koneksi.php untuk membuat koneksi ke database
  include 'koneksi/db.php';

// Logika login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form login
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; // Ambil password tanpa hash
    
    // Query untuk mencari user dengan username
    $query = "SELECT * FROM pengguna WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);
    
    // Cek apakah user ditemukan
    if (mysqli_num_rows($result) == 1) {
        // Ambil data pengguna
        $data = mysqli_fetch_assoc($result);
          
        // Verifikasi password dengan password_verify
        if (password_verify($password, $data['password'])) {
            // Simpan data pengguna ke dalam session
            $_SESSION['dataPengguna'] = $data;
            
            // Redirect ke halaman dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Jika password tidak cocok
            $_SESSION['pesan_login'] = "Username atau password salah!";
            header("Location: login.php");
            exit();
        }
    } else {
        // Jika username tidak ditemukan
        $_SESSION['pesan_login'] = "Username atau password salah!";
        header("Location: login.php");
        exit();
    }
}

?>


<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="src/output.css" rel="stylesheet">
  <title>Login | Sistem Informasi Manajemeen STOK Barang</title>
</head>
<body class="bg-gradient-to-r from-pink-200 via-fuchsia-300 to-rose-300 min-h-screen flex items-center justify-center p-4">
  <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg p-8 sm:p-12 transform hover:-translate-y-1 transition-all duration-300">
    <div class="text-center mb-12">
      <h1 class="text-3xl sm:text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-pink-600 to-rose-500 mb-4">
        MANAJEMEN INVENTARIS
      </h1>
      <p class="text-gray-600 text-lg">Selamat datang di sistem manajemen</p>
    </div>

    <!-- Pesan Error Saat Login Gagal -->
    <?php
        if(isset($_SESSION['pesan_login'])) { ?>
          <div id="alert-message" class="mb-4 bg-gradient-to-br from-red-50 via-red-100 to-orange-50 p-4 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex justify-between items-center animate-pulse" role="alert">
            <div class="flex items-center space-x-3">
              <div class="flex-shrink-0 bg-gradient-to-br from-red-400 to-pink-500 p-2 rounded-full">
                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <div>
                <h3 class="font-semibold text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-pink-600 text-base mb-0.5">Login Gagal</h3>
                <p class="text-red-600 text-sm"><?php echo $_SESSION['pesan_login']; ?></p>
              </div>
            </div>
            <button onclick="closeAlert()" class="p-1.5 bg-gradient-to-r from-red-100 to-pink-100 rounded-full hover:from-red-200 hover:to-pink-200 transition-colors duration-200">
              <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
          <script>
            setTimeout(function() {
              const alert = document.getElementById('alert-message');
              alert.classList.add('scale-95', 'opacity-0');
              setTimeout(() => alert.style.display = 'none', 300);
            }, 4000);
            
            function closeAlert() {
              const alert = document.getElementById('alert-message');
              alert.classList.add('scale-95', 'opacity-0');
              setTimeout(() => alert.style.display = 'none', 300);
            }
          </script>
    <?php 
      unset($_SESSION['pesan_login']);
    } 
    ?>

    <!-- Pesan Berhasil Saat Berhasil Logout -->
    <?php
        if(isset($_SESSION['pesan_logout'])) { ?>
          <div id="alert-message" class="mb-4 bg-gradient-to-br from-green-50 via-emerald-100 to-teal-50 p-4 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex justify-between items-center animate-pulse" role="alert">
            <div class="flex items-center space-x-3">
              <div class="flex-shrink-0 bg-gradient-to-br from-green-400 to-emerald-500 p-2 rounded-full">
                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <div>
                <h3 class="font-semibold text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-600 text-base mb-0.5">Logout Berhasil</h3>
                <p class="text-green-600 text-sm"><?php echo $_SESSION['pesan_logout']; ?></p>
              </div>
            </div>
            <button onclick="closeAlert()" class="p-1.5 bg-gradient-to-r from-green-100 to-emerald-100 rounded-full hover:from-green-200 hover:to-emerald-200 transition-colors duration-200">
              <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
          <script>
            setTimeout(function() {
              const alert = document.getElementById('alert-message');
              alert.classList.add('scale-95', 'opacity-0');
              setTimeout(() => alert.style.display = 'none', 300);
            }, 4000);
            
            function closeAlert() {
              const alert = document.getElementById('alert-message');
              alert.classList.add('scale-95', 'opacity-0');
              setTimeout(() => alert.style.display = 'none', 300);
            }
          </script>
    <?php 
      unset($_SESSION['pesan_logout']);
    } 
    ?>

    <form action="" method="POST" class="space-y-6">
      <div class="space-y-2">
        <label for="username" class="text-sm font-medium text-gray-700 block">Username</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-pink-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
          </span>
          <input type="text" id="username" name="username" 
                 class="w-full pl-12 pr-4 py-3 rounded-xl border border-pink-200 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 focus:outline-none bg-gray-100 transition duration-200"
                 placeholder="Masukkan username anda"
                 required>
        </div>
      </div>
      
      <div class="space-y-2">
        <label for="password" class="text-sm font-medium text-gray-700 block">Password</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-pink-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
          </span>
          <input type="password" id="password" name="password" 
                 class="w-full pl-12 pr-12 py-3 rounded-xl border border-pink-200 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 focus:outline-none bg-gray-100 transition duration-200"
                 placeholder="Masukkan password anda"
                 required>
          <button type="button" onclick="togglePassword()" 
                  class="absolute inset-y-0 right-0 pr-4 flex items-center text-pink-400 hover:text-pink-600 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" id="eyeIcon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>        </div>
      </div>

      <div class="pt-4">
        <button type="submit" 
                class="w-full bg-gradient-to-r from-pink-600 to-rose-500 text-white py-4 rounded-xl font-semibold text-lg shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-600 transform hover:-translate-y-0.5 transition-all duration-200">
          Masuk ke Sistem
        </button>
      </div>
    </form>

    <div class="mt-8 text-center text-sm text-gray-500">
      <p>Sistem Informasi Manajemen Inventaris</p>
    </div>
  </div>
</body>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        `;
      } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
      }
    }
  </script>
</body>
</html>