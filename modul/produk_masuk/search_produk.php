<?php
include "../../koneksi/db.php";

header('Content-Type: application/json');

if(isset($_GET['term'])) {
    $searchTerm = $_GET['term'];
    
    $query = "SELECT id_produk, kode_produk, nama_produk, harga_beli 
              FROM produk 
              WHERE (nama_produk LIKE ? OR kode_produk LIKE ?)
              AND status_dihapus = 0";
    
    $stmt = mysqli_prepare($koneksi, $query);
    $searchParam = "%$searchTerm%";
    mysqli_stmt_bind_param($stmt, "ss", $searchParam, $searchParam);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);    
    $data = array();
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'id_produk' => $row['id_produk'],
            'kode_produk' => $row['kode_produk'],
            'nama_produk' => $row['nama_produk'],
            'harga_beli' => $row['harga_beli']
        );
    }
    
    echo json_encode($data);
    mysqli_stmt_close($stmt);
}
mysqli_close($koneksi);
?>
