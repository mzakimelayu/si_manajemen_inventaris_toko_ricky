<?php

session_start();

include '../../koneksi/db.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id_penerimaan_produk = $_POST['id_penerimaan_produk'];
      $tanggal = $_POST['tanggal'];
      $keterangan = $_POST['keterangan'];
      $id_pengguna = $_SESSION['dataPengguna']['id_pengguna'];

      // Validate required fields first
      if (isset($_POST['produk']) && is_array($_POST['produk'])) {
          foreach($_POST['produk'] as $produk) {
              if (empty($produk['id_produk']) || empty($produk['kode_produk'])) {
                  $_SESSION['produk_masuk_error'] = 'Data produk tidak lengkap! Pastikan Data Produk Diisi dengan benar.';
                  header('Location: edit.php?id='.$id_penerimaan_produk);
                  exit;
              }
          }
      } else {
          $_SESSION['produk_masuk_error'] = 'Tidak ada data produk yang diinputkan!';
          header('Location: edit.php?id='.$id_penerimaan_produk);
          exit;
      }

      mysqli_begin_transaction($koneksi);

      try {
          // Update penerimaan header
          $query = mysqli_prepare($koneksi, "UPDATE penerimaan_produk SET tanggal=?, keterangan=?, id_pengguna=? WHERE id_penerimaan_produk=? AND status_dihapus=0");
          mysqli_stmt_bind_param($query, "ssii", $tanggal, $keterangan, $id_pengguna, $id_penerimaan_produk);
          mysqli_stmt_execute($query);

          // Reverse previous stock updates
          $query_old_details = mysqli_prepare($koneksi, "SELECT id_produk, jumlah FROM detail_penerimaan_produk WHERE penerimaan_produk_id=? AND status_dihapus=0");
          mysqli_stmt_bind_param($query_old_details, "i", $id_penerimaan_produk);
          mysqli_stmt_execute($query_old_details);
          $result = mysqli_stmt_get_result($query_old_details);
        
          while($row = mysqli_fetch_assoc($result)) {
              $query_reverse_stock = mysqli_prepare($koneksi, "UPDATE produk SET stok = stok - ? WHERE id_produk = ? AND status_dihapus = 0");
              mysqli_stmt_bind_param($query_reverse_stock, "ii", $row['jumlah'], $row['id_produk']);
              mysqli_stmt_execute($query_reverse_stock);
          }

          // Delete old detail records
          $query_delete = mysqli_prepare($koneksi, "DELETE FROM detail_penerimaan_produk WHERE penerimaan_produk_id=?");
          mysqli_stmt_bind_param($query_delete, "i", $id_penerimaan_produk);
          mysqli_stmt_execute($query_delete);
        
          // Insert new penerimaan detail and update stock
          if (isset($_POST['produk']) && is_array($_POST['produk'])) {
              foreach($_POST['produk'] as $produk) {
                  if (!empty($produk['id_produk']) && !empty($produk['jumlah']) && !empty($produk['harga_beli'])) {
                      // Validate numeric values
                      $jumlah = intval($produk['jumlah']);
                      $harga_beli = floatval($produk['harga_beli']);

                      // Insert detail penerimaan
                      $query_detail = mysqli_prepare($koneksi, "INSERT INTO detail_penerimaan_produk (penerimaan_produk_id, id_produk, jumlah, harga_beli, status_dihapus) VALUES (?, ?, ?, ?, 0)");
                      mysqli_stmt_bind_param($query_detail, "iiid", $id_penerimaan_produk, $produk['id_produk'], $jumlah, $harga_beli);
                      mysqli_stmt_execute($query_detail);

                      // Update stock and harga_beli in produk table
                      $query_update_stok = mysqli_prepare($koneksi, "UPDATE produk SET stok = stok + ?, harga_beli = ? WHERE id_produk = ? AND status_dihapus = 0");
                      mysqli_stmt_bind_param($query_update_stok, "idi", $jumlah, $harga_beli, $produk['id_produk']);
                      mysqli_stmt_execute($query_update_stok);
                  }
              }
          }

          mysqli_commit($koneksi);
          $_SESSION['produk_masuk_sukses'] = 'Transaksi produk masuk berhasil diupdate!';
          header('Location: index.php');
          exit;

      } catch(Exception $e) {
          mysqli_rollback($koneksi);
          $_SESSION['produk_masuk_error'] = 'Terjadi kesalahan saat mengupdate data! Error: ' . $e->getMessage();
          header('Location: edit.php?id='.$id_penerimaan_produk);
          exit;        
      }
  }?>