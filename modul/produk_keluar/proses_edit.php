  <?php

  session_start();
  
  include '../../koneksi/db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_pengeluaran_produk = $_POST['id_pengeluaran_produk'];
        $tanggal = $_POST['tanggal'];
        $keterangan = $_POST['keterangan'];
        $penerima = $_POST['penerima'];
        $id_pengguna = $_SESSION['dataPengguna']['id_pengguna'];

        // Validate required fields first
        if (isset($_POST['produk']) && is_array($_POST['produk'])) {
            foreach($_POST['produk'] as $produk) {
                if (empty($produk['id_produk']) || empty($produk['kode_produk'])) {
                    $_SESSION['produk_keluar_error'] = 'Data produk tidak lengkap! Pastikan Data Produk Diisi dengan benar.';
                    header('Location: edit.php?id=' . $id_pengeluaran_produk);
                    exit;
                }
            }
        } else {
            $_SESSION['produk_keluar_error'] = 'Tidak ada data produk yang diinputkan!';
            header('Location: edit.php?id=' . $id_pengeluaran_produk);
            exit;
        }

        mysqli_begin_transaction($koneksi);

        try {
            // Update pengeluaran header
            $query = mysqli_prepare($koneksi, "UPDATE pengeluaran_produk SET tanggal = ?, keterangan = ?, penerima = ?, id_pengguna = ? WHERE id_pengeluaran_produk = ?");
            mysqli_stmt_bind_param($query, "sssii", $tanggal, $keterangan, $penerima, $id_pengguna, $id_pengeluaran_produk);
            mysqli_stmt_execute($query);

            // Get existing details to restore stock
            $query_existing = mysqli_prepare($koneksi, "SELECT id_produk, jumlah FROM detail_pengeluaran_produk WHERE id_pengeluaran_produk = ? AND status_dihapus = 0");
            mysqli_stmt_bind_param($query_existing, "i", $id_pengeluaran_produk);
            mysqli_stmt_execute($query_existing);
            $result = mysqli_stmt_get_result($query_existing);
            
            while($row = mysqli_fetch_assoc($result)) {
                // Restore stock for existing items
                $query_restore = mysqli_prepare($koneksi, "UPDATE produk SET stok = stok + ? WHERE id_produk = ? AND status_dihapus = 0");
                mysqli_stmt_bind_param($query_restore, "ii", $row['jumlah'], $row['id_produk']);
                mysqli_stmt_execute($query_restore);
            }

            // Delete old details
            $query_delete = mysqli_prepare($koneksi, "DELETE FROM detail_pengeluaran_produk WHERE id_pengeluaran_produk = ?");
            mysqli_stmt_bind_param($query_delete, "i", $id_pengeluaran_produk);
            mysqli_stmt_execute($query_delete);
            
            // Insert new details and update stock
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
            $_SESSION['produk_keluar_sukses'] = 'Transaksi produk keluar berhasil diupdate!';
            header('Location: index.php');
            exit;

        } catch(Exception $e) {
            mysqli_rollback($koneksi);
            $_SESSION['produk_keluar_error'] = 'Terjadi kesalahan saat mengupdate transaksi! Error: ' . $e->getMessage();
            header('Location: edit.php?id=' . $id_pengeluaran_produk);
            exit;        
        }    
    }    
?>