
<?php
header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT * FROM pengguna where status_dihapus=0 ORDER BY id_pengguna ASC";
$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id_pengguna' => $row['id_pengguna'],
        'nama_pengguna' => $row['nama_lengkap'], 
        'username' => $row['username'],
        'role' => $row['role'],
        'nohp' => $row['nomor_hp'],
        'status_dihapus' => $row['status_dihapus']    
    );
}

echo json_encode($data);
mysqli_close($koneksi);
?>
