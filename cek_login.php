<?php

// mulai session
session_start();

// koneksi ke database
include 'koneksi/db.php';

// redirect ke halaman dashboard
function base_url($path = '') {
    $host = $_SERVER['HTTP_HOST'];
    
    // Jika menggunakan Ngrok, paksa HTTPS
    if (strpos($host, "ngrok-free.app") !== false) {
        $protocol = "https";
    } else {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    }

    $project_folder = "/si_manajemen_inventaris_toko_ricky/"; 

    return $protocol . '://' . $host . $project_folder . $path;
}


// cek session
if (!isset($_SESSION['dataPengguna'])) {
    // simpan pesan ke session
    $_SESSION['pesan_login'] = "Sesi Anda Berakhir, Silahkan login terlebih dahulu!";
    // jika session username tidak ada, redirect ke halaman login
    header("Location: " . base_url('login.php'));
    exit();
}

// Untuk Judul Setiap Halaman
$judul_utama = $judul_halaman . " | Sistem Informasi Inventaris Toko Ricky";

$sesi_id_pengguna = $_SESSION['dataPengguna']['id_pengguna'];
$sesi_username_pengguna = $_SESSION['dataPengguna']['username'];
$sesi_nama_lengkap_pengguna = $_SESSION['dataPengguna']['nama_lengkap'];
$sesi_role_pengguna = $_SESSION['dataPengguna']['role'];

// cek hak akses berdasarkan role
if ($sesi_role_pengguna == "Kasir") {
    // jika role kasir mencoba akses halaman terlarang
    if (strpos($_SERVER['REQUEST_URI'], '/produk/') !== false || 
        strpos($_SERVER['REQUEST_URI'], '/kategori/') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/laporan_stok_produk/') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/laporan_produk_keluar/') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/laporan_produk_masuk/') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/produk_masuk/') !== false || 
        strpos($_SERVER['REQUEST_URI'], '/pengguna/') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/satuan/') !== false) {

        header("Location: " . base_url('403.php'));
        exit();
    }
}else if ($sesi_role_pengguna == "Pemilik") {
    // jika role admin mencoba akses halaman terlarang
    if (strpos($_SERVER['REQUEST_URI'], '/produk_keluar/') !== false) {

        header("Location: " . base_url('403.php'));
        exit();
    }
}

?>