<?php

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
?>

<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="src/output.css" rel="stylesheet">
  <title>404 Not Found | Data Tidak Ditemukan</title>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
  <div class="max-w-2xl w-full bg-white rounded-lg shadow-xl overflow-hidden">
    <div class="bg-pink-600 p-8 text-white text-center">
      <h1 class="text-6xl font-bold mb-4">404</h1>
      <h2 class="text-2xl font-semibold mb-2">Data Tidak Ditemukan</h2>
      <div class="w-16 h-1 bg-pink-300 mx-auto my-4"></div>
    </div>
    
    <div class="bg-pink-200 p-8">
      <div class="text-center">
        <p class="text-gray-600 text-lg mb-6">Maaf, data atau halaman yang Anda cari tidak dapat ditemukan.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
          <a href="<?= base_url('dashboard.php') ?>" class="px-6 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-500 transition-colors duration-200 font-medium shadow-md">
            Kembali ke Beranda
          </a>
          <a href="javascript:history.back()" class="px-6 py-3 bg-rose-500 text-white rounded-lg hover:bg-rose-400 transition-colors duration-200 font-medium shadow-md">
            Kembali
          </a>
        </div>
      </div>
    </div>
    
    <div class="bg-pink-100 p-4 border-t border-pink-200">
      <p class="text-center text-indigo-500 text-sm">
        Jika Anda merasa ini adalah kesalahan, silakan hubungi administrator sistem
      </p>
    </div>
  </div>
</body>
</html>