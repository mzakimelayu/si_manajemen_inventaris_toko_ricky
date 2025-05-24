<?php
    $judul_halaman = "Print Laporan Produk Keluar";
    
    include '../../cek_login.php';
?>

    <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title><?= $judul_utama ?></title>
            <style>
                @media print {
                    body {
                        margin: 0;
                        padding: 2mm;
                        font-family: Arial, sans-serif;
                    }
                    @page {
                        size: landscape;
                        margin: 10mm;
                    }
                    .no-print {
                        display: none;
                    }
                }
                body {
                    font-family: Arial, sans-serif;
                    background: white;
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                    border-bottom: 2px solid #000;
                    padding-bottom: 20px;
                }
                .title {
                    font-size: 24px;
                    font-weight: bold;
                    margin: 0;
                    padding: 0;
                }
                .subtitle {
                    font-size: 20px;
                    margin: 10px 0;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                th, td {
                    border: 1px solid #000;
                    padding: 8px;
                    text-align: left;
                    font-size: 12px;
                }
                th {
                    background-color: #f0f0f0;
                }
                .footer {
                    text-align: center;
                    width: 200px;
                    float: right;
                }
                .signature {
                    margin-top: 10px;
                    text-align: center;
                }
                .signature-line {
                    width: 200px;
                    margin-top: 80px;
                }
            </style>
            <script>
                window.onload = function() {
                    window.print();
                }
            </script>
        </head>
        <body>
            <div class="header">
                <h1 class="title">LAPORAN PRODUK KELUAR</h1>
                <h2 class="subtitle">TOKO RICKY</h2>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pencatat</th>
                        <th>Penerima</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Jual</th>
                        <th>Total</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT 
                        pp.tanggal,
                        pp.status_dihapus,
                        u.nama_lengkap AS pencatat,
                        pp.penerima,
                        pr.nama_produk,
                        dpp.jumlah,
                        dpp.harga_jual,
                        pp.keterangan 
                    FROM pengeluaran_produk pp 
                    JOIN detail_pengeluaran_produk dpp ON pp.id_pengeluaran_produk = dpp.id_pengeluaran_produk 
                    JOIN produk pr ON dpp.id_produk = pr.id_produk 
                    JOIN pengguna u ON pp.id_pengguna = u.id_pengguna";

                    if(isset($_GET['tanggal_awal']) && isset($_GET['tanggal_akhir']) && $_GET['tanggal_awal'] != '' && $_GET['tanggal_akhir'] != '') {
                        $tanggal_awal = mysqli_real_escape_string($koneksi, $_GET['tanggal_awal']);
                        $tanggal_akhir = mysqli_real_escape_string($koneksi, $_GET['tanggal_akhir']);
                        $query .= " WHERE DATE(pp.tanggal) BETWEEN DATE('$tanggal_awal') AND DATE('$tanggal_akhir')";
                    }
                    
                    if(isset($_GET['status']) && $_GET['status'] != '') {
                        $status = mysqli_real_escape_string($koneksi, $_GET['status']);
                        if(strpos($query, 'WHERE') !== false) {
                            $query .= " AND pp.status_dihapus = '$status'";
                        } else {
                            $query .= " WHERE pp.status_dihapus = '$status'";
                        }
                    }
                    
                    $query .= " ORDER BY pp.tanggal DESC";

                    $result = mysqli_query($koneksi, $query);
                
                    if (!$result) {
                        die("Query error: " . mysqli_error($koneksi));
                    }

                    $no = 1;
                    $total_keseluruhan = 0;
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $total = $row['jumlah'] * $row['harga_jual'];
                            $total_keseluruhan += $total;
                            echo "<tr>";
                            echo "<td>$no</td>";
                            echo "<td>".date('d/m/Y', strtotime($row['tanggal']))."</td>";
                            echo "<td>".$row['pencatat']."</td>";
                            echo "<td>".$row['penerima']."</td>";
                            echo "<td>".$row['nama_produk']."</td>";
                            echo "<td>".$row['jumlah']."</td>";
                            echo "<td>Rp ".number_format($row['harga_jual'], 0, ',', '.')."</td>";
                            echo "<td>Rp ".number_format($total, 0, ',', '.')."</td>";
                            echo "<td>".$row['keterangan']."</td>";
                            echo "<td>".($row['status_dihapus'] == 1 ? 'Dibatalkan' : 'Selesai')."</td>";
                            echo "</tr>";
                            $no++;
                        }
                        echo "<tr>";
                        echo "<td colspan='7' style='text-align: right; font-weight: bold;'>Total Keseluruhan:</td>";
                        echo "<td colspan='3' style='font-weight: bold;'>Rp ".number_format($total_keseluruhan, 0, ',', '.')."</td>";
                        echo "</tr>";
                    } else {
                        echo "<tr><td colspan='10' style='text-align: center;'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        
            <div class="footer">
                <p>Padang, 
                    <?php 
                        $bulan = array(
                            'January' => 'Januari',
                            'February' => 'Februari',
                            'March' => 'Maret',
                            'April' => 'April',
                            'May' => 'Mei',
                            'June' => 'Juni',
                            'July' => 'Juli',
                            'August' => 'Agustus',
                            'September' => 'September',
                            'October' => 'Oktober', 
                            'November' => 'November',
                            'December' => 'Desember'
                        );
                        echo date('d ') . $bulan[date('F')] . date(' Y'); 
                    ?>
                </p>            
                <div class="signature">
                    <p>Pemilik</p>
                    <div class="signature-line"></div>
                    <p>(____________________)</p>
                </div>
            </div>
        </body>
    </html>