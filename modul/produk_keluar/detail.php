<?php
    $judul_halaman = "Detail Data Produk Keluar";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-2 sm:p-4 lg:p-6 bg-gray-100">
        <?php
            
            $id_pengeluaran = $_GET['id'];
            
            // Get pengeluaran data
            $query = "SELECT p.*, u.nama_lengkap as nama_lengkap_pengguna 
                     FROM pengeluaran_produk p 
                     JOIN pengguna u ON p.id_pengguna = u.id_pengguna 
                     WHERE p.id_pengeluaran_produk = $id_pengeluaran";
              $result = mysqli_query($koneksi, $query);
              $pengeluaran = mysqli_fetch_assoc($result);

              if (mysqli_num_rows($result) == 0) {
                  echo "<script>window.location.href='" . base_url('404.php') . "';</script>";                    
                  exit;
              }        
              ?>
        
          <div class="max-w-4xl mx-auto bg-pink-200 p-8 rounded-lg shadow-lg animate-slide-in-down" id="printArea">
              <!-- Header -->
              <div class="grid grid-cols-2 gap-8 mb-8">
                  <div class="bg-rose-300 p-6 rounded-lg shadow-md animate-slide-in-left">
                      <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Detail Produk Keluar</h2>
                      <p class="<?php echo $pengeluaran['status_dihapus'] == 1 ? 'bg-rose-500 text-white' : 'bg-pink-400 text-white'; ?> inline-block px-3 py-1 rounded text-sm mt-3">Status: <?php echo $pengeluaran['status_dihapus'] == 1 ? 'DIBATALKAN' : 'SELESAI'; ?></p>
                      <p class="text-indigo-900 mt-2">Tanggal: <?php echo date('d/m/Y', strtotime($pengeluaran['tanggal'])); ?></p>
                  </div>
                  <div class="bg-rose-300 p-6 rounded-lg shadow-md animate-slide-in-right">
                      <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Keterangan:</h2>
                      <p class="text-indigo-900"><?php echo $pengeluaran['keterangan']; ?></p>
                      <p class="text-indigo-900 mt-2">Penerima: <?php echo $pengeluaran['penerima']; ?></p>
                      <p class="text-indigo-900 mt-2">Diproses Oleh: <?php echo $pengeluaran['nama_lengkap_pengguna']; ?></p> 
                  </div>
              </div>

              <!-- Items Table -->
              <table class="w-full mb-8 animate-scale-in">
                  <thead>
                      <tr class="bg-pink-400">
                          <th class="py-2 px-4 text-left text-white">Produk</th>
                          <th class="py-2 px-4 text-right text-white">Jumlah</th>
                          <th class="py-2 px-4 text-right text-white">Harga Jual</th>
                          <th class="py-2 px-4 text-right text-white">Subtotal</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                          $total = 0;
                          $query_detail = "SELECT dp.*, p.nama_produk, p.kode_produk 
                                       FROM detail_pengeluaran_produk dp 
                                       JOIN produk p ON dp.id_produk = p.id_produk 
                                       WHERE dp.id_pengeluaran_produk = $id_pengeluaran";
                          $result_detail = mysqli_query($koneksi, $query_detail);
                          while($row = mysqli_fetch_assoc($result_detail)) {
                              $subtotal = $row['jumlah'] * $row['harga_jual'];
                      ?>
                      <tr class="border-b border-pink-300 hover:bg-pink-100 animate-bounce-in">
                          <td class="py-2 px-4">
                              <div class="font-medium"><?php echo $row['nama_produk']; ?></div>
                              <div class="text-sm text-gray-600"><?php echo $row['kode_produk']; ?></div>
                          </td>
                          <td class="py-2 px-4 text-right"><?php echo $row['jumlah']; ?></td>
                          <td class="py-2 px-4 text-right"><?php echo number_format($row['harga_jual'], 2, ',', '.'); ?></td>
                          <td class="py-2 px-4 text-right"><?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                      </tr>
                      <?php 
                      $total += $subtotal;
                      } ?>
                  </tbody>
                  <tfoot>
                      <tr class="border-t-2 border-pink-600">
                          <td colspan="3" class="py-2 px-4 text-right font-bold">Total:</td>
                          <td class="py-2 px-4 text-right font-bold text-pink-600"><?php echo number_format($total, 2, ',', '.'); ?></td>
                      </tr>
                  </tfoot>
              </table>

              <!-- Action Buttons -->
              <div class="flex justify-end space-x-4 mt-6">
                  <a href="index.php" class="px-6 py-2.5 bg-rose-300 text-white rounded-full hover:bg-rose-500 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                      <i class="fas fa-arrow-left mr-2"></i>Kembali
                  </a>
                  <?php if($pengeluaran['status_dihapus'] != 1) { ?>
                  <a href="edit.php?id=<?php echo $id_pengeluaran; ?>" class="px-6 py-2.5 bg-pink-600 text-white rounded-full hover:bg-pink-400 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                      <i class="fas fa-edit mr-2"></i>Edit Data
                  </a>
                  <?php } ?>
              </div>
          </div>
    </main>    

<?php include ('../../layout/footer.php'); ?>