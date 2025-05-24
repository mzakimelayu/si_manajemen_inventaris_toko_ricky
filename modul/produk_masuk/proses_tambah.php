  <?php

  session_start();
  
  include '../../koneksi/db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tanggal = $_POST['tanggal'];
        $keterangan = $_POST['keterangan'];
        $id_pengguna = $_SESSION['dataPengguna']['id_pengguna'];

        // Validate required fields first
        if (isset($_POST['produk']) && is_array($_POST['produk'])) {
            foreach($_POST['produk'] as $produk) {
                if (empty($produk['id_produk']) || empty($produk['kode_produk'])) {
                    $_SESSION['produk_masuk_error'] = 'Data produk tidak lengkap! Pastikan Data Produk Diisi dengan benar.';
                    header('Location: tambah.php');
                    exit;
                }
            }
        } else {
            $_SESSION['produk_masuk_error'] = 'Tidak ada data produk yang diinputkan!';
            header('Location: tambah.php');
            exit;
        }

        mysqli_begin_transaction($koneksi);

        try {
            // Insert penerimaan header
            $query = mysqli_prepare($koneksi, "INSERT INTO penerimaan_produk (tanggal, keterangan, id_pengguna, status_dihapus) VALUES (?, ?, ?, 0)");
            mysqli_stmt_bind_param($query, "ssi", $tanggal, $keterangan, $id_pengguna);
            mysqli_stmt_execute($query);
            
            $id_penerimaan_produk = mysqli_insert_id($koneksi);

            // Insert penerimaan detail and update stock
            if (isset($_POST['produk']) && is_array($_POST['produk'])) {
                foreach($_POST['produk'] as $produk) {
                    if (!empty($produk['id_produk']) && !empty($produk['jumlah'])) {
                        // Validate numeric values
                        $jumlah = intval($produk['jumlah']);
                        $harga_beli = floatval($produk['harga_beli']);

                        // Insert detail penerimaan
                        $query_detail = mysqli_prepare($koneksi, "INSERT INTO detail_penerimaan_produk (penerimaan_produk_id, id_produk, jumlah, harga_beli, status_dihapus) VALUES (?, ?, ?, ?, 0)");
                        mysqli_stmt_bind_param($query_detail, "iiid", $id_penerimaan_produk, $produk['id_produk'], $jumlah, $harga_beli);
                        mysqli_stmt_execute($query_detail);

                        // Update stock in produk table
                        $query_update_stok = mysqli_prepare($koneksi, "UPDATE produk SET stok = stok + ? WHERE id_produk = ? AND status_dihapus = 0");
                        mysqli_stmt_bind_param($query_update_stok, "ii", $jumlah, $produk['id_produk']);
                        mysqli_stmt_execute($query_update_stok);
                    }
                }
            }

            mysqli_commit($koneksi);
            $_SESSION['produk_masuk_sukses'] = 'Transaksi produk masuk berhasil disimpan!';
            header('Location: index.php');
            exit;

        } catch(Exception $e) {
            mysqli_rollback($koneksi);
            $_SESSION['produk_masuk_error'] = 'Terjadi kesalahan saat menyimpan transaksi! Error: ' . $e->getMessage();
            header('Location: tambah.php');
            exit;        
        }    
    }    
?>