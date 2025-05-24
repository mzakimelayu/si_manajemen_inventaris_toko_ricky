<?php
    $judul_halaman = "Print Laporan Stok Produk";
    
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
            .status-restock {
                color: #dc2626;
                font-weight: bold;
            }
            .status-aman {
                color: #059669;
                font-weight: bold;
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
            <h1 class="title">LAPORAN STOK PRODUK</h1>
            <h2 class="subtitle">TOKO RICKY</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <th>Stok Minimum</th>
                    <th>Status Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT 
                    p.kode_produk,
                    p.nama_produk,
                    kp.nama_kategori,
                    sp.nama_satuan,
                    p.stok,
                    p.stok_minimum,
                    CASE
                        WHEN p.stok <= p.stok_minimum THEN 'Perlu Restock'
                        ELSE 'Aman'
                    END AS status_stok
                FROM produk p 
                JOIN kategori_produk kp ON p.id_kategori_produk = kp.id_kategori_produk
                JOIN satuan_produk sp ON p.id_satuan_produk = sp.id_satuan_produk";

                if(isset($_GET['kategori']) && $_GET['kategori'] !== '') {
                    $kategori = mysqli_real_escape_string($koneksi, $_GET['kategori']);
                    $query .= " WHERE p.id_kategori_produk = '$kategori'";
                }

                if(isset($_GET['status']) && $_GET['status'] !== '') {
                    $status = mysqli_real_escape_string($koneksi, $_GET['status']);
                    $query .= isset($_GET['kategori']) ? " AND" : " WHERE";
                    if($status == 'restock') {
                        $query .= " p.stok <= p.stok_minimum";
                    } else {
                        $query .= " p.stok > p.stok_minimum";
                    }
                }

                $result = mysqli_query($koneksi, $query);
                
                if (!$result) {
                    die("Query error: " . mysqli_error($koneksi));
                }

                $no = 1;
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>$no</td>";
                        echo "<td>".$row['kode_produk']."</td>";
                        echo "<td>".$row['nama_produk']."</td>";
                        echo "<td>".$row['nama_kategori']."</td>";
                        echo "<td>".$row['nama_satuan']."</td>";
                        echo "<td>".$row['stok']."</td>";
                        echo "<td>".$row['stok_minimum']."</td>";
                        echo "<td>";
                        echo $row['status_stok'] == 'Perlu Restock' ? 
                            "<span class='status-restock'>Perlu Restock</span>" : 
                            "<span class='status-aman'>Aman</span>";
                        echo "</td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align: center;'>Tidak ada data</td></tr>";
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