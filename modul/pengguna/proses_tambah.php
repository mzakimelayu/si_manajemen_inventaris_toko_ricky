  <?php

  session_start();
  
  include '../../koneksi/db.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $nama_lengkap = $_POST['nama_lengkap'];
      $role = $_POST['role'];
      $nohp = $_POST['nomor_hp'];
      $jenis_kelamin = $_POST['jenis_kelamin'];
      $alamat = $_POST['alamat'];

      try {
          // Check if username already exists
          $check = mysqli_prepare($koneksi, "SELECT username FROM pengguna WHERE username = ?");
          mysqli_stmt_bind_param($check, "s", $username);
          mysqli_stmt_execute($check);
          $result = mysqli_stmt_get_result($check);
        
          if (mysqli_num_rows($result) > 0) {
            $_SESSION['pengguna_eror'] = 'Username sudah digunakan!';
            header('Location: tambah.php');
            exit;       
          }

          // Hash password only if not empty
          if (!empty($password)) {
              $hashed_password = password_hash($password, PASSWORD_DEFAULT);
          } else {
              $_SESSION['pengguna_eror'] = 'Password tidak boleh kosong!';
              header('Location: tambah.php');
              exit;
          }

          // Insert new user
          $query = mysqli_prepare($koneksi, "INSERT INTO pengguna (username, password, nama_lengkap, 
                              role, nomor_hp, jenis_kelamin, alamat, status_dihapus) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
                            
          mysqli_stmt_bind_param($query, "sssssss", $username, $hashed_password, $nama_lengkap, $role, $nohp, $jenis_kelamin, $alamat);
          mysqli_stmt_execute($query);

          
          $_SESSION['pengguna_sukses'] = 'Data berhasil ditambahkan!';
          header('Location: index.php');
          exit;

      } catch(Exception $e) {
          echo "<script>
              alert('Terjadi kesalahan saat menambah data!');
              window.location.href='tambah.php';
          </script>";
      } 
}
  ?>