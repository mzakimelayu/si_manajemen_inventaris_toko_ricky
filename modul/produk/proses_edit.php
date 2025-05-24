
<?php
session_start();

include '../../koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $kode_produk = $_POST['kode_produk'];
    $nama_produk = $_POST['nama_produk'];
    $id_kategori_produk = $_POST['id_kategori_produk'];
    $id_satuan_produk = $_POST['id_satuan_produk'];
    $stok = $_POST['stok'];
    $stok_minimum = $_POST['stok_minimum'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];

    // Cek kode produk apakah sudah ada yang menggunakan
    $check_kode = mysqli_query($koneksi, "SELECT * FROM produk WHERE kode_produk = '$kode_produk' AND id_produk != '$id' AND status_dihapus = 0");
    if(mysqli_num_rows($check_kode) > 0) {
        $_SESSION['produk_eror'] = "Kode produk sudah digunakan!";
        header("Location: edit.php?id=" . $id);
        exit();
    }

    $query = "UPDATE produk SET 
              kode_produk = '$kode_produk',
              nama_produk = '$nama_produk',
              id_kategori_produk = '$id_kategori_produk',
              id_satuan_produk = '$id_satuan_produk',
              stok = '$stok',
              stok_minimum = '$stok_minimum',
              harga_beli = '$harga_beli',
              harga_jual = '$harga_jual'
              WHERE id_produk = '$id'";

    if(mysqli_query($koneksi, $query)) {
        $_SESSION['produk_sukses'] = "Data produk berhasil diupdate!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['produk_eror'] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        header("Location: edit.php?id=" . $id);
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}?>
