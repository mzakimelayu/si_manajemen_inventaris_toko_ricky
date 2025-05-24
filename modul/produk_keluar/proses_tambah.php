  <?php

  session_start();
  
  include '../../koneksi/db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tanggal = $_POST['tanggal'];
        $keterangan = $_POST['keterangan'];
        $penerima = $_POST['penerima'];
        $id_pengguna = $_SESSION['dataPengguna']['id_pengguna'];

        // Validate required fields first
        if (isset($_POST['produk']) && is_array($_POST['produk'])) {
            foreach($_POST['produk'] as $produk) {
                if (empty($produk['id_produk']) || empty($produk['kode_produk'])) {
                    $_SESSION['produk_keluar_error'] = 'Data produk tidak lengkap! Pastikan Data Produk Diisi dengan benar.';
                    header('Location: tambah.php');
                    exit;
                }
            }
        } else {
            $_SESSION['produk_keluar_error'] = 'Tidak ada data produk yang diinputkan!';
            header('Location: tambah.php');
            exit;
        }

        mysqli_begin_transaction($koneksi);

        try {
            // Insert pengeluaran header
            $query = mysqli_prepare($koneksi, "INSERT INTO pengeluaran_produk (tanggal, keterangan, penerima, id_pengguna, status_dihapus) VALUES (?, ?, ?, ?, 0)");
            mysqli_stmt_bind_param($query, "sssi", $tanggal, $keterangan, $penerima, $id_pengguna);
            mysqli_stmt_execute($query);
            
            $id_pengeluaran_produk = mysqli_insert_id($koneksi);

            // Insert pengeluaran detail and update stock
            if (isset($_POST['produk']) && is_array($_POST['produk'])) {
                foreach($_POST['produk'] as $produk) {
                    if (!empty($produk['id_produk']) && !empty($produk['jumlah'])) {
                        // Validate numeric values
                        $jumlah = intval($produk['jumlah']);
                        $harga_jual = floatval($produk['harga_jual']);

                        // Insert detail pengeluaran
                        $query_detail = mysqli_prepare($koneksi, "INSERT INTO detail_pengeluaran_produk (id_pengeluaran_produk, id_produk, jumlah, harga_jual, status_dihapus) VALUES (?, ?, ?, ?, 0)");
                        mysqli_stmt_bind_param($query_detail, "iiid", $id_pengeluaran_produk, $produk['id_produk'], $jumlah, $harga_jual);
                        mysqli_stmt_execute($query_detail);

                        // Update stock in produk table
                        $query_update_stok = mysqli_prepare($koneksi, "UPDATE produk SET stok = stok - ? WHERE id_produk = ? AND status_dihapus = 0");
                        mysqli_stmt_bind_param($query_update_stok, "ii", $jumlah, $produk['id_produk']);
                        mysqli_stmt_execute($query_update_stok);
                    }
                }
            }

            mysqli_commit($koneksi);
            $_SESSION['produk_keluar_sukses'] = 'Transaksi produk keluar berhasil disimpan!';
            header('Location: index.php');
            exit;

        } catch(Exception $e) {
            mysqli_rollback($koneksi);
            $_SESSION['produk_keluar_error'] = 'Terjadi kesalahan saat menyimpan transaksi! Error: ' . $e->getMessage();
            header('Location: tambah.php');
            exit;        
        }    
    }    
?>