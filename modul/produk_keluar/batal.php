<?php
header('Content-Type: application/json');

require_once '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    
    $id_pengeluaran = $_GET['id'];
    
    mysqli_begin_transaction($koneksi);
    
    try {
        // Get pengeluaran details first
        $query_get = "SELECT id_pengeluaran_produk FROM pengeluaran_produk WHERE id_pengeluaran_produk = ? AND status_dihapus = 0";
        $stmt_get = mysqli_prepare($koneksi, $query_get);
        mysqli_stmt_bind_param($stmt_get, "i", $id_pengeluaran);
        mysqli_stmt_execute($stmt_get);
        $result = mysqli_stmt_get_result($stmt_get);
        $pengeluaran = mysqli_fetch_assoc($result);

        if (!$pengeluaran) {
            throw new Exception('Transaksi tidak ditemukan');
        }
            
        // Get and update stock from detail_pengeluaran_produk
        $query_detail = "SELECT id_produk, jumlah FROM detail_pengeluaran_produk WHERE id_pengeluaran_produk = ? AND status_dihapus = 0";
        $stmt_detail = mysqli_prepare($koneksi, $query_detail);
        mysqli_stmt_bind_param($stmt_detail, "i", $id_pengeluaran);
        mysqli_stmt_execute($stmt_detail);
        $result_detail = mysqli_stmt_get_result($stmt_detail);
        
        if (mysqli_num_rows($result_detail) === 0) {
            throw new Exception('Detail pengeluaran tidak ditemukan');
        }
        
        while ($detail = mysqli_fetch_assoc($result_detail)) {
            // Reverse stock updates (add back to stock)
            $query_update_stok = "UPDATE produk SET stok = stok + ? WHERE id_produk = ? AND status_dihapus = 0";
            $stmt_update_stok = mysqli_prepare($koneksi, $query_update_stok);
            mysqli_stmt_bind_param($stmt_update_stok, "ii", $detail['jumlah'], $detail['id_produk']);
            
            if (!mysqli_stmt_execute($stmt_update_stok)) {
                throw new Exception('Gagal mengupdate stok produk');
            }
        }
        
        // Soft delete detail_pengeluaran_produk
        $query_delete_detail = "UPDATE detail_pengeluaran_produk SET status_dihapus = 1 WHERE id_pengeluaran_produk = ?";
        $stmt_delete_detail = mysqli_prepare($koneksi, $query_delete_detail);
        mysqli_stmt_bind_param($stmt_delete_detail, "i", $id_pengeluaran);
        
        if (!mysqli_stmt_execute($stmt_delete_detail)) {
            throw new Exception('Gagal membatalkan detail pengeluaran');
        }
        
        // Soft delete pengeluaran_produk
        $query_delete = "UPDATE pengeluaran_produk SET status_dihapus = 1 WHERE id_pengeluaran_produk = ?";
        $stmt_delete = mysqli_prepare($koneksi, $query_delete);
        mysqli_stmt_bind_param($stmt_delete, "i", $id_pengeluaran);
        
        if (!mysqli_stmt_execute($stmt_delete)) {
            throw new Exception('Gagal membatalkan pengeluaran');
        }
        
        mysqli_commit($koneksi);
        echo json_encode([
            'success' => true,
            'message' => 'Transaksi pengeluaran berhasil dibatalkan'
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
}?>
