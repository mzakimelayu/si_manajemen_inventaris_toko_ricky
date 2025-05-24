<?php
    $judul_halaman = "Dashboard";
    
    include 'cek_login.php';
?>

<?php include 'layout/header.php'; ?>

<?php include 'layout/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 p-2 sm:p-4 lg:p-6">
        <!-- Content goes here -->
        <!-- Dashboard Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Total Products Card -->
            
            <div class="bg-white/95 backdrop-blur-xl rounded-xl p-6 border border-pink-200 shadow-lg shadow-pink-100/20 animate-slide-in-left">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Produk</p>
                        <?php
                        $query = "SELECT COUNT(*) as total FROM produk WHERE status_dihapus = 0";
                        $result = mysqli_query($koneksi, $query);
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <h3 class="text-2xl font-bold text-gray-800"><?= number_format($data['total']) ?></h3>
                    </div>
                    <div class="p-3 bg-gradient-to-br from-pink-400 to-rose-500 rounded-lg animate-bounce-in">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stok Minimum Card -->
            <div class="bg-white/95 backdrop-blur-xl rounded-xl p-6 border border-pink-200 shadow-lg shadow-pink-100/20 animate-slide-in-right">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Stok Minimum</p>
                        <?php
                        $query = "SELECT COUNT(*) as total FROM produk WHERE stok <= stok_minimum AND status_dihapus = 0";
                        $result = mysqli_query($koneksi, $query);
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <h3 class="text-2xl font-bold text-gray-800"><?= number_format($data['total']) ?></h3>
                    </div>
                    <div class="p-3 bg-gradient-to-br from-pink-400 to-rose-500 rounded-lg animate-bounce-in">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.616a1 1 0 01.894-1.79l1.599.8L9 4.323V3a1 1 0 011-1z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Kategori Card -->
             <?php if ($sesi_role_pengguna == 'Admin' or $sesi_role_pengguna == 'Pemilik'){ ?>
            <div class="bg-white/95 backdrop-blur-xl rounded-xl p-6 border border-pink-200 shadow-lg shadow-pink-100/20 animate-slide-in-left">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Kategori</p>
                        <?php
                        $query = "SELECT COUNT(*) as total FROM kategori_produk WHERE status_dihapus = 0";
                        $result = mysqli_query($koneksi, $query);
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <h3 class="text-2xl font-bold text-gray-800"><?= number_format($data['total']) ?></h3>
                    </div>
                    <div class="p-3 bg-gradient-to-br from-pink-400 to-rose-500 rounded-lg animate-bounce-in">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Satuan Card -->
            <div class="bg-white/95 backdrop-blur-xl rounded-xl p-6 border border-pink-200 shadow-lg shadow-pink-100/20 animate-slide-in-right">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Satuan</p>
                        <?php
                        $query = "SELECT COUNT(*) as total FROM satuan_produk WHERE status_dihapus = 0";
                        $result = mysqli_query($koneksi, $query);
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <h3 class="text-2xl font-bold text-gray-800"><?= number_format($data['total']) ?></h3>
                    </div>
                    <div class="p-3 bg-gradient-to-br from-pink-400 to-rose-500 rounded-lg animate-bounce-in">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            
            <!-- Total Penerimaan Card -->
            <div class="bg-white/95 backdrop-blur-xl rounded-xl p-6 border border-pink-200 shadow-lg shadow-pink-100/20 animate-slide-in-down">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Penerimaan</p>
                        <?php
                        $query = "SELECT COUNT(*) as total FROM penerimaan_produk WHERE status_dihapus = 0";
                        $result = mysqli_query($koneksi, $query);
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <h3 class="text-2xl font-bold text-gray-800"><?= number_format($data['total']) ?></h3>
                    </div>
                    <div class="p-3 bg-gradient-to-br from-pink-400 to-rose-500 rounded-lg animate-bounce-in">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!-- Total Pengeluaran Card -->
            <div class="bg-white/95 backdrop-blur-xl rounded-xl p-6 border border-pink-200 shadow-lg shadow-pink-100/20 animate-slide-in-up">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Pengeluaran</p>
                        <?php
                        $query = "SELECT COUNT(*) as total FROM pengeluaran_produk WHERE status_dihapus = 0";
                        $result = mysqli_query($koneksi, $query);
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <h3 class="text-2xl font-bold text-gray-800"><?= number_format($data['total']) ?></h3>
                    </div>
                    <div class="p-3 bg-gradient-to-br from-pink-400 to-rose-500 rounded-lg animate-bounce-in">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        
            <!-- Total Pengguna Card -->
             <?php if ($sesi_role_pengguna == 'Admin' or $sesi_role_pengguna == 'Pemilik'){ ?>
            <div class="bg-white/95 backdrop-blur-xl rounded-xl p-6 border border-pink-200 shadow-lg shadow-pink-100/20 animate-slide-in-right">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Pengguna</p>
                        <?php
                        $query = "SELECT COUNT(*) as total FROM pengguna WHERE status_dihapus = 0";
                        $result = mysqli_query($koneksi, $query);
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <h3 class="text-2xl font-bold text-gray-800"><?= number_format($data['total']) ?></h3>
                    </div>
                    <div class="p-3 bg-gradient-to-br from-pink-400 to-rose-500 rounded-lg animate-bounce-in">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <!-- Recent Activity Section -->
        <div class="bg-white/95 backdrop-blur-xl rounded-xl p-6 border border-pink-200 shadow-lg shadow-pink-100/20 animate-scale-in">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h2>
            <div class="space-y-4">
                <?php
                // Get recent activities (combine and sort recent transactions)
                if ($sesi_role_pengguna == 'Admin' || $sesi_role_pengguna == 'Pemilik') {
                    $query = "
                        (SELECT 
                            'penerimaan' as tipe,
                            p.tanggal,
                            pr.nama_produk,
                            dp.jumlah,
                            dp.harga_beli as harga
                        FROM penerimaan_produk p
                        JOIN detail_penerimaan_produk dp ON p.id_penerimaan_produk = dp.penerimaan_produk_id
                        JOIN produk pr ON dp.id_produk = pr.id_produk
                        WHERE p.status_dihapus = 0
                        ORDER BY p.tanggal DESC
                        LIMIT 3)
                        UNION ALL
                        (SELECT 
                            'pengeluaran' as tipe,
                            p.tanggal,
                            pr.nama_produk,
                            dp.jumlah,
                            dp.harga_jual as harga
                        FROM pengeluaran_produk p
                        JOIN detail_pengeluaran_produk dp ON p.id_pengeluaran_produk = dp.id_pengeluaran_produk
                        JOIN produk pr ON dp.id_produk = pr.id_produk
                        WHERE p.status_dihapus = 0
                        ORDER BY p.tanggal DESC
                        LIMIT 3)
                        ORDER BY tanggal DESC
                        LIMIT 3
                    ";
                } else {
                    $query = "
                        SELECT 
                            'pengeluaran' as tipe,
                            p.tanggal,
                            pr.nama_produk,
                            dp.jumlah,
                            dp.harga_jual as harga
                        FROM pengeluaran_produk p
                        JOIN detail_pengeluaran_produk dp ON p.id_pengeluaran_produk = dp.id_pengeluaran_produk
                        JOIN produk pr ON dp.id_produk = pr.id_produk
                        WHERE p.status_dihapus = 0
                        ORDER BY p.tanggal DESC
                        LIMIT 3
                    ";
                }
                $result = mysqli_query($koneksi, $query);
                while($row = mysqli_fetch_assoc($result)) {
                    $tipe = $row['tipe'];
                    $icon = ($tipe == 'penerimaan') ? 
                        '<path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>' :
                        '<path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>';
                    $judul = ($tipe == 'penerimaan') ? 'Penerimaan Produk' : 'Pengeluaran Produk';
                ?>
                <div class="flex items-center justify-between p-4 bg-pink-50 rounded-lg animate-slide-in-left">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-pink-400 to-rose-500 rounded-lg animate-bounce-in">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <?= $icon ?>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800"><?= $judul ?></p>
                            <p class="text-sm text-gray-600"><?= $row['nama_produk'] ?> (<?= $row['jumlah'] ?> unit)</p>
                        </div>
                    </div>
                    <span class="text-sm text-gray-500"><?= date('d/m/Y', strtotime($row['tanggal'])) ?></span>
                </div>
                <?php } ?>
            </div>
        </div>        

    </main>

<?php include 'layout/footer.php'; ?>

          