<?php
    $judul_halaman = "Laporan Produk Keluar";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-2 sm:p-4 lg:p-6 animate-fade-in">
        <div class="bg-gray-100 rounded-lg shadow p-4 sm:p-6">
            <h2 class="text-2xl font-bold mb-6 text-pink-600">Laporan Produk Keluar</h2>

            <!-- Filter Section -->
            <div class="bg-white p-4 rounded-lg shadow-sm mb-6 animate-slide-in-up">
                <form method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-4 gap-6 p-4">
                    <div class="space-y-3">
                        <label class="block text-indigo-600 font-semibold text-sm uppercase tracking-wider">
                            Tanggal Awal
                        </label>
                        <input type="date" name="tanggal_awal" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-white focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none">
                    </div>
                    <div class="space-y-3">
                        <label class="block text-indigo-600 font-semibold text-sm uppercase tracking-wider">
                            Tanggal Akhir
                        </label>
                        <input type="date" name="tanggal_akhir" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-white focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none">
                    </div>
                    <div class="space-y-3">
                        <label class="block text-indigo-600 font-semibold text-sm uppercase tracking-wider">
                            Status
                        </label>
                        <select name="status" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-white focus:border-pink-500 focus:ring-2 focus:ring-pink-200 focus:outline-none">
                            <option value="">Semua Status</option>
                            <option value="0">Selesai</option>
                            <option value="1">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" name="tampilkan" class="w-full bg-pink-600 hover:bg-pink-700 text-white px-8 py-3 rounded-lg font-medium transition duration-200 transform hover:scale-105 shadow-md focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50">
                            Tampilkan Data
                        </button>
                    </div>
                </form>
            </div>

            <?php
            if(isset($_GET['tampilkan'])) {
                $where = "WHERE 1=1";
                if(!empty($_GET['tanggal_awal']) && !empty($_GET['tanggal_akhir'])) {
                    $where .= " AND pp.tanggal BETWEEN '".$_GET['tanggal_awal']."' AND '".$_GET['tanggal_akhir']."'";
                }
                if(isset($_GET['status']) && $_GET['status'] !== '') {
                    $where .= " AND pp.status_dihapus = ".$_GET['status'];
                }
            ?>
            <!-- Table Section -->
            <div class="overflow-x-auto bg-white rounded-lg shadow animate-slide-in-up">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-pink-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Pencatat</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Penerima</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Jumlah</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Harga Jual</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Keterangan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        $query = "SELECT 
                                pp.tanggal,
                                pp.status_dihapus,
                                u.nama_lengkap AS pencatat,
                                pp.penerima,
                                pr.nama_produk,
                                dpp.jumlah,
                                dpp.harga_jual,
                                pp.keterangan
                            FROM pengeluaran_produk pp
                            JOIN detail_pengeluaran_produk dpp ON pp.id_pengeluaran_produk = dpp.id_pengeluaran_produk
                            JOIN produk pr ON dpp.id_produk = pr.id_produk
                            JOIN pengguna u ON pp.id_pengguna = u.id_pengguna
                            $where
                            ORDER BY pp.tanggal DESC";

                        $result = mysqli_query($koneksi, $query);   
                        if (!$result) {
                            die("Query error: " . mysqli_error($koneksi));
                        }

                        $no = 1;
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                $status = $row['status_dihapus'] == 1 ? 'Dibatalkan' : 'Selesai';
                                $statusClass = $row['status_dihapus'] == 1 ? 'text-red-600' : 'text-green-600';

                                echo "<tr class='hover:bg-pink-50'>";
                                echo "<td class='px-4 py-3 text-sm text-gray-700'>$no</td>";
                                echo "<td class='px-4 py-3 text-sm text-gray-700'>".date('d/m/Y', strtotime($row['tanggal']))."</td>";
                                echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['pencatat']."</td>";
                                echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['penerima']."</td>";
                                echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['nama_produk']."</td>";
                                echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['jumlah']."</td>";
                                echo "<td class='px-4 py-3 text-sm text-gray-700'>Rp ".number_format($row['harga_jual'], 0, ',', '.')."</td>";
                                echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['keterangan']."</td>";
                                echo "<td class='px-4 py-3 text-sm font-medium {$statusClass}'>".$status."</td>";
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
                <a href="cetak.php?tanggal_awal=<?= isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : '' ?>&tanggal_akhir=<?= isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '' ?>&status=<?= isset($_GET['status']) ? $_GET['status'] : '' ?>" 
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