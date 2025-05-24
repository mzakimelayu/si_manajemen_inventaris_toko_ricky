<?php
    $judul_halaman = "Data Produk Masuk";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

          <!-- Main Content Area -->
          <main class="flex-1 p-2 sm:p-4 lg:p-6 bg-gradient-to-br from-pink-50 to-indigo-50 animate-slide-in-up">
              <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 animate-scale-in">
                  <div class="p-4 sm:p-6 lg:p-8 bg-gradient-to-r from-pink-500 via-rose-500 to-purple-500 text-white rounded-t-xl animate-slide-in-down">
                      <div class="flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-0">
                          <h2 class="text-xl sm:text-2xl font-bold flex items-center gap-3 animate-slide-in-left">
                              <span class="bg-white text-pink-600 p-2 rounded-lg animate-bounce-in">
                                  <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                  </svg>
                              </span>
                              Data Produk Masuk
                          </h2>
                          <a href="tambah.php" class="w-full sm:w-auto bg-pink-600 hover:bg-rose-500 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 transition-colors duration-300 shadow-md hover:shadow-lg animate-slide-in-right">
                              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                              </svg>
                              <span>Tambah Produk Masuk</span>
                          </a>
                      </div>
                  </div>

                  <div class="p-3 sm:p-4 lg:p-6 animate-slide-in-up">
                          <!-- Pesan Berhasil Saat Berhasil Menambahkan Data -->
                        <?php
                            if(isset($_SESSION['produk_masuk_sukses'])) { ?>
                            <div id="alert-message" class="mb-4 bg-gradient-to-br from-green-50 via-emerald-100 to-teal-50 p-4 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex justify-between items-center animate-pulse" role="alert">
                                <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 bg-gradient-to-br from-green-400 to-emerald-500 p-2 rounded-full">
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-600 text-base mb-0.5">Pesan Berhasil</h3>
                                    <p class="text-green-600 text-sm"><?php echo $_SESSION['produk_masuk_sukses']; ?></p>
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
                        unset($_SESSION['produk_masuk_sukses']);
                        } 
                        ?>
                      <div class="flex flex-col sm:flex-row gap-4 mb-6">
                          <div class="flex-1">
                              <div class="relative animate-slide-in-left">
                                  <input type="text" id="searchInput" class="w-full pl-10 pr-4 py-2 bg-pink-200 border border-pink-300 rounded-lg focus:ring-2 focus:ring-pink-400 focus:border-pink-400 focus:outline-none text-sm sm:text-base" placeholder="Cari penerimaan...">
                                  <svg class="absolute left-3 top-2.5 w-5 h-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                  </svg>
                              </div>
                          </div>
                          <select id="itemsPerPage" class="w-full sm:w-auto px-4 py-2 bg-pink-200 border border-pink-300 rounded-lg focus:ring-2 focus:ring-pink-400 focus:border-pink-400 animate-slide-in-right text-sm sm:text-base">
                              <option value="10">10 per halaman</option>
                              <option value="50">50 per halaman</option>
                              <option value="100">100 per halaman</option>
                              <option value="all">Semua Data</option>
                          </select>
                      </div>

                      <div class="overflow-x-auto rounded-lg border border-gray-200 animate-scale-in">
                          <table id="penggunaTable" class="min-w-full">
                              <thead>
                                  <tr class="bg-pink-200">
                                      <th class="px-4 py-3 border-b border-r border-rose-300 text-center text-xs sm:text-sm font-semibold text-indigo-500 cursor-pointer" data-column="id_penerimaan_produk">
                                          <div class="flex items-center justify-center gap-1">
                                              <span>No</span>
                                              <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-4 py-3 border-b border-r border-rose-300 text-center text-xs sm:text-sm font-semibold text-indigo-500 cursor-pointer" data-column="tanggal">
                                          <div class="flex items-center justify-center gap-1">
                                              <span>Tanggal</span>
                                              <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-4 py-3 border-b border-r border-rose-300 text-center text-xs sm:text-sm font-semibold text-indigo-500 cursor-pointer" data-column="keterangan">
                                          <div class="flex items-center justify-center gap-1">
                                              <span>Keterangan</span>
                                              <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-4 py-3 border-b border-r border-rose-300 text-center text-xs sm:text-sm font-semibold text-indigo-500" colspan="4">
                                          <div class="flex items-center justify-center gap-1">
                                              <span>Detail Produk</span>
                                          </div>
                                      </th>
                                      <th class="px-4 py-3 border-b border-r border-rose-300 text-center text-xs sm:text-sm font-semibold text-indigo-500 cursor-pointer" data-column="status">
                                          <div class="flex items-center justify-center gap-1">
                                              <span>Status</span>
                                              <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-4 py-3 border-b border-rose-300 text-center text-xs sm:text-sm font-semibold text-indigo-500">Aksi</th>
                                  </tr>
                              </thead>                              
                              <tbody class="divide-y divide-pink-100">
                              </tbody>
                          </table>
                      </div>

                      <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row items-center justify-between gap-4 animate-slide-in-up">
                          <div class="text-xs sm:text-sm text-gray-600 text-center sm:text-left" id="paginationInfo"></div>
                          <div class="flex items-center gap-2" id="paginationButtons">
                              <button id="prevBtn" class="px-3 sm:px-4 py-1 sm:py-2 bg-pink-200 hover:bg-pink-300 rounded-lg flex items-center gap-1 transition-colors animate-slide-in-left text-xs sm:text-sm">
                                  <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                  </svg>
                                  <span>Sebelumnya</span>
                              </button>
                              <div id="pageNumbers" class="flex gap-1"></div>
                              <button id="nextBtn" class="px-3 sm:px-4 py-1 sm:py-2 bg-pink-200 hover:bg-pink-300 rounded-lg flex items-center gap-1 transition-colors animate-slide-in-right text-xs sm:text-sm">
                                  <span>Selanjutnya</span>
                                  <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                  </svg>
                              </button>
                          </div>
                      </div>
                  </div>
              </div>
          </main>
                   
          <script>
          let tableData = [];
          let currentPage = 1;
          let itemsPerPage = 10;
          let sortColumn = 'id_penerimaan_produk';
          let sortDirection = 'asc';
          
          async function fetchData() {
              try {
                  const response = await fetch('get_produk_masuk.php');
                  const data = await response.json();
                  if (Array.isArray(data)) {
                      tableData = data;
                      renderTable();
                  } else {
                      console.error('Data tidak valid:', data);
                  }
              } catch (error) {
                  console.error('Error fetching data:', error);
              }
          }
          
          function initTable() {
              document.querySelectorAll('th[data-column]').forEach(header => {
                  header.addEventListener('click', () => {
                      const column = header.dataset.column;
                      if (sortColumn === column) {
                          sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
                      } else {
                          sortColumn = column;
                          sortDirection = 'asc';
                      }
                      renderTable();
                  });
              });
          
              document.getElementById('searchInput').addEventListener('input', (e) => {
                  const searchTerm = e.target.value.toLowerCase();
                  filterTable(searchTerm);
              });
          
              document.getElementById('itemsPerPage').addEventListener('change', (e) => {
                  itemsPerPage = e.target.value === 'all' ? tableData.length : parseInt(e.target.value);
                  currentPage = 1;
                  renderTable();
              });
          
              document.getElementById('prevBtn').addEventListener('click', () => {
                  if (currentPage > 1) {
                      currentPage--;
                      renderTable();
                  }
              });
          
              document.getElementById('nextBtn').addEventListener('click', () => {
                  const totalPages = Math.ceil(tableData.length / itemsPerPage);
                  if (currentPage < totalPages) {
                      currentPage++;
                      renderTable();
                  }
              });
          }
          
          function filterTable(searchTerm) {
              const filteredData = tableData.filter(item => 
                  Object.values(item).some(value => 
                      value.toString().toLowerCase().includes(searchTerm)
                  )
              );
              currentPage = 1;
              renderTable(filteredData);
          }
          
          function sortData(data) {
              return [...data].sort((a, b) => {
                  let valueA = a[sortColumn];
                  let valueB = b[sortColumn];
                  
                  if (typeof valueA === 'string') {
                      valueA = valueA.toLowerCase();
                      valueB = valueB.toLowerCase();
                  }
                  
                  if (sortDirection === 'asc') {
                      return valueA > valueB ? 1 : -1;
                  } else {
                      return valueA < valueB ? 1 : -1;
                  }
              });
          }
          
          function renderTable(data = tableData) {
              // Group data by id_penerimaan_produk and combine product info
              const groupedData = data.reduce((acc, curr) => {
                  if (!acc[curr.id_penerimaan_produk]) {
                      acc[curr.id_penerimaan_produk] = {
                          ...curr,
                          products: [{
                              kode_produk: curr.kode_produk,
                              nama_produk: curr.nama_produk,
                              harga_beli: curr.harga_beli,
                              jumlah: curr.jumlah
                          }]
                      };
                  } else {
                      acc[curr.id_penerimaan_produk].products.push({
                          kode_produk: curr.kode_produk,
                          nama_produk: curr.nama_produk,
                          harga_beli: curr.harga_beli,
                          jumlah: curr.jumlah
                      });
                  }
                  return acc;
              }, {});
              
              // Convert back to array
              const uniqueData = Object.values(groupedData);
              
              const sortedData = sortData(uniqueData);
              const start = (currentPage - 1) * itemsPerPage;
              const paginatedData = sortedData.slice(start, start + itemsPerPage);
              
              const tbody = document.querySelector('tbody');
              tbody.innerHTML = '';
              
              paginatedData.forEach((row, index) => {
                  const tr = document.createElement('tr');
                  tr.className = 'bg-white hover:bg-gray-100';
                  
                  let productsHtml = row.products.map(product => `
                      ${product.kode_produk} - ${product.nama_produk} (${product.jumlah} @ Rp${product.harga_beli})
                  `).join('<br>');
                  
                  tr.innerHTML = `
                      <td class="px-4 py-3 border-b border-r border-rose-300">${start + index + 1}</td>
                      <td class="px-4 py-3 border-b border-r border-rose-300">${row.tanggal}</td>
                      <td class="px-4 py-3 border-b border-r border-rose-300">${row.keterangan}</td>
                      <td class="px-4 py-3 border-b border-r border-rose-300" colspan="4">${productsHtml}</td>
                      <td class="px-4 py-3 border-b border-r border-rose-300">${row.status_dihapus}</td>
                      <td class="px-4 py-3 border-b border-rose-300">
                          <div class="flex justify-center space-x-3">
                              <button onclick="lihatPenerimaan(${row.id_penerimaan_produk})" class="text-fuchsia-300 hover:text-fuchsia-300 p-1.5 rounded-full hover:bg-pink-200 group" title="Lihat Detail Produk Masuk">
                                  <div class="absolute z-10 hidden group-hover:block bg-gray-900 text-white text-xs rounded-lg py-1 px-3 -mt-14 -ml-16">
                                      Lihat Detail Produk Masuk
                                  </div>
                                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                  </svg>
                              </button>
                              ${row.status_dihapus == 'Selesai' ? `
                              <button onclick="editPenerimaan(${row.id_penerimaan_produk})" class="text-pink-400 hover:text-pink-600 p-1.5 rounded-full hover:bg-pink-200 group" title="Edit Data Produk Masuk">
                                  <div class="absolute z-10 hidden group-hover:block bg-gray-900 text-white text-xs rounded-lg py-1 px-3 -mt-14 -ml-16">
                                      Edit Data Produk Masuk
                                  </div>
                                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                  </svg>
                              </button>
                              <button onclick="hapusPenerimaan(${row.id_penerimaan_produk})" class="text-rose-500 hover:text-rose-500 p-1.5 rounded-full hover:bg-pink-200 group" title="Batalkan Data Produk Masuk">
                                  <div class="absolute z-10 hidden group-hover:block bg-gray-900 text-white text-xs rounded-lg py-1 px-3 -mt-14 -ml-16">
                                      Batalkan Data Produk Masuk
                                  </div>
                                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                  </svg>
                              </button>
                              ` : ''}
                          </div>                      
                          </td>
                  `;
                  tbody.appendChild(tr);
              });

              updatePaginationInfo(sortedData.length, start);
              updatePaginationButtons(sortedData.length);
          }    
                
          function updatePaginationInfo(totalItems, start) {
              const end = Math.min(start + itemsPerPage, totalItems);
              document.getElementById('paginationInfo').textContent = 
                  `Menampilkan ${totalItems > 0 ? start + 1 : 0}-${end} dari ${totalItems} data`;
          }

          function updatePaginationButtons(totalItems) {
              const totalPages = Math.ceil(totalItems / itemsPerPage);
              const pageNumbers = document.getElementById('pageNumbers');
              pageNumbers.innerHTML = '';

              const maxButtons = 3;
              let startPage = Math.max(1, currentPage - Math.floor(maxButtons / 2));
              let endPage = Math.min(totalPages, startPage + maxButtons - 1);

              if (endPage - startPage + 1 < maxButtons) {
                  startPage = Math.max(1, endPage - maxButtons + 1);
              }

              for (let i = startPage; i <= endPage; i++) {
                  const button = document.createElement('button');
                  button.className = `px-3 py-1 border rounded ${i === currentPage ? 'bg-pink-400 text-white' : 'hover:bg-pink-200'}`;
                  button.textContent = i;
                  button.addEventListener('click', () => {
                      currentPage = i;
                      renderTable();
                  });
                  pageNumbers.appendChild(button);
              }

              document.getElementById('prevBtn').disabled = currentPage === 1;
              document.getElementById('nextBtn').disabled = currentPage === totalPages;
          }

          function lihatPenerimaan(id) {
              window.location.href = `detail.php?id=${id}`;
          }

          function editPenerimaan(id) {
              window.location.href = `edit.php?id=${id}`;
          }

          async function hapusPenerimaan(id) {
              if (confirm('Apakah Anda yakin ingin menghapus data penerimaan ini?')) {
                  try {
                      const response = await fetch(`batal.php?id=${id}`, {
                          method: 'DELETE'
                      });
                      const data = await response.json();
                      
                      if (data.success) {
                          alert(data.message);
                          await fetchData();
                      } else {
                          alert(data.message || 'Gagal menghapus data penerimaan');
                      }
                  } catch (error) {
                      console.error('Error:', error);
                      alert('Terjadi kesalahan saat menghapus data penerimaan');
                  }
              }
          }

          document.addEventListener('DOMContentLoaded', () => {
              initTable();
              fetchData();
          });        
        </script>
<?php include ('../../layout/footer.php'); ?>