<?php
    $judul_halaman = "Edit Pengguna";
    
    include '../../cek_login.php';

    // Ambil data pengguna berdasarkan ID
    $id_pengguna = $_GET['id'];
    $query = "SELECT * FROM pengguna WHERE id_pengguna = '$id_pengguna'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) == 0) {
        echo "<script>window.location.href='" . base_url('404.php') . "';</script>";                    
        exit;
    }
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-2 sm:p-4 lg:p-6 animate-slide-in-down">
        <div class="bg-gray-100 rounded-lg shadow-md p-6 animate-slide-in-up">
            <h2 class="text-2xl font-semibold mb-6 text-pink-600 animate-bounce-in">Edit Pengguna</h2>

            <!-- Pesan Error Saat Username sama -->
            <?php
                if(isset($_SESSION['pengguna_eror'])) { ?>
                <div id="alert-message" class="mb-4 bg-gradient-to-br from-red-50 via-red-100 to-orange-50 p-4 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex justify-between items-center animate-pulse animate-slide-in-right" role="alert">
                    <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 bg-gradient-to-br from-red-400 to-pink-500 p-2 rounded-full">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-pink-600 text-base mb-0.5">Pesan Gagal</h3>
                        <p class="text-red-600 text-sm"><?php echo $_SESSION['pengguna_eror']; ?></p>
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
            unset($_SESSION['pengguna_eror']);
            } 
            ?>

            <form action="proses_edit.php" method="POST" class="space-y-4 animate-scale-in">
            <input type="hidden" name="id_pengguna" value="<?php echo $data['id_pengguna']; ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group animate-slide-in-left">
                <label class="block text-sm font-medium text-indigo-500 mb-2">Username</label>
                <input type="text" name="username" value="<?php echo $data['username']; ?>" class="w-full px-3 py-2 border border-pink-200 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" placeholder="Masukkan username" required>
                </div>
        
                <div class="form-group animate-slide-in-right">
                    <label for="password" class="block text-sm font-medium text-indigo-500 mb-2">Password</label>
                    <div class="relative">
                    <input type="password" id="password" name="password" 
                            class="w-full px-3 py-2 border border-pink-200 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400"
                            placeholder="Kosongkan jika tidak ingin mengubah password">
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-400 hover:text-pink-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" id="eyeIcon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                    </div>
                </div>

                <div class="form-group animate-slide-in-left">
                <label class="block text-sm font-medium text-indigo-500 mb-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="<?php echo $data['nama_lengkap']; ?>" class="w-full px-3 py-2 border border-pink-200 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="form-group animate-slide-in-right">
                <label class="block text-sm font-medium text-indigo-500 mb-2">Peran</label>
                <select name="role" class="w-full px-3 py-2 border border-pink-200 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" required>
                    <option value="">Pilih Peran</option>
                    <option value="Admin" <?php echo ($data['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="Kasir" <?php echo ($data['role'] == 'Kasir') ? 'selected' : ''; ?>>Kasir</option>
                    <option value="Pemilik" <?php echo ($data['role'] == 'Pemilik') ? 'selected' : ''; ?>>Pemilik</option>
                </select>
                </div>

                <div class="form-group animate-slide-in-left">
                <label class="block text-sm font-medium text-indigo-500 mb-2">No. HP</label>
                <input type="text" name="nomor_hp" value="<?php echo $data['nomor_hp']; ?>" class="w-full px-3 py-2 border border-pink-200 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" placeholder="Masukkan nomor HP" required>
                </div>

                <div class="form-group animate-slide-in-right">
                <label class="block text-sm font-medium text-indigo-500 mb-2">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full px-3 py-2 border border-pink-200 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-Laki" <?php echo ($data['jenis_kelamin'] == 'Laki-Laki') ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php echo ($data['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                </select>
                </div>
            </div>

            <div class="form-group animate-slide-in-up">
                <label class="block text-sm font-medium text-indigo-500 mb-2">Alamat</label>
                <textarea name="alamat" rows="3" class="w-full px-3 py-2 border border-pink-200 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" placeholder="Masukkan alamat lengkap" required><?php echo $data['alamat']; ?></textarea>
            </div>

            <div class="flex justify-end space-x-3 animate-slide-in-up">
                <a href="index.php" class="px-4 py-2 bg-rose-300 text-white rounded-md hover:bg-rose-500 transition duration-200">Batal</a>
                <button onclick="return confirm('Apakah Anda yakin ingin menyimpan perubahan?')" type="submit" class="px-4 py-2 bg-pink-400 text-white rounded-md hover:bg-pink-600 transition duration-200">Simpan</button>
            </div>
            </form>        
        </div>
    </main>
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

<?php include ('../../layout/footer.php'); ?>