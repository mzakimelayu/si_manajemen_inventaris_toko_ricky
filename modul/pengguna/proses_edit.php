
<?php
session_start();
include '../../koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengguna = $_POST['id_pengguna'];
    $username_pengguna = $_POST['username'];
    $password = $_POST['password'];
    $nama_lengkap_pengguna = $_POST['nama_lengkap'];
    $role_pengguna = $_POST['role'];
    $nohp_pengguna = $_POST['nomor_hp'];
    $jenis_kelamin_pengguna = $_POST['jenis_kelamin'];
    $alamat_pengguna = $_POST['alamat'];

    // Cek username apakah sudah ada yang menggunakan
    $check_username = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username = '$username_pengguna' AND id_pengguna != '$id_pengguna' AND status_dihapus = 0");
    if(mysqli_num_rows($check_username) > 0) {
        $_SESSION['pengguna_eror'] = "Username sudah digunakan!";
        header("Location: edit.php?id=" . $id_pengguna);
        exit();
    }

    // Jika password diisi, update dengan password baru
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE pengguna SET 
                  username = '$username_pengguna',
                  password = '$hashed_password',
                  nama_lengkap = '$nama_lengkap_pengguna',
                  role = '$role_pengguna',
                  nomor_hp = '$nohp_pengguna',
                  jenis_kelamin = '$jenis_kelamin_pengguna',
                  alamat = '$alamat_pengguna',
                  status_dihapus = 0
                  WHERE id_pengguna = '$id_pengguna'";
    } else {
        // Jika password kosong, update tanpa mengubah password
        $query = "UPDATE pengguna SET 
                  username = '$username_pengguna',
                  nama_lengkap = '$nama_lengkap_pengguna',
                  role = '$role_pengguna',
                  nomor_hp = '$nohp_pengguna',
                  jenis_kelamin = '$jenis_kelamin_pengguna',
                  alamat = '$alamat_pengguna',
                  status_dihapus = 0
                  WHERE id_pengguna = '$id_pengguna'";
    }
    if(mysqli_query($koneksi, $query)) {
        $_SESSION['pengguna_sukses'] = "Data pengguna berhasil diupdate!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['pengguna_eror'] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        header("Location: edit.php?id=" . $id_pengguna);
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}?>
