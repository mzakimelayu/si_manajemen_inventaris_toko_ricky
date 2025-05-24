<?php
    $judul_halaman = "Edit Produk";
    
    include '../../cek_login.php';

    // Ambil data produk berdasarkan ID
    $id = $_GET['id'];
    $query = "SELECT * FROM produk WHERE id_produk = '$id'";
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
            <h2 class="text-2xl font-semibold mb-6 text-pink-600 animate-bounce-in">Edit Produk</h2>

            <?php
                if(isset($_SESSION['produk_eror'])) { ?>
                <div id="alert-message" class="mb-4 bg-gradient-to-br from-red-50 via-red-100 to-orange-50 p-4 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex justify-between items-center animate-pulse animate-slide-in-right" role="alert">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 bg-gradient-to-br from-red-400 to-pink-500 p-2 rounded-full">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-pink-600 text-base mb-0.5">Pesan Gagal</h3>
                            <p class="text-red-600 text-sm"><?php echo $_SESSION['produk_eror']; ?></p>
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
            unset($_SESSION['produk_eror']);
            } 
            ?>

            <form action="proses_edit.php" method="POST" class="space-y-4 animate-scale-in">
                <input type="hidden" name="id" value="<?php echo $data['id_produk']; ?>">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group animate-slide-in-left">
                        <label class="block text-sm font-medium text-indigo-500 mb-2">Kode Produk</label>
                        <input type="text" name="kode_produk" value="<?php echo $data['kode_produk']; ?>" class="w-full px-3 py-2 border border-pink-200 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" placeholder="Masukkan kode produk" required>
                    </div>
                    <div class="form-group animate-slide-in-right">
                        <label class="block text-sm font-medium text-indigo-500 mb-2">Nama Produk</label>
                        <input type="text" name="nama_produk" value="<?php echo $data['nama_produk']; ?>" class="w-full px-3 py-2 border border-pink-200 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" placeholder="Masukkan nama produk" required>
                    </div>
                    <div class="form-group animate-slide-in-left">
                        <label class="block text-sm font-medium text-indigo-500 mb-2">Kategori</label>
                        <select name="id_kategori_produk" class="w-full px-3 py-2 border border-pink-200 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" required>
                            <?php
                            $query_kategori = "SELECT * FROM kategori_produk WHERE status_dihapus = 0";
                            $result_kategori = mysqli_query($koneksi, $query_kategori);
                            while($kategori = mysqli_fetch_assoc($result_kategori)) {
                                $selected = ($kategori['id_kategori_produk'] == $data['id_kategori_produk']) ? 'selected' : '';
                                echo "<option value='".$kategori['id_kategori_produk']."' ".$selected.">".$kategori['nama_kategori']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group animate-slide-in-right">
                        <label class="block text-sm font-medium text-indigo-500 mb-2">Satuan</label>
                        <select name="id_satuan_produk" class="w-full px-3 py-2 border border-pink-200 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" required>
                            <?php
                            $query_satuan = "SELECT * FROM satuan_produk WHERE status_dihapus = 0";
                            $result_satuan = mysqli_query($koneksi, $query_satuan);
                            while($satuan = mysqli_fetch_assoc($result_satuan)) {
                                $selected = ($satuan['id_satuan_produk'] == $data['id_satuan_produk']) ? 'selected' : '';
                                echo "<option value='".$satuan['id_satuan_produk']."' ".$selected.">".$satuan['nama_satuan']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group animate-slide-in-left">
                        <label class="block text-sm font-medium text-indigo-500 mb-2">Stok</label>
                        <input type="number" name="stok" min="0" value="<?php echo $data['stok']; ?>" class="w-full px-3 py-2 border border-pink-200 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" placeholder="Masukkan stok" required>
                    </div>
                    <div class="form-group animate-slide-in-right">
                        <label class="block text-sm font-medium text-indigo-500 mb-2">Stok Minimum</label>
                        <input type="number" name="stok_minimum" min="0" value="<?php echo $data['stok_minimum']; ?>" class="w-full px-3 py-2 border border-pink-200 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" placeholder="Masukkan stok minimum" required>
                    </div>
                    <div class="form-group animate-slide-in-left">
                        <label class="block text-sm font-medium text-indigo-500 mb-2">Harga Beli</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-600 font-medium">Rp</span>
                            <input type="number" name="harga_beli" min="0" value="<?php echo $data['harga_beli']; ?>" class="w-full pl-10 pr-3 py-2 border border-pink-200 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" placeholder="Masukkan harga beli" required>
                        </div>
                    </div>
                    <div class="form-group animate-slide-in-right">
                        <label class="block text-sm font-medium text-indigo-500 mb-2">Harga Jual</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-600 font-medium">Rp</span>
                            <input type="number" name="harga_jual" min="0" value="<?php echo $data['harga_jual']; ?>" class="w-full pl-10 pr-3 py-2 border border-pink-200 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400" placeholder="Masukkan harga jual" required>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 animate-slide-in-up">
                    <a href="index.php" class="px-4 py-2 bg-rose-300 text-white rounded-md hover:bg-rose-500 transition duration-200">Batal</a>
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menyimpan perubahan?')" class="px-4 py-2 bg-pink-400 text-white rounded-md hover:bg-pink-600 transition duration-200">Simpan Perubahan</button>
                </div>            
            </form>        
        </div>
    </main>    
<?php include ('../../layout/footer.php'); ?>