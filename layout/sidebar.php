<!-- Sidebar Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/30 z-40 backdrop-blur-sm lg:hidden hidden animate-fade-in" onclick="closeSidebarMobile()"></div>

<!-- Sidebar -->
<div id="sidebar" class="fixed inset-y-0 left-0 bg-white/95 backdrop-blur-xl transition-all duration-300 transform lg:translate-x-0 -translate-x-full sidebar-expanded z-50 flex flex-col w-[240px] sm:w-[280px] lg:w-[240px] animate-slide-in-left">
    <div class="p-4 sm:p-5 flex-shrink-0 bg-gradient-to-r from-pink-400 to-rose-300 rounded-br-2xl animate-slide-in-down">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-white sidebar-item-text animate-slide-in-left" id="adminTitle">Admin Inventaris</h2>
            <button id="sidebarToggle" class="p-2 rounded-xl hover:bg-white/20 text-white transition-all duration-300 hidden lg:block animate-scale-in">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>            
    </div>
    <div class="flex-1 overflow-y-auto scrollbar-hide bg-transparent px-3 sm:px-4">
        <nav class="py-4 sm:py-5">
            <ul class="space-y-2 sm:space-y-3">
                <!-- Dashboard -->
                <li>
                    <a href="<?= base_url('dashboard.php') ?>" onclick="handleLinkClick(event)" class="flex items-center p-3 rounded-xl transition-all duration-200 <?= (strpos($_SERVER['REQUEST_URI'], 'dashboard.php') !== false) ? 'bg-gradient-to-r from-pink-200 to-rose-300 group bg-white/60 backdrop-blur-xl shadow-md shadow-pink-100/20' : 'hover:bg-gradient-to-r hover:from-pink-200 hover:to-rose-300 group bg-white/60 backdrop-blur-xl shadow-md shadow-pink-100/20' ?> animate-slide-in-left">
                        <div class="p-2 rounded-lg bg-gradient-to-br from-pink-400 to-rose-500">
                            <svg class="text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                        </div>
                        <span class="ml-3 text-sm text-indigo-500 <?= (strpos($_SERVER['REQUEST_URI'], 'dashboard.php') !== false) ? 'text-pink-700' : 'group-hover:text-pink-700' ?> font-medium sidebar-item-text">Dashboard</span>
                    </a>
                </li>     
                <?php if ($sesi_role_pengguna == 'Admin' or $sesi_role_pengguna == 'Pemilik'){ ?>
                <!-- Kelola Produk -->
                <li class="relative">
                    <button onclick="toggleSubmenu('menuProduk')" class="w-full flex items-center justify-between p-3 rounded-xl transition-all duration-200 <?= (strpos($_SERVER['REQUEST_URI'], '/modul/produk/') !== false || strpos($_SERVER['REQUEST_URI'], '/modul/satuan/') !== false || strpos($_SERVER['REQUEST_URI'], '/modul/kategori/') !== false) ? 'bg-gradient-to-r from-pink-200 to-rose-300 group bg-white/60 backdrop-blur-xl shadow-md shadow-pink-100/20' : 'hover:bg-gradient-to-r hover:from-pink-200 hover:to-rose-300 group bg-white/60 backdrop-blur-xl shadow-md shadow-pink-100/20' ?> animate-slide-in-left">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-gradient-to-br from-pink-400 to-rose-500">
                                <svg class="text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4zm0 6a2 2 0 100 4h12a2 2 0 100-4H4zm0 6a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                                </svg>
                            </div>
                            <span class="ml-3 text-sm text-indigo-500 <?= (strpos($_SERVER['REQUEST_URI'], '/modul/produk/') !== false || strpos($_SERVER['REQUEST_URI'], '/modul/satuan/') !== false || strpos($_SERVER['REQUEST_URI'], '/modul/kategori/') !== false) ? 'text-pink-700' : 'group-hover:text-pink-700' ?> font-medium sidebar-item-text">Kelola Produk</span>
                        </div>
                        <svg id="menuProdukArrow" class="text-pink-400 group-hover:text-pink-600 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <ul id="menuProduk" class="<?= (strpos($_SERVER['REQUEST_URI'], '/modul/produk/') !== false || strpos($_SERVER['REQUEST_URI'], '/modul/satuan/') !== false || strpos($_SERVER['REQUEST_URI'], '/modul/kategori/') !== false) ? '' : 'hidden' ?> pl-10 mt-2 space-y-2">
                        <li>
                            <a href="<?= base_url('modul/produk/index.php') ?>" onclick="handleLinkClick(event)" class="flex items-center p-2 rounded-lg transition-all duration-200 <?= (strpos($_SERVER['REQUEST_URI'], '/modul/produk/') !== false) ? 'bg-gradient-to-r from-pink-200 to-rose-300 text-sm text-indigo-500 text-pink-600 bg-white/40 backdrop-blur-xl' : 'hover:bg-gradient-to-r hover:from-pink-200 hover:to-rose-300 text-sm text-indigo-500 hover:text-pink-600 bg-white/40 backdrop-blur-xl' ?> animate-slide-in-right">
                                <svg class="mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4zm0 6a2 2 0 100 4h12a2 2 0 100-4H4zm0 6a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                                </svg>                                
                                <span class="sidebar-item-text">Data Produk</span>                                                        
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('modul/satuan/index.php') ?>" onclick="handleLinkClick(event)" class="flex items-center p-2 rounded-lg transition-all duration-200 <?= (strpos($_SERVER['REQUEST_URI'], '/modul/satuan/') !== false) ? 'bg-gradient-to-r from-pink-200 to-rose-300 text-sm text-indigo-500 text-pink-600 bg-white/40 backdrop-blur-xl' : 'hover:bg-gradient-to-r hover:from-pink-200 hover:to-rose-300 text-sm text-indigo-500 hover:text-pink-600 bg-white/40 backdrop-blur-xl' ?> animate-slide-in-right">
                                <svg class="mr-2" width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path d="M4.70711 12.7071L8 16L11.2929 12.7071L8 9.41421L4.70711 12.7071Z" fill="currentColor"/>
                                        <path d="M3.29289 11.2929L6.58579 8L3.29289 4.70711L0 8L3.29289 11.2929Z" fill="currentColor"/>
                                        <path d="M4.70711 3.29289L8 0L11.2929 3.29289L8 6.58579L4.70711 3.29289Z" fill="currentColor"/>
                                        <path d="M12.7071 4.70711L9.41421 8L12.7071 11.2929L16 8L12.7071 4.70711Z" fill="currentColor"/>
                                    </g>
                                </svg>                                
                                <span class="sidebar-item-text">Data Satuan</span>                            
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('modul/kategori/index.php') ?>" onclick="handleLinkClick(event)" class="flex items-center p-2 rounded-lg transition-all duration-200 <?= (strpos($_SERVER['REQUEST_URI'], '/modul/kategori/') !== false) ? 'bg-gradient-to-r from-pink-200 to-rose-300 text-sm text-indigo-500 text-pink-600 bg-white/40 backdrop-blur-xl' : 'hover:bg-gradient-to-r hover:from-pink-200 hover:to-rose-300 text-sm text-indigo-500 hover:text-pink-600 bg-white/40 backdrop-blur-xl' ?> animate-slide-in-right">
                                <svg class="mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM13 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM13 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z"/>
                                </svg>                                
                                <span class="sidebar-item-text">Data Kategori</span>
                            </a>
                        </li>
                    </ul>                      
                </li>    
                <!-- Kelola Produk Masuk -->
                <li>
                    <a href="<?= base_url('modul/produk_masuk/index.php') ?>" onclick="handleLinkClick(event)" class="flex items-center p-3 rounded-xl transition-all duration-200 <?= (strpos($_SERVER['REQUEST_URI'], '/modul/produk_masuk/') !== false) ? 'bg-gradient-to-r from-pink-200 to-rose-300 group bg-white/60 backdrop-blur-xl shadow-md shadow-pink-100/20' : 'hover:bg-gradient-to-r hover:from-pink-200 hover:to-rose-300 group bg-white/60 backdrop-blur-xl shadow-md shadow-pink-100/20' ?> animate-slide-in-left">
                        <div class="p-2 rounded-lg bg-gradient-to-br from-pink-400 to-rose-500">
                            <svg class="text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                            </svg>  
                        </div>
                        <span class="ml-3 text-sm text-indigo-500  <?= (strpos($_SERVER['REQUEST_URI'], '/modul/produk_masuk/') !== false) ? 'text-pink-700' : 'group-hover:text-pink-700' ?> font-medium sidebar-item-text">Data Produk Masuk</span>
                    </a>
                </li>
                <?php } ?>
                <?php if ($sesi_role_pengguna == 'Admin' or $sesi_role_pengguna == 'Kasir'){ ?>
                <!-- Kelola Produk Keluar -->
                <li>
                    <a href="<?= base_url('modul/produk_keluar/index.php') ?>" onclick="handleLinkClick(event)" class="flex items-center p-3 rounded-xl transition-all duration-200 <?= (strpos($_SERVER['REQUEST_URI'], '/modul/produk_keluar/') !== false) ? 'bg-gradient-to-r from-pink-200 to-rose-300 group bg-white/60 backdrop-blur-xl shadow-md shadow-pink-100/20' : 'hover:bg-gradient-to-r hover:from-pink-200 hover:to-rose-300 group bg-white/60 backdrop-blur-xl shadow-md shadow-pink-100/20' ?> animate-slide-in-left">
                        <div class="p-2 rounded-lg bg-gradient-to-br from-pink-400 to-rose-500">
                            <svg class="text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                            </svg>                                                  
                        </div>
                        <span class="ml-3 text-sm text-indigo-500  <?= (strpos($_SERVER['REQUEST_URI'], '/modul/produk_keluar/') !== false) ? 'text-pink-700' : 'group-hover:text-pink-700' ?> font-medium sidebar-item-text">Data Produk Keluar</span>
                    </a> 
                </li>
                <?php } ?>
                <?php if ($sesi_role_pengguna == 'Admin' or $sesi_role_pengguna == 'Pemilik'){ ?>
                <!-- Kelola Laporan -->
                <li class="relative">
                    <button onclick="toggleSubmenu('menuLaporan')" class="w-full flex items-center justify-between p-3 rounded-xl transition-all duration-200 <?= (strpos($_SERVER['REQUEST_URI'], '/modul/laporan_stok_produk/') !== false || strpos($_SERVER['REQUEST_URI'], '/modul/laporan_produk_keluar/') !== false || strpos($_SERVER['REQUEST_URI'], '/modul/laporan_produk_masuk/') !== false) ? 'bg-gradient-to-r from-pink-200 to-rose-300 group bg-white/60 backdrop-blur-xl shadow-md shadow-pink-100/20' : 'hover:bg-gradient-to-r hover:from-pink-200 hover:to-rose-300 group bg-white/60 backdrop-blur-xl shadow-md shadow-pink-100/20' ?> animate-slide-in-left">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-gradient-to-br from-pink-400 to-rose-500">
                                <svg class="text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                                </svg>
                            </div>
                            <span class="ml-3 text-sm text-indigo-500 <?= (strpos($_SERVER['REQUEST_URI'], '/modul/laporan_stok_produk/') !== false || strpos($_SERVER['REQUEST_URI'], '/modul/laporan_produk_keluar/') !== false || strpos($_SERVER['REQUEST_URI'], '/modul/laporan_produk_masuk/') !== false) ? 'text-pink-700' : 'group-hover:text-pink-700' ?> font-medium sidebar-item-text">Kelola Laporan</span>
                        </div>
                        <svg id="menuLaporanArrow" class="text-pink-400 group-hover:text-pink-600 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <ul id="menuLaporan" class="<?= (strpos($_SERVER['REQUEST_URI'], '/modul/laporan_stok_produk/') !== false || strpos($_SERVER['REQUEST_URI'], '/modul/laporan_produk_keluar/') !== false || strpos($_SERVER['REQUEST_URI'], '/modul/laporan_produk_masuk/') !== false) ? '' : 'hidden' ?> pl-10 mt-2 space-y-2">
                        <li>
                            <a href="<?= base_url('modul/laporan_stok_produk/index.php') ?>" onclick="handleLinkClick(event)" class="flex items-center p-2 rounded-lg transition-all duration-200 <?= (strpos($_SERVER['REQUEST_URI'], '/modul/laporan_stok_produk/') !== false) ? 'bg-gradient-to-r from-pink-200 to-rose-300 text-sm text-indigo-500 text-pink-600 bg-white/40 backdrop-blur-xl' : 'hover:bg-gradient-to-r hover:from-pink-200 hover:to-rose-300 text-sm text-indigo-500 hover:text-pink-600 bg-white/40 backdrop-blur-xl' ?> animate-slide-in-right">
                                <svg class="mr-2" width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path d="M14 1H2C1.44772 1 1 1.44772 1 2V14C1 14.5523 1.44772 15 2 15H14C14.5523 15 15 14.5523 15 14V2C15 1.44772 14.5523 1 14 1Z" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M4 8H6V12H4V8Z" fill="currentColor"/>
                                        <path d="M7 5H9V12H7V5Z" fill="currentColor"/>
                                        <path d="M10 7H12V12H10V7Z" fill="currentColor"/>
                                    </g>
                                </svg>                                
                                <span class="sidebar-item-text">Laporan Stok Produk</span>                                                        
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('modul/laporan_produk_masuk/index.php') ?>" onclick="handleLinkClick(event)" class="flex items-center p-2 rounded-lg transition-all duration-200 <?= (strpos($_SERVER['REQUEST_URI'], '/modul/laporan_produk_masuk/') !== false) ? 'bg-gradient-to-r from-pink-200 to-rose-300 text-sm text-indigo-500 text-pink-600 bg-white/40 backdrop-blur-xl' : 'hover:bg-gradient-to-r hover:from-pink-200 hover:to-rose-300 text-sm text-indigo-500 hover:text-pink-600 bg-white/40 backdrop-blur-xl' ?> animate-slide-in-right">
                                <svg class="mr-2" width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path d="M14 1H2C1.44772 1 1 1.44772 1 2V14C1 14.5523 1.44772 15 2 15H14C14.5523 15 15 14.5523 15 14V2C15 1.44772 14.5523 1 14 1Z" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M5 8L8 11L11 8" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M8 4V11" stroke="currentColor" stroke-width="1.5"/>
                                    </g>
                                </svg>                                
                                <span class="sidebar-item-text">Laporan Produk Masuk</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('modul/laporan_produk_keluar/index.php') ?>" onclick="handleLinkClick(event)" class="flex items-center p-2 rounded-lg transition-all duration-200 <?= (strpos($_SERVER['REQUEST_URI'], '/modul/laporan_produk_keluar/') !== false) ? 'bg-gradient-to-r from-pink-200 to-rose-300 text-sm text-indigo-500 text-pink-600 bg-white/40 backdrop-blur-xl' : 'hover:bg-gradient-to-r hover:from-pink-200 hover:to-rose-300 text-sm text-indigo-500 hover:text-pink-600 bg-white/40 backdrop-blur-xl' ?> animate-slide-in-right">
                                <svg class="mr-2" width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path d="M14 1H2C1.44772 1 1 1.44772 1 2V14C1 14.5523 1.44772 15 2 15H14C14.5523 15 15 14.5523 15 14V2C15 1.44772 14.5523 1 14 1Z" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M5 8L8 5L11 8" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M8 5V12" stroke="currentColor" stroke-width="1.5"/>
                                    </g>
                                </svg>                                
                                <span class="sidebar-item-text">Laporan Produk Keluar</span>                            
                            </a>
                        </li>
                    </ul>                      
                </li>   
                <!-- Pengguna -->
                <li>
                    <a href="<?= base_url('modul/pengguna/index.php') ?>" onclick="handleLinkClick(event)" class="flex items-center p-3 rounded-xl transition-all duration-200 <?= (strpos($_SERVER['REQUEST_URI'], 'modul/pengguna') !== false) ? 'bg-gradient-to-r from-pink-200 to-rose-300 group bg-white/60 backdrop-blur-xl shadow-md shadow-pink-100/20' : 'hover:bg-gradient-to-r hover:from-pink-200 hover:to-rose-300 group bg-white/60 backdrop-blur-xl shadow-md shadow-pink-100/20' ?> animate-slide-in-left">
                        <div class="p-2 rounded-lg bg-gradient-to-br from-pink-400 to-rose-500">
                            <svg class="text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="ml-3 text-sm text-indigo-500  <?= (strpos($_SERVER['REQUEST_URI'], 'modul/pengguna') !== false) ? 'text-pink-700' : 'group-hover:text-pink-700' ?> font-medium sidebar-item-text">Data Pengguna</span>
                    </a>
                </li>     
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>

<!-- Main Content Container -->
<div class="flex-1 flex flex-col min-h-screen transition-all duration-300 lg:ml-[240px] animate-slide-in-right" id="mainContainer">
    <!-- Header -->
    <header class="bg-gray-100/95 backdrop-blur-xl border-pink-200 sticky top-0 z-40 shadow-lg shadow-pink-200/30 animate-slide-in-down">
        <div class="flex items-center justify-between px-4 sm:px-6 py-3 md:py-4 lg:py-4">
            <div class="flex items-center space-x-3">
                <button id="menuBtn" class="lg:hidden p-2 rounded-lg text-pink-600 hover:bg-pink-200/50 transition-all duration-300 animate-scale-in">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <a href="<?= base_url('dashboard.php') ?>" class="flex items-center space-x-0.5 hover:scale-105 transition-transform duration-300 animate-bounce-in">
                    <span class="text-lg sm:text-xl md:text-2xl font-extrabold tracking-tight bg-gradient-to-r from-pink-500 via-rose-600 to-fuchsia-400 bg-clip-text text-transparent">TOKO</span>
                    <span class="text-lg sm:text-xl md:text-2xl font-extrabold tracking-tight bg-gradient-to-r from-fuchsia-400 via-rose-600 to-pink-500 bg-clip-text text-transparent">RICKY</span>
                </a>            
            </div>
            
            <div class="flex items-center gap-2 md:gap-3 lg:gap-4">
                <!-- Notification Button -->
                <div class="relative mr-2">
                    <?php
                    // Query untuk mendapatkan jumlah produk dengan stok di bawah minimum dan stok 0
                    $query_warning = "SELECT COUNT(*) as total_warning FROM produk WHERE stok <= stok_minimum AND stok > 0 AND status_dihapus = 0";
                    $query_danger = "SELECT COUNT(*) as total_danger FROM produk WHERE stok = 0 AND status_dihapus = 0";
                    
                    $result_warning = mysqli_query($koneksi, $query_warning);
                    $result_danger = mysqli_query($koneksi, $query_danger);
                    
                    $row_warning = mysqli_fetch_assoc($result_warning);
                    $row_danger = mysqli_fetch_assoc($result_danger);
                    
                    $total_warning = $row_warning['total_warning'];
                    $total_danger = $row_danger['total_danger'];
                    $total_notifikasi = $total_warning + $total_danger;
                    ?>
                    <button onclick="toggleNotificationMenu()" class="p-1.5 sm:p-2 rounded-lg text-pink-600 hover:bg-pink-200/50 transition-all duration-300 animate-scale-in relative">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                        <?php if ($total_notifikasi > 0): ?>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full"><?= $total_notifikasi ?></span>
                        <?php endif; ?>
                    </button>
                    <div id="notificationMenu" class="hidden absolute right-0 mt-2 w-72 sm:w-80 bg-white/95 backdrop-blur-xl rounded-lg shadow-md shadow-fuchsia-300/20 border border-pink-200 py-1.5 transform transition-all duration-300 ease-in-out animate-scale-in">
                        <div class="px-3 py-2 border-b border-pink-100">
                            <p class="text-sm font-medium text-gray-700">Notifikasi Stok</p>
                            <p class="text-xs text-gray-500"><?= $total_notifikasi ?> produk perlu perhatian</p>
                        </div>
                        <div class="py-1 max-h-[300px] overflow-y-auto">
                            <?php
                            // Produk dengan stok 0
                            $query_danger_produk = "SELECT p.*, kp.nama_kategori, sp.nama_satuan 
                                           FROM produk p 
                                           JOIN kategori_produk kp ON p.id_kategori_produk = kp.id_kategori_produk 
                                           JOIN satuan_produk sp ON p.id_satuan_produk = sp.id_satuan_produk 
                                           WHERE p.stok = 0 AND p.status_dihapus = 0 
                                           ORDER BY p.stok ASC";
                            $result_danger_produk = mysqli_query($koneksi, $query_danger_produk);
                            while($produk = mysqli_fetch_assoc($result_danger_produk)):
                            ?>
                            <a href="<?= base_url('modul/produk/index.php') ?>" class="flex items-center px-3 py-2 hover:bg-gradient-to-r hover:from-pink-50 hover:to-rose-50">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-700"><?= $produk['nama_produk'] ?> (Stok Habis!)</p>
                                    <p class="text-xs text-gray-500">Stok: <?= $produk['stok'] ?> <?= $produk['nama_satuan'] ?> (Min: <?= $produk['stok_minimum'] ?>)</p>
                                    <p class="text-xs text-gray-400"><?= $produk['kode_produk'] ?> - <?= $produk['nama_kategori'] ?></p>
                                </div>
                            </a>
                            <?php endwhile; ?>

                            <?php
                            // Produk dengan stok di bawah minimum
                            $query_warning_produk = "SELECT p.*, kp.nama_kategori, sp.nama_satuan 
                                           FROM produk p 
                                           JOIN kategori_produk kp ON p.id_kategori_produk = kp.id_kategori_produk 
                                           JOIN satuan_produk sp ON p.id_satuan_produk = sp.id_satuan_produk 
                                           WHERE p.stok <= p.stok_minimum AND p.stok > 0 AND p.status_dihapus = 0 
                                           ORDER BY p.stok ASC";
                            $result_warning_produk = mysqli_query($koneksi, $query_warning_produk);
                            while($produk = mysqli_fetch_assoc($result_warning_produk)):
                            ?>
                            <a href="<?= base_url('modul/produk/index.php') ?>" class="flex items-center px-3 py-2 hover:bg-gradient-to-r hover:from-pink-50 hover:to-rose-50">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-700"><?= $produk['nama_produk'] ?></p>
                                    <p class="text-xs text-gray-500">Stok: <?= $produk['stok'] ?> <?= $produk['nama_satuan'] ?> (Min: <?= $produk['stok_minimum'] ?>)</p>
                                    <p class="text-xs text-gray-400"><?= $produk['kode_produk'] ?> - <?= $produk['nama_kategori'] ?></p>
                                </div>
                            </a>
                            <?php endwhile; ?>
                        </div>
                        <div class="border-t border-pink-100 px-3 py-2">
                            <a href="<?= base_url('modul/produk/index.php') ?>" class="text-sm text-pink-600 hover:text-pink-700">Lihat semua produk</a>
                        </div>
                    </div>
                </div>
                <script>
                    function toggleNotificationMenu() {
                    const menu = document.getElementById('notificationMenu');
                    const isHidden = menu.classList.contains('hidden');
    
                    // Hide all other menus first
                    const allMenus = document.querySelectorAll('.absolute.right-0.mt-2');
                    allMenus.forEach(m => m.classList.add('hidden'));
    
                    // Toggle the notification menu
                    if (isHidden) {
                        menu.classList.remove('hidden');
                        menu.classList.add('animate-scale-in');
                    } else {
                        menu.classList.add('hidden');
                        menu.classList.remove('animate-scale-in');
                    }

                    // Close menu when clicking outside
                    const closeMenu = (e) => {
                        if (!menu.contains(e.target) && !e.target.closest('button')) {
                            menu.classList.add('hidden');
                            menu.classList.remove('animate-scale-in');
                            document.removeEventListener('click', closeMenu);
                        }
                    };

                    if (isHidden) {
                        setTimeout(() => {
                            document.addEventListener('click', closeMenu);
                        }, 100);
                    }
                }

                // Close menu when pressing Escape key
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        const menu = document.getElementById('notificationMenu');
                        menu.classList.add('hidden');
                        menu.classList.remove('animate-scale-in');
                    }
                });
                </script>

            
                <div class="relative">
                    <button onclick="toggleProfileMenu()" class="flex items-center space-x-2 bg-gradient-to-r from-pink-100 via-rose-200 to-fuchsia-200 px-2 sm:px-3 py-1.5 sm:py-2 rounded-lg hover:from-pink-300 hover:via-rose-300 hover:to-fuchsia-200 transition-all duration-300 group shadow-sm hover:shadow-md animate-scale-in">
                        <div class="p-1 sm:p-1.5 rounded-lg bg-gradient-to-br from-pink-500 to-rose-600 shadow-inner">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white transform group-hover:rotate-12 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="hidden sm:block text-xs md:text-sm font-medium tracking-wide text-gray-700 group-hover:text-pink-700 transition-colors duration-300"><?php echo $sesi_nama_lengkap_pengguna ?></span>
                    </button>
                    <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 sm:w-56 bg-white/95 backdrop-blur-xl rounded-lg shadow-md shadow-fuchsia-300/20 border border-pink-200 py-1.5 transform transition-all duration-300 ease-in-out animate-scale-in">
                        <div class="px-3 py-2 border-b border-pink-100">
                            <p class="text-sm font-medium text-gray-700"><?php echo $sesi_nama_lengkap_pengguna ?></p>
                            <p class="text-xs text-gray-500 truncate"><?php echo $sesi_username_pengguna ?></p>
                        </div>
                        <div class="py-1">
                            <a href="<?= base_url('modul/profil.php') ?>" class="flex items-center px-3 py-1.5 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-pink-50 hover:to-rose-50 hover:text-pink-600">
                                <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                                </svg>
                                Profil Saya
                            </a>
                            <a href="<?= base_url('modul/pengaturan.php') ?>" class="flex items-center px-3 py-1.5 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-pink-50 hover:to-rose-50 hover:text-pink-600">
                                <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                </svg>
                                Pengaturan
                            </a>
                            <a href="<?= base_url('logout.php') ?>" class="flex items-center px-3 py-1.5 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-pink-50 hover:to-rose-50 hover:text-pink-600">
                                <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm-1 4a1 1 0 112 0v3a1 1 0 11-2 0V6zm-1.293.293a1 1 0 011.414-1.414l3.5 3.5a1 1 0 010 1.414l-3.5 3.5a1 1 0 01-1.414-1.414L9.586 10H7a1 1 0 110-2h2.586L8.707 6.293z" clip-rule="evenodd"/>
                                </svg> 
                                Keluar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
