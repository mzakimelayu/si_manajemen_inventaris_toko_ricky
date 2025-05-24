<?php
    $judul_halaman = "Detail Produk";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-2 sm:p-4 lg:p-6 animate-slide-in-down">
        <div class="bg-gradient-to-br from-pink-100 to-pink-200 rounded-2xl shadow-lg p-8 max-w-4xl mx-auto animate-fade-in animate-slide-in-up backdrop-blur-sm">
            <h1 class="text-3xl font-bold mb-8 text-indigo-500 border-b-2 border-indigo-200 pb-2">Detail Produk</h1>
            
            <?php                
                $id = $_GET['id'];
                $query = mysqli_query($koneksi, "SELECT p.*, k.nama_kategori, s.nama_satuan 
                                               FROM produk p 
                                               LEFT JOIN kategori_produk k ON p.id_kategori_produk = k.id_kategori_produk
                                               LEFT JOIN satuan_produk s ON p.id_satuan_produk = s.id_satuan_produk
                                               WHERE p.id_produk = '$id' AND p.status_dihapus = 0");
                $data = mysqli_fetch_array($query);
                
                if (mysqli_num_rows($query) == 0) {
                    echo "<script>window.location.href='" . base_url('404.php') . "';</script>";
                    exit;
                }
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6 bg-white/30 rounded-xl p-6 backdrop-blur-sm">
                    <div class="flex flex-col transform hover:scale-105 transition-transform duration-200">
                        <label class="text-sm font-semibold text-rose-600 uppercase tracking-wider">Kode Produk</label>
                        <span class="mt-2 text-gray-800 text-lg border-b border-fuchsia-100 pb-1"><?php echo $data['kode_produk']; ?></span>
                    </div>
                    
                    <div class="flex flex-col transform hover:scale-105 transition-transform duration-200">
                        <label class="text-sm font-semibold text-rose-600 uppercase tracking-wider">Nama Produk</label>
                        <span class="mt-2 text-gray-800 text-lg border-b border-fuchsia-100 pb-1"><?php echo $data['nama_produk']; ?></span>
                    </div>

                    <div class="flex flex-col transform hover:scale-105 transition-transform duration-200">
                        <label class="text-sm font-semibold text-rose-600 uppercase tracking-wider">Kategori</label>
                        <span class="mt-2 text-gray-800 text-lg border-b border-fuchsia-100 pb-1"><?php echo $data['nama_kategori'] ?: '-'; ?></span>
                    </div>

                    <div class="flex flex-col transform hover:scale-105 transition-transform duration-200">
                        <label class="text-sm font-semibold text-rose-600 uppercase tracking-wider">Satuan</label>
                        <span class="mt-2 text-gray-800 text-lg border-b border-fuchsia-100 pb-1"><?php echo $data['nama_satuan'] ?: '-'; ?></span>
                    </div>
                </div>
                
                <div class="space-y-6 bg-white/30 rounded-xl p-6 backdrop-blur-sm">
                    <div class="flex flex-col transform hover:scale-105 transition-transform duration-200">
                        <label class="text-sm font-semibold text-rose-600 uppercase tracking-wider">Stok</label>
                        <span class="mt-2 text-gray-800 text-lg border-b border-fuchsia-100 pb-1"><?php echo $data['stok']; ?></span>
                    </div>

                    <div class="flex flex-col transform hover:scale-105 transition-transform duration-200">
                        <label class="text-sm font-semibold text-rose-600 uppercase tracking-wider">Stok Minimum</label>
                        <span class="mt-2 text-gray-800 text-lg border-b border-fuchsia-100 pb-1"><?php echo $data['stok_minimum']; ?></span>
                    </div>

                    <div class="flex flex-col transform hover:scale-105 transition-transform duration-200">
                        <label class="text-sm font-semibold text-rose-600 uppercase tracking-wider">Harga Beli</label>
                        <span class="mt-2 text-gray-800 text-lg border-b border-fuchsia-100 pb-1">Rp <?php echo number_format($data['harga_beli'], 2, ',', '.'); ?></span>
                    </div>

                    <div class="flex flex-col transform hover:scale-105 transition-transform duration-200">
                        <label class="text-sm font-semibold text-rose-600 uppercase tracking-wider">Harga Jual</label>
                        <span class="mt-2 text-gray-800 text-lg border-b border-fuchsia-100 pb-1">Rp <?php echo number_format($data['harga_jual'], 2, ',', '.'); ?></span>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="edit.php?id=<?php echo $id; ?>" class="px-6 py-2.5 bg-pink-600 text-white rounded-full hover:bg-pink-400 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                    <i class="fas fa-edit mr-2"></i>Edit Data
                </a>
                <a href="index.php" class="px-6 py-2.5 bg-rose-300 text-white rounded-full hover:bg-rose-500 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </main>
    
<?php include ('../../layout/footer.php'); ?>