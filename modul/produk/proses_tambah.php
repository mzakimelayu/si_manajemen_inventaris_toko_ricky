  <?php

  session_start();
  
  include '../../koneksi/db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $kode_produk = $_POST['kode_produk'];
        $nama_produk = $_POST['nama_produk'];
        $id_kategori_produk = $_POST['id_kategori_produk'];
        $id_satuan_produk = $_POST['id_satuan_produk'];
        $stok = $_POST['stok'];
        $stok_minimum = $_POST['stok_minimum'];
        $harga_beli = $_POST['harga_beli'];
        $harga_jual = $_POST['harga_jual'];

        try {
            // Check if kode_produk already exists
            $check_query = mysqli_prepare($koneksi, "SELECT COUNT(*) FROM produk WHERE kode_produk = ? AND status_dihapus = 0");
            mysqli_stmt_bind_param($check_query, "s", $kode_produk);
            mysqli_stmt_execute($check_query);
            mysqli_stmt_bind_result($check_query, $count);
            mysqli_stmt_fetch($check_query);
            mysqli_stmt_close($check_query);

            if($count > 0) {
                $_SESSION['produk_eror'] = 'Kode produk sudah ada!';
                header('Location: tambah.php');
                exit;            
            }

            // Insert new produk
            $query = mysqli_prepare($koneksi, "INSERT INTO produk (kode_produk, nama_produk, id_kategori_produk, id_satuan_produk, stok, stok_minimum, harga_beli, harga_jual, status_dihapus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)");
            mysqli_stmt_bind_param($query, "ssiiiiii", $kode_produk, $nama_produk, $id_kategori_produk, $id_satuan_produk, $stok, $stok_minimum, $harga_beli, $harga_jual);
            mysqli_stmt_execute($query);
          
            $_SESSION['produk_sukses'] = 'Data berhasil ditambahkan!';
            header('Location: index.php');
            exit;

        } catch(Exception $e) {
            echo "<script>
                alert('Terjadi kesalahan saat menambah data!');
                window.location.href='tambah.php';
            </script>";
        }    
    }    
?>