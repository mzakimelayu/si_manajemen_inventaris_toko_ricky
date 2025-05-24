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
  <title>403 Dilarang | Akses Ditolak</title>
</head>
<body class="bg-gradient-to-br from-gray-100 to-pink-200 min-h-screen flex items-center justify-center p-4">
  <div class="max-w-2xl w-full bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-[1.02] transition-transform duration-300">
    <div class="bg-pink-600 p-8 text-white text-center">
      <h1 class="text-7xl font-bold mb-4">403</h1>
      <h2 class="text-2xl font-semibold mb-2">Akses Dilarang</h2>
      <div class="w-16 h-1 bg-pink-300 mx-auto my-4"></div>
    </div>
    
    <div class="bg-pink-200 p-8">
      <div class="text-center">
        <p class="text-gray-700 text-lg mb-6">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
          <a href="<?= base_url('dashboard.php') ?>" class="px-6 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-all duration-300 font-medium shadow-md hover:shadow-lg transform hover:-translate-y-1">
            Kembali ke Beranda
          </a>
          <a href="javascript:history.back()" class="px-6 py-3 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-all duration-300 font-medium shadow-md hover:shadow-lg transform hover:-translate-y-1">
            Kembali
          </a>
        </div>
      </div>
    </div>
    
    <div class="bg-pink-100 p-4 border-t border-pink-200">
      <p class="text-center text-pink-600 text-sm">
        Jika Anda merasa ini adalah kesalahan, silakan hubungi administrator sistem
      </p>
    </div>
  </div>
</body>
</html>