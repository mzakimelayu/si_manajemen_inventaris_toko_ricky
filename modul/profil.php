<?php
    $judul_halaman = "Profil Pengguna";
    
    include '../cek_login.php';
?>

<?php include '../layout/header.php'; ?>

<?php include '../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-2 sm:p-4 lg:p-6 animate-slide-in-down">
        <div class="bg-gradient-to-br from-pink-100 to-pink-200 rounded-2xl shadow-lg p-8 max-w-4xl mx-auto animate-fade-in animate-slide-in-up backdrop-blur-sm">
            <h1 class="text-3xl font-bold mb-8 text-indigo-500 border-b-2 border-indigo-200 pb-2">Profil Saya</h1>
            <?php
                $query = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE id_pengguna='$sesi_id_pengguna'");
                $data = mysqli_fetch_array($query);
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6 bg-white/30 rounded-xl p-6 backdrop-blur-sm">
                    <div class="flex flex-col transform hover:scale-105 transition-transform duration-200">
                        <label class="text-sm font-semibold text-rose-600 uppercase tracking-wider">Username</label>
                        <span class="mt-2 text-gray-800 text-lg border-b border-fuchsia-100 pb-1"><?php echo $data['username']; ?></span>
                    </div>
                    <div class="flex flex-col transform hover:scale-105 transition-transform duration-200">
                        <label class="text-sm font-semibold text-rose-600 uppercase tracking-wider">Nama Lengkap</label>
                        <span class="mt-2 text-gray-800 text-lg border-b border-fuchsia-100 pb-1"><?php echo $data['nama_lengkap']; ?></span>
                    </div>
                    <div class="flex flex-col transform hover:scale-105 transition-transform duration-200">
                        <label class="text-sm font-semibold text-rose-600 uppercase tracking-wider">Peran</label>
                        <span class="mt-2 text-gray-800 text-lg border-b border-fuchsia-100 pb-1"><?php echo $data['role']; ?></span>
                    </div>
                </div>
                <div class="space-y-6 bg-white/30 rounded-xl p-6 backdrop-blur-sm">
                    <div class="flex flex-col transform hover:scale-105 transition-transform duration-200">
                        <label class="text-sm font-semibold text-rose-600 uppercase tracking-wider">No. HP</label>
                        <span class="mt-2 text-gray-800 text-lg border-b border-fuchsia-100 pb-1"><?php echo $data['nomor_hp'] ?: '-'; ?></span>
                    </div>
                    <div class="flex flex-col transform hover:scale-105 transition-transform duration-200">
                        <label class="text-sm font-semibold text-rose-600 uppercase tracking-wider">Jenis Kelamin</label>
                        <span class="mt-2 text-gray-800 text-lg border-b border-fuchsia-100 pb-1"><?php echo $data['jenis_kelamin']; ?></span>
                    </div>
                    <div class="flex flex-col transform hover:scale-105 transition-transform duration-200">
                        <label class="text-sm font-semibold text-rose-600 uppercase tracking-wider">Alamat</label>
                        <span class="mt-2 text-gray-800 text-lg border-b border-fuchsia-100 pb-1"><?php echo $data['alamat'] ?: '-'; ?></span>
                    </div>
                </div>
            </div>
            <div class="mt-8 flex justify-end space-x-4">
                <a href="<?= base_url('modul/pengaturan.php') ?>" class="px-6 py-2.5 bg-pink-600 text-white rounded-full hover:bg-pink-400 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                    <i class="fas fa-edit mr-2"></i>Edit Profil
                </a>
                <a href="javascript:history.back()" class="px-6 py-2.5 bg-rose-300 text-white rounded-full hover:bg-rose-500 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </main><?php include ('../layout/footer.php'); ?>