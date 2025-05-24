<?php
    $judul_halaman = "Edit Profil Pengguna";
    
    include '../cek_login.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_pengguna = $_POST['id_pengguna'];
        $nama_lengkap = $_POST['nama_lengkap'];
        $username = $_POST['username'];
        $password_lama = $_POST['password_lama'];
        $password_baru = $_POST['password_baru'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $nomor_hp = $_POST['nomor_hp'];
        $alamat = $_POST['alamat'];

        // cek username sudah ada atau belum
        $query_cek_username = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username='$username' AND id_pengguna != '$id_pengguna'");
        if(mysqli_num_rows($query_cek_username) > 0) {
            $_SESSION['pesan_gagal'] = "Username sudah ada!";
            header("Location: " . base_url('modul/pengaturan.php'));
            exit();
        }
        

        // Cek password lama
        $query_cek = mysqli_query($koneksi, "SELECT password FROM pengguna WHERE id_pengguna='$id_pengguna'");
        $data_cek = mysqli_fetch_array($query_cek);
        
        if($password_lama != "" || $password_baru != "") {
            if(!password_verify($password_lama, $data_cek['password'])) {
                $_SESSION['pesan_gagal'] = "Password lama tidak sesuai!";
                header("Location: " . base_url('modul/pengaturan.php'));                
                exit();
            }
            if($password_lama != "" && $password_baru == "") {
                $_SESSION['pesan_gagal'] = "Password baru tidak boleh kosong!";
                header("Location: " . base_url('modul/pengaturan.php'));
                exit();
            }
            $password = password_hash($password_baru, PASSWORD_DEFAULT);
            $update_password = ", password='$password'";
        } else {
            $update_password = "";
        }

        $query = mysqli_query($koneksi, "UPDATE pengguna SET 
            nama_lengkap='$nama_lengkap',
            username='$username',
            jenis_kelamin='$jenis_kelamin',
            nomor_hp='$nomor_hp',
            alamat='$alamat'
            $update_password
            WHERE id_pengguna='$id_pengguna'");

        if($query) {
            $_SESSION['pesan_sukses'] = "Profil berhasil diupdate!";
            header("Location: " . base_url('modul/pengaturan.php'));
            exit();
        } else {
            $_SESSION['pesan_gagal'] = "Profil gagal diupdate!";
            header("Location: " . base_url('modul/pengaturan.php'));
            exit();
        }
    }?>

<?php include '../layout/header.php'; ?>

<?php include '../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-2 sm:p-4 lg:p-6 animate-slide-in-up">
        <div class="max-w-4xl mx-auto bg-gradient-to-br from-pink-100 to-pink-200 rounded-lg shadow-2xl p-4 sm:p-6 animate-scale-in backdrop-blur-sm">
            <h2 class="text-xl sm:text-2xl font-bold mb-6 text-indigo-600 border-b-2 border-pink-300 pb-2 flex items-center animate-slide-in-left">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Edit Profil Saya
            </h2>
            <?php
                $query = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE id_pengguna='$sesi_id_pengguna'");
                $data = mysqli_fetch_array($query);
            ?>

            <!-- Pesan Error Saat Gagal Update Profil-->
            <?php
                if(isset($_SESSION['pesan_gagal'])) { ?>
                <div id="alert-message" class="mb-4 bg-gradient-to-br from-red-50 via-red-100 to-orange-50 p-4 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex justify-between items-center animate-slide-in-down" role="alert">
                    <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 bg-gradient-to-br from-red-400 to-pink-500 p-2 rounded-full">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-pink-600 text-base mb-0.5">Pesan Gagal</h3>
                        <p class="text-red-600 text-sm"><?php echo $_SESSION['pesan_gagal']; ?></p>
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
            unset($_SESSION['pesan_gagal']);
            } 
            ?>

            <!-- Pesan Berhasil Saat Berhasil Update Profil -->
            <?php
                if(isset($_SESSION['pesan_sukses'])) { ?>
                <div id="alert-message" class="mb-4 bg-gradient-to-br from-green-50 via-emerald-100 to-teal-50 p-4 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex justify-between items-center animate-slide-in-down" role="alert">
                    <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 bg-gradient-to-br from-green-400 to-emerald-500 p-2 rounded-full">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-600 text-base mb-0.5">Pesan Berhasil</h3>
                        <p class="text-green-600 text-sm"><?php echo $_SESSION['pesan_sukses']; ?></p>
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
            unset($_SESSION['pesan_sukses']);
            } 
            ?>

            <form method="POST" action="" class="animate-slide-in-right">
                <input type="hidden" name="id_pengguna" value="<?php echo $data['id_pengguna']; ?>">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
                    <div class="space-y-4 sm:space-y-6">
                        <div class="transform transition-all duration-300 hover:scale-102">
                            <label class="block text-indigo-600 font-semibold mb-2 text-sm sm:text-base">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="<?php echo $data['nama_lengkap']; ?>" class="w-full px-4 py-2 bg-pink-50 border-2 border-rose-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-200" required>
                        </div>
                        <div class="transform transition-all duration-300 hover:scale-102">
                            <label class="block text-indigo-600 font-semibold mb-2 text-sm sm:text-base">Username</label>
                            <input type="text" name="username" value="<?php echo $data['username']; ?>" class="w-full px-4 py-2 bg-pink-50 border-2 border-rose-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-200" required>
                        </div>
                        <div class="transform transition-all duration-300 hover:scale-102">
                            <label class="block text-indigo-600 font-semibold mb-2 text-sm sm:text-base">Password Lama</label>
                            <div class="relative">
                                <input type="password" id="password_lama" name="password_lama" class="w-full px-4 py-2 bg-pink-50 border-2 border-rose-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-200">
                                <button type="button" onclick="togglePasswordLama()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-rose-600 hover:text-pink-700 transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" id="eyeIconLama" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <small class="text-indigo-600 text-xs sm:text-sm">Kosongkan jika tidak ingin mengubah password</small>
                        </div>
                        <div class="transform transition-all duration-300 hover:scale-102">
                            <label class="block text-indigo-600 font-semibold mb-2 text-sm sm:text-base">Password Baru</label>
                            <div class="relative">
                                <input type="password" id="password_baru" name="password_baru" class="w-full px-4 py-2 bg-pink-50 border-2 border-rose-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-200">
                                <button type="button" onclick="togglePasswordBaru()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-rose-600 hover:text-pink-700 transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" id="eyeIconBaru" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <small class="text-indigo-600 text-xs sm:text-sm">Kosongkan jika tidak ingin mengubah password</small>
                        </div>
                        <div class="transform transition-all duration-300 hover:scale-102">
                            <label class="block text-indigo-600 font-semibold mb-2 text-sm sm:text-base">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full px-4 py-2 bg-pink-50 border-2 border-rose-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-200" required>
                                <option value="Laki-Laki" <?php echo $data['jenis_kelamin'] == 'Laki-Laki' ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="Perempuan" <?php echo $data['jenis_kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-4 sm:space-y-6">
                        <div class="transform transition-all duration-300 hover:scale-102">
                            <label class="block text-indigo-600 font-semibold mb-2 text-sm sm:text-base">No. Telepon</label>
                            <input type="text" name="nomor_hp" value="<?php echo $data['nomor_hp']; ?>" class="w-full px-4 py-2 bg-pink-50 border-2 border-rose-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-200" required>
                        </div>
                        <div class="transform transition-all duration-300 hover:scale-102">
                            <label class="block text-indigo-600 font-semibold mb-2 text-sm sm:text-base">Alamat</label>
                            <textarea name="alamat" class="w-full px-4 py-2 bg-pink-50 border-2 border-rose-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-200" rows="4" required><?php echo $data['alamat']; ?></textarea>
                        </div>
                        <div class="mt-4 p-4 bg-indigo-50 rounded-lg border-l-4 border-indigo-500 animate-slide-in-down">
                            <p class="text-indigo-600 text-sm sm:text-base">Perhatian: Jika Anda mengubah password, pastikan untuk mengingatnya karena Anda akan membutuhkannya untuk login kembali.</p>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-8 space-x-4">
                    <a href="javascript:history.back()" class="bg-gradient-to-br from-rose-300 to-rose-500 hover:bg-gradient-to-bl text-white px-4 py-2 rounded-lg transition duration-300 transform hover:scale-105">
                        Kembali
                    </a>
                    <button onclick="return confirm('Apakah Anda yakin ingin menyimpan perubahan?')" type="submit" class="bg-gradient-to-br from-pink-400 to-pink-600 hover:bg-gradient-to-bl text-white px-4 py-2 rounded-lg transition duration-300 transform hover:scale-105">
                        Simpan Perubahan
                    </button>
                </div>            
            </form>
        </div>
    </main>

    
    <script>
    function togglePasswordLama() {
      const passwordInput = document.getElementById('password_lama');
      const eyeIcon = document.getElementById('eyeIconLama');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
        `;
      } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
      }
    }

    function togglePasswordBaru() {
      const passwordInput = document.getElementById('password_baru');
      const eyeIcon = document.getElementById('eyeIconBaru');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
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
<?php include ('../layout/footer.php'); ?>
