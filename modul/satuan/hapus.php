<?php
header('Content-Type: application/json');

require_once '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'];
    
    $query = "UPDATE satuan_produk SET status_dihapus = 1 WHERE id_satuan_produk = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 
                          'message' => 'Data satuan berhasil dihapus']);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal menghapus data satuan'
        ]);
    }
    
    $stmt->close();
    $koneksi->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);
}?>
