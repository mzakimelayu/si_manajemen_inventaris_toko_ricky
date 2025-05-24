
<?php

header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT p.*, k.nama_kategori, s.nama_satuan 
FROM produk p
LEFT JOIN kategori_produk k ON p.id_kategori_produk = k.id_kategori_produk AND k.status_dihapus = 0
LEFT JOIN satuan_produk s ON p.id_satuan_produk = s.id_satuan_produk AND s.status_dihapus = 0
WHERE p.status_dihapus = 0 
ORDER BY p.nama_produk ASC";
$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id' => $row['id_produk'],
        'kode_produk' => $row['kode_produk'],
        'nama_produk' => $row['nama_produk'],
        'id_kategori_produk' => $row['id_kategori_produk'],
        'nama_kategori' => $row['nama_kategori'],
        'id_satuan_produk' => $row['id_satuan_produk'],
        'nama_satuan' => $row['nama_satuan'],
        'stok' => $row['stok'],
        'stok_minimum' => $row['stok_minimum'],
        'harga_beli' => $row['harga_beli'],
        'harga_jual' => $row['harga_jual'],
        'status_dihapus' => $row['status_dihapus'],
    );
}
echo json_encode($data);
mysqli_close($koneksi);
?>
