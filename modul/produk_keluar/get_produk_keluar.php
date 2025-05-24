
<?php

header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT pp.*, dp.id_produk, dp.jumlah, p.kode_produk, p.nama_produk, dp.harga_jual, p.stok, u.nama_lengkap
FROM pengeluaran_produk pp
LEFT JOIN detail_pengeluaran_produk dp ON pp.id_pengeluaran_produk = dp.id_pengeluaran_produk
LEFT JOIN produk p ON dp.id_produk = p.id_produk
LEFT JOIN pengguna u ON pp.id_pengguna = u.id_pengguna
ORDER BY pp.tanggal DESC";

$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id_pengeluaran_produk' => $row['id_pengeluaran_produk'],
        'tanggal' => $row['tanggal'],
        'penerima' => $row['penerima'],
        'keterangan' => $row['keterangan'],
        'id_produk' => $row['id_produk'],
        'kode_produk' => $row['kode_produk'],
        'nama_produk' => $row['nama_produk'],
        'harga_jual' => $row['harga_jual'],
        'jumlah' => $row['jumlah'],
        'nama_lengkap' => $row['nama_lengkap'],
        'status_dihapus' => ($row['status_dihapus'] == 1 ? 'Dibatalkan' : 'Selesai')    
    );
}

echo json_encode($data);
mysqli_close($koneksi);
?>
