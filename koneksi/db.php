<?php 

// koneksi ke database dengan mysqli

// $koneksi = mysqli_connect("localhost", "root", "", "db_si_inventaris_toko_ricky");
$koneksi = mysqli_connect("localhost:3308", "root", "", "db_si_inventaris_toko_ricky");

// cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}