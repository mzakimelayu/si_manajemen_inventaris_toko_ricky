<?php
header('Content-Type: application/json');

require_once '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'];
    
    // Check stok before delete
    $check_stok = "SELECT stok FROM produk WHERE id_produk = ?";
    $stmt_check = $koneksi->prepare($check_stok);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    $row = $result->fetch_assoc();
    
    if($row['stok'] > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Tidak dapat menghapus produk karena stok masih tersedia'
        ]);
        exit;
    }
    
    $query = "UPDATE produk SET status_dihapus = 1 WHERE id_produk = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 
                          'message' => 'Data produk berhasil dihapus']);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal menghapus data produk'
        ]);
    }
    
    $stmt_check->close();
    $stmt->close();
    $koneksi->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);
}?>
