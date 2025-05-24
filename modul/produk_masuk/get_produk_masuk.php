
<?php

header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT pp.*, dp.id_produk, dp.jumlah, p.kode_produk, p.nama_produk, dp.harga_beli, p.harga_jual, p.stok
FROM penerimaan_produk pp
LEFT JOIN detail_penerimaan_produk dp ON pp.id_penerimaan_produk = dp.penerimaan_produk_id
LEFT JOIN produk p ON dp.id_produk = p.id_produk
ORDER BY pp.tanggal DESC";

$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id_penerimaan_produk' => $row['id_penerimaan_produk'],
        'tanggal' => $row['tanggal'],
        'keterangan' => $row['keterangan'],
        'id_produk' => $row['id_produk'],
        'kode_produk' => $row['kode_produk'],
        'nama_produk' => $row['nama_produk'],
        'harga_beli' => $row['harga_beli'],
        'jumlah' => $row['jumlah'],
        'status_dihapus' => ($row['status_dihapus'] == 1 ? 'Dibatalkan' : 'Selesai')    );
}

echo json_encode($data);
mysqli_close($koneksi);
?>
