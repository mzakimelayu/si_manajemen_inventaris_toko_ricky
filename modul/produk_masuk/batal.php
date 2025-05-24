<?php
header('Content-Type: application/json');

require_once '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    
    $id_pembelian = $_GET['id'];
    
    mysqli_begin_transaction($koneksi);
    
    try {
        // Get penerimaan details first
        $query_get = "SELECT id_penerimaan_produk FROM penerimaan_produk WHERE id_penerimaan_produk = ? AND status_dihapus = 0";
        $stmt_get = mysqli_prepare($koneksi, $query_get);
        mysqli_stmt_bind_param($stmt_get, "i", $id_pembelian);
        mysqli_stmt_execute($stmt_get);
        $result = mysqli_stmt_get_result($stmt_get);
        $penerimaan = mysqli_fetch_assoc($result);

        if (!$penerimaan) {
            throw new Exception('Transaksi tidak ditemukan');
        }
            
        // Get and update stock from detail_penerimaan_produk
        $query_detail = "SELECT id_produk, jumlah FROM detail_penerimaan_produk WHERE penerimaan_produk_id = ? AND status_dihapus = 0";
        $stmt_detail = mysqli_prepare($koneksi, $query_detail);
        mysqli_stmt_bind_param($stmt_detail, "i", $id_pembelian);
        mysqli_stmt_execute($stmt_detail);
        $result_detail = mysqli_stmt_get_result($stmt_detail);
        
        if (mysqli_num_rows($result_detail) === 0) {
            throw new Exception('Detail penerimaan tidak ditemukan');
        }
        
        while ($detail = mysqli_fetch_assoc($result_detail)) {
            // Check current stock first
            $query_check_stock = "SELECT stok FROM produk WHERE id_produk = ? AND status_dihapus = 0";
            $stmt_check_stock = mysqli_prepare($koneksi, $query_check_stock);
            mysqli_stmt_bind_param($stmt_check_stock, "i", $detail['id_produk']);
            mysqli_stmt_execute($stmt_check_stock);
            $result_stock = mysqli_stmt_get_result($stmt_check_stock);
            $current_stock = mysqli_fetch_assoc($result_stock);
            
            if (!$current_stock) {
                throw new Exception('Produk tidak ditemukan');
            }
            
            if ($current_stock['stok'] < $detail['jumlah']) {
                throw new Exception('Stok tidak mencukupi untuk pembatalan');
            }
            
            // Reverse stock updates
            $query_update_stok = "UPDATE produk SET stok = stok - ? WHERE id_produk = ? AND status_dihapus = 0";
            $stmt_update_stok = mysqli_prepare($koneksi, $query_update_stok);
            mysqli_stmt_bind_param($stmt_update_stok, "ii", $detail['jumlah'], $detail['id_produk']);
            
            if (!mysqli_stmt_execute($stmt_update_stok)) {
                throw new Exception('Gagal mengupdate stok produk');
            }
        }
        
        // Soft delete detail_penerimaan_produk
        $query_delete_detail = "UPDATE detail_penerimaan_produk SET status_dihapus = 1 WHERE penerimaan_produk_id = ?";
        $stmt_delete_detail = mysqli_prepare($koneksi, $query_delete_detail);
        mysqli_stmt_bind_param($stmt_delete_detail, "i", $id_pembelian);
        
        if (!mysqli_stmt_execute($stmt_delete_detail)) {
            throw new Exception('Gagal membatalkan detail penerimaan');
        }
        
        // Soft delete penerimaan_produk
        $query_delete = "UPDATE penerimaan_produk SET status_dihapus = 1 WHERE id_penerimaan_produk = ?";
        $stmt_delete = mysqli_prepare($koneksi, $query_delete);
        mysqli_stmt_bind_param($stmt_delete, "i", $id_pembelian);
        
        if (!mysqli_stmt_execute($stmt_delete)) {
            throw new Exception('Gagal membatalkan penerimaan');
        }
        
        mysqli_commit($koneksi);
        echo json_encode([
            'success' => true,
            'message' => 'Transaksi penerimaan berhasil dibatalkan'
        ]);
        
    } catch(Exception $e) {
        mysqli_rollback($koneksi);
        echo json_encode([
            'success' => false,
            'message' => 'Gagal membatalkan transaksi: ' . $e->getMessage()
        ]);
    }
    
    mysqli_close($koneksi);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);
}
?>
