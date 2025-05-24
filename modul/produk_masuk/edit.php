<?php
    $judul_halaman = "Edit Data Produk Masuk";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-3 sm:p-5 lg:p-7 animate-slide-in-up">
        <div class="bg-gradient-to-br from-pink-100 to-pink-200 rounded-2xl shadow-2xl p-4 sm:p-7 lg:p-9 animate-scale-in backdrop-blur-sm">
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-pink-500 mb-6 sm:mb-8 border-b-2 border-dashed border-pink-300 pb-4 flex items-center">
                <span class="mr-2 sm:mr-3">📦</span> Edit Data Produk Masuk
            </h2>

            <!-- Pesan Gagal Saat Menambahkan Data -->
            <?php
                if(isset($_SESSION['produk_masuk_error'])) { ?>
                <div id="alert-message" class="mb-4 bg-gradient-to-br from-red-50 via-red-100 to-orange-50 p-4 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex justify-between items-center animate-pulse animate-slide-in-right" role="alert">
                    <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 bg-gradient-to-br from-red-400 to-pink-500 p-2 rounded-full">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-pink-600 text-base mb-0.5">Pesan Gagal</h3>
                        <p class="text-red-600 text-sm"><?php echo $_SESSION['produk_masuk_error']; ?></p>
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
            unset($_SESSION['produk_masuk_error']);
            } 
            ?>

            <?php
            if (isset($_GET['id'])) {
                $id_penerimaan = $_GET['id'];
                $query = "SELECT * FROM penerimaan_produk WHERE id_penerimaan_produk = ? AND status_dihapus = 0";
                $stmt = $koneksi->prepare($query);
                $stmt->bind_param("i", $id_penerimaan);
                $stmt->execute();
                $result = $stmt->get_result();
                $data = $result->fetch_assoc();

                if ($data) {
            ?>
            <form id="formPembelian" class="space-y-6 sm:space-y-8" method="POST" action="proses_edit.php">
                <input type="hidden" name="id_penerimaan_produk" value="<?php echo $data['id_penerimaan_produk']; ?>">
                <div class="grid grid-cols-1 gap-6 sm:gap-8">
                    <div class="md:col-span-2 glass-morphism p-4 sm:p-6 lg:p-7 rounded-xl space-y-4 sm:space-y-6 border-2 border-pink-300 animate-slide-in-right hover:shadow-xl transition-all duration-300">
                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 lg:gap-7">
                            <div class="w-full sm:flex-1 group">
                                <label class="block text-sm font-semibold text-rose-500 mb-2 group-hover:text-pink-600 transition-colors">
                                    <span class="flex items-center">
                                        <span class="mr-2">📅</span>
                                        Tanggal Penerimaan
                                        <span class="text-pink-600 ml-1">*</span>
                                    </span>
                                </label>
                                <input type="date" id="tanggalPenerimaan" name="tanggal" value="<?php echo $data['tanggal']; ?>" class="mt-1 block w-full rounded-xl border-2 border-fuchsia-300 bg-white/80 px-3 sm:px-4 py-2 sm:py-3 focus:outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-200 transition-all duration-300 hover:border-pink-400" required>
                            </div>
                            
                            <div class="w-full sm:flex-1 group">
                                <label class="block text-sm font-semibold text-rose-500 mb-2 group-hover:text-pink-600 transition-colors">
                                    <span class="flex items-center">
                                        <span class="mr-2">📝</span>
                                        Keterangan
                                    </span>
                                </label>
                                <textarea id="keterangan" name="keterangan" class="mt-1 block w-full rounded-xl border-2 border-fuchsia-300 bg-white/80 px-3 sm:px-4 py-2 sm:py-3 focus:outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-200 transition-all duration-300 hover:border-pink-400" rows="2"><?php echo $data['keterangan']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white/90 rounded-xl border-2 border-pink-300 overflow-hidden animate-slide-in-left hover:shadow-xl transition-all duration-300">
                    <div class="flex flex-col sm:flex-row justify-between items-center p-4 sm:p-5 bg-gradient-to-r from-gray-50 to-pink-50 border-b-2 border-pink-300 gap-3 sm:gap-0">
                        <h3 class="text-base sm:text-lg font-semibold text-rose-500 flex items-center">
                            <span class="mr-2">🛍️</span> Detail Produk
                        </h3>
                        <button type="button" id="tambahProduk" class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-5 py-2 sm:py-2.5 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-xl hover:from-pink-600 hover:to-rose-600 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-pink-400 transform hover:scale-105 animate-bounce-in">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Tambah Produk
                        </button>
                    </div>

                    <div id="tabelDinamis" class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-gray-50 to-pink-50 sticky top-0 z-10">
                                <tr>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-rose-500 uppercase tracking-wider border-b-2 border-pink-300" style="min-width: 200px; width: 40%">Nama Produk</th>                                    
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-rose-500 uppercase tracking-wider border-b-2 border-pink-300" style="width: 25%">Harga Beli</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-rose-500 uppercase tracking-wider border-b-2 border-pink-300" style="width: 25%">Jumlah</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-rose-500 uppercase tracking-wider border-b-2 border-pink-300" style="width: 10%">Aksi</th>                                
                                </tr>
                            </thead>
                            <tbody id="detailProduk" class="divide-y divide-pink-200">
                                <?php
                                $query_detail = "SELECT dp.*, p.nama_produk, p.kode_produk 
                                               FROM detail_penerimaan_produk dp 
                                               JOIN produk p ON dp.id_produk = p.id_produk 
                                               WHERE dp.penerimaan_produk_id = ? AND dp.status_dihapus = 0";
                                $stmt_detail = $koneksi->prepare($query_detail);
                                $stmt_detail->bind_param("i", $id_penerimaan);
                                $stmt_detail->execute();
                                $result_detail = $stmt_detail->get_result();
                                $counter = 0;
                                while($detail = $result_detail->fetch_assoc()) {
                                    $counter++;
                                    echo "<tr id='produk-{$counter}'>";
                                    echo "<td class='px-2 sm:px-4 md:px-6 py-4'>
                                            <div class='relative'>
                                                <div class='flex flex-col sm:flex-row gap-2'>
                                                    <input type='text' 
                                                        class='search-produk w-full rounded-xl border-2 border-fuchsia-300 px-2 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-200 transition-all duration-300 hover:border-pink-400'
                                                        value='{$detail['nama_produk']}'
                                                        placeholder='Masukkan kode/nama produk'
                                                        onkeypress='if(event.key === \"Enter\") searchProduk(event, this, {$counter})'>
                                                    <button type='button' 
                                                        class='px-3 sm:px-4 py-2 bg-pink-500 text-white rounded-xl hover:bg-pink-600 transition-all duration-300 flex items-center justify-center'
                                                        onclick='searchProduk(event, this.previousElementSibling, {$counter})'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 sm:h-5 sm:w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z' />
                                                        </svg>
                                                    </button>
                                                    <input type='hidden' name='produk[{$counter}][id_produk]' class='produk-id' value='{$detail['id_produk']}'>
                                                    <input type='hidden' name='produk[{$counter}][kode_produk]' class='produk-kode' value='{$detail['kode_produk']}'>
                                                </div>
                                                <div class='text-xs sm:text-sm text-gray-500 mt-1 italic'>Tekan Enter atau klik tombol cari</div>
                                                <div class='search-results absolute w-full bg-white border-2 border-fuchsia-300 rounded-xl mt-1 shadow-lg hidden z-50 max-h-48 sm:max-h-60 overflow-y-auto'></div>
                                            </div>
                                        </td>";
                                    echo "<td class='px-2 sm:px-4 md:px-6 py-4'>
                                            <input type='number' name='produk[{$counter}][harga_beli]' value='{$detail['harga_beli']}' class='w-full rounded-xl border-2 border-fuchsia-300 px-2 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-200 transition-all duration-300 hover:border-pink-400' min='0' required>
                                        </td>";
                                    echo "<td class='px-2 sm:px-4 md:px-6 py-4'>
                                            <input type='number' name='produk[{$counter}][jumlah]' value='{$detail['jumlah']}' class='qty w-full rounded-xl border-2 border-fuchsia-300 px-2 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-200 transition-all duration-300 hover:border-pink-400' min='1' required>
                                        </td>";
                                    echo "<td class='px-2 sm:px-4 md:px-6 py-4'>
                                            <button type='button' onclick='hapusProduk({$counter})' class='text-rose-500 hover:text-rose-700'>
                                                <svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'/>
                                                </svg>
                                            </button>
                                        </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 pt-4 sm:pt-6 border-t-2 border-dashed border-pink-300">
                    <a href="index.php" class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 border-2 border-pink-400 rounded-xl text-rose-500 font-medium hover:bg-pink-100 transition-all duration-300 transform hover:scale-105 text-center">
                        <span class="flex items-center justify-center">
                            <span class="mr-2">❌</span> Batal
                        </span>
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-6 sm:px-8 py-2.5 sm:py-3 bg-gradient-to-r from-pink-500 to-rose-500 text-white font-medium rounded-xl hover:from-pink-600 hover:to-rose-600 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-pink-400 transform hover:scale-105 animate-bounce-in">
                        <span class="flex items-center justify-center">
                            <span class="mr-2">💾</span> Simpan Perubahan
                        </span>
                    </button>
                </div>
            </form>
            <?php
                } else {
                    echo "<div class='text-center text-rose-500'>Data tidak ditemukan</div>";
                }
            } else {
                echo "<div class='text-center text-rose-500'>ID tidak ditemukan</div>";
            }
            ?>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let produkCounter = <?php echo $counter; ?>;
            
            document.getElementById('tambahProduk').addEventListener('click', function() {
                tambahBarisProduk();
            });

            const form = document.getElementById('formPembelian');
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (confirm('Apakah Anda yakin ingin menyimpan transaksi ini?')) {
                        form.removeEventListener('submit', arguments.callee);
                        form.submit();
                    }
            });

            function tambahBarisProduk() {
                produkCounter++;
                const row = document.createElement('tr');
                row.id = `produk-${produkCounter}`;
                row.innerHTML = `
                    <td class="px-2 sm:px-4 md:px-6 py-4">
                        <div class="relative">
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" 
                                    class="search-produk w-full rounded-xl border-2 border-fuchsia-300 px-2 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-200 transition-all duration-300 hover:border-pink-400" 
                                    placeholder="Masukkan kode/nama produk"
                                    onkeypress="if(event.key === 'Enter') searchProduk(event, this, ${produkCounter})">
                                <button type="button" 
                                    class="px-3 sm:px-4 py-2 bg-pink-500 text-white rounded-xl hover:bg-pink-600 transition-all duration-300 flex items-center justify-center"
                                    onclick="searchProduk(event, this.previousElementSibling, ${produkCounter})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="text-xs sm:text-sm text-gray-500 mt-1 italic">Tekan Enter atau klik tombol cari</div>
                            <input type="hidden" name="produk[${produkCounter}][id_produk]" class="produk-id">
                            <input type="hidden" name="produk[${produkCounter}][kode_produk]" class="produk-kode">
                            <div class="search-results absolute w-full bg-white border-2 border-fuchsia-300 rounded-xl mt-1 shadow-lg hidden z-50 max-h-48 sm:max-h-60 overflow-y-auto"></div>
                        </div>                    
                    </td>
                    <td class="px-2 sm:px-4 md:px-6 py-4">
                        <input type="number" name="produk[${produkCounter}][harga_beli]" class="w-full rounded-xl border-2 border-fuchsia-300 px-2 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-200 transition-all duration-300 hover:border-pink-400" min="0" placeholder="Harga Beli" required>
                    </td>
                    <td class="px-2 sm:px-4 md:px-6 py-4">
                        <input type="number" name="produk[${produkCounter}][jumlah]" class="qty w-full rounded-xl border-2 border-fuchsia-300 px-2 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-200 transition-all duration-300 hover:border-pink-400" min="1" value="1" required>
                    </td>                    
                    <td class="px-2 sm:px-4 md:px-6 py-4">
                        <button type="button" class="text-rose-500 hover:text-rose-700" onclick="hapusProduk(${produkCounter})">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </td>
                `;
                document.getElementById('detailProduk').appendChild(row);
            }

            window.searchProduk = function(event, input, counter) {
                event.preventDefault();
                const searchTerm = input.value.trim();
                const resultsDiv = input.parentElement.parentElement.querySelector('.search-results');
                const tabelDinamis = document.getElementById('tabelDinamis');
                tabelDinamis.style.height = '300px';
                tabelDinamis.style.overflowY = 'auto';

                fetch(`search_produk.php?term=${encodeURIComponent(searchTerm)}`)
                    .then(response => response.json())
                    .then(data => {
                        resultsDiv.innerHTML = '';
                        if(data.length > 0) {
                            data.forEach(item => {
                                const div = document.createElement('div');
                                div.className = 'p-2 sm:p-3 hover:bg-gray-100 cursor-pointer border-b border-pink-100 last:border-b-0 text-sm sm:text-base';
                                div.innerHTML = `${item.kode_produk} - ${item.nama_produk}`;
                                div.onclick = function() {
                                    const existingProduk = document.querySelectorAll('.produk-kode');
                                    for(let produk of existingProduk) {
                                        if(produk.value === item.kode_produk) {
                                            alert('Produk dengan kode ' + item.kode_produk + ' sudah ada dalam daftar!');
                                            resultsDiv.classList.add('hidden');
                                            input.value = '';
                                            return;
                                        }
                                    }
                                    
                                    input.value = item.nama_produk;
                                    input.parentElement.parentElement.querySelector('.produk-id').value = item.id_produk;
                                    input.parentElement.parentElement.querySelector('.produk-kode').value = item.kode_produk;
                                    const row = input.closest('tr');
                                    row.querySelector('input[name*="harga_beli"]').value = item.harga_beli;
                                    resultsDiv.classList.add('hidden');
                                };
                                resultsDiv.appendChild(div);
                            });
                            resultsDiv.classList.remove('hidden');
                        }
                    });
            };
            
            window.hapusProduk = function(counter) {
                if(confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                    document.getElementById(`produk-${counter}`).remove();
                }
            }
        });
    </script>
        
<?php include ('../../layout/footer.php'); ?>