<?php
    $judul_halaman = "Laporan Stok Produk";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-2 sm:p-4 lg:p-6 animate-fade-in">
        <div class="bg-gray-100 rounded-lg shadow p-4 sm:p-6">
            <h2 class="text-2xl font-bold mb-6 text-pink-600">Laporan Stok Produk</h2>

            <!-- Filter Section -->
            <div class="bg-white p-4 rounded-lg shadow-sm mb-6 animate-slide-in-up">
                <form method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-3 gap-6 p-4">
                    <div class="space-y-3">
                        <label class="block text-indigo-600 font-semibold text-sm uppercase tracking-wider">
                            Kategori Produk
                        </label>
                        <select name="kategori" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-white focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none transition-all duration-200 ease-in-out">
                            <option value="">Semua Kategori</option>
                            <?php
                            $query_kategori = "SELECT * FROM kategori_produk ORDER BY nama_kategori ASC";
                            $result_kategori = mysqli_query($koneksi, $query_kategori);
                            while($row = mysqli_fetch_assoc($result_kategori)) {
                                $selected = (isset($_GET['kategori']) && $_GET['kategori'] == $row['id_kategori_produk']) ? 'selected' : '';
                                echo "<option value='".$row['id_kategori_produk']."' ".$selected.">".$row['nama_kategori']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="space-y-3">
                        <label class="block text-indigo-600 font-semibold text-sm uppercase tracking-wider">
                            Status Stok
                        </label>
                        <select name="status" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-white focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none transition-all duration-200 ease-in-out">
                            <option value="">Semua Status</option>
                            <option value="Aman" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Aman') ? 'selected' : ''; ?>>Aman</option>
                            <option value="Perlu Restock" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Perlu Restock') ? 'selected' : ''; ?>>Perlu Restock</option>
                        </select>
                    </div>                    <div class="flex items-end">
                        <button type="submit" name="tampilkan" class="w-full bg-pink-600 hover:bg-pink-700 text-white px-8 py-3 rounded-lg font-medium transition duration-200 transform hover:scale-105 shadow-md focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50">
                            Tampilkan Data
                        </button>
                    </div>
                </form>
            </div>

            <?php
            if(isset($_GET['tampilkan'])) {
                $where = "WHERE 1=1";
                if(!empty($_GET['kategori'])) {
                    $where .= " AND p.id_kategori_produk = '".$_GET['kategori']."'";
                }
                if(!empty($_GET['status'])) {
                    if($_GET['status'] == 'Perlu Restock') {
                        $where .= " AND p.stok <= p.stok_minimum";
                    } else {
                        $where .= " AND p.stok > p.stok_minimum";
                    }
                }
            ?>
            <!-- Table Section -->
            <div class="overflow-x-auto bg-white rounded-lg shadow animate-slide-in-up">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-pink-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Kode Produk</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Kategori</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Satuan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Stok</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Stok Minimum</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status Stok</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        $query = "SELECT 
                                p.kode_produk,
                                p.nama_produk,
                                kp.nama_kategori,
                                sp.nama_satuan,
                                p.stok,
                                p.stok_minimum,
                                CASE
                                    WHEN p.stok <= p.stok_minimum THEN 'Perlu Restock'
                                    ELSE 'Aman'
                                END AS status_stok
                            FROM produk p 
                            JOIN kategori_produk kp ON p.id_kategori_produk = kp.id_kategori_produk
                            JOIN satuan_produk sp ON p.id_satuan_produk = sp.id_satuan_produk
                            $where";

                        $result = mysqli_query($koneksi, $query);   
                        if (!$result) {
                            die("Query error: " . mysqli_error($koneksi));
                        }

                        $no = 1;
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr class='hover:bg-pink-50'>";
                                echo "<td class='px-4 py-3 text-sm text-gray-700'>$no</td>";
                                echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['kode_produk']."</td>";
                                echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['nama_produk']."</td>";
                                echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['nama_kategori']."</td>";
                                echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['nama_satuan']."</td>";
                                echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['stok']."</td>";
                                echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['stok_minimum']."</td>";
                                echo "<td class='px-4 py-3 text-sm'>";
                                echo $row['status_stok'] == 'Perlu Restock' ? 
                                    "<span class='px-2 py-1 text-rose-700 bg-rose-100 rounded-full text-sm'>Perlu Restock</span>" : 
                                    "<span class='px-2 py-1 text-fuchsia-700 bg-fuchsia-100 rounded-full text-sm'>Aman</span>";
                                echo "</td>";
                                echo "</tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='8' class='px-4 py-3 text-sm text-gray-700 text-center'>Tidak ada data</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Print Options -->
            <div class="mt-6 flex flex-wrap gap-4 justify-end animate-bounce-in">
                <a href="cetak.php?kategori=<?= isset($_GET['kategori']) ? $_GET['kategori'] : '' ?>&status=<?= isset($_GET['status']) ? $_GET['status'] : '' ?>" 
                   target="_blank" 
                   class="bg-pink-400 hover:bg-pink-500 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Laporan
                </a>
            </div>
            <?php } ?>
        </div>
    </main>



<?php include ('../../layout/footer.php'); ?>