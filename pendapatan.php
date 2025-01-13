<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'config/db.php'; ?>
<?php include 'navbar.php'; ?>

<?php
// Query untuk menghitung agregasi (rata-rata, pendapatan terendah, dan tertinggi)
$sql_agregasi = "
    SELECT 
        AVG(total_pendapatan) AS rata_rata,
        MIN(total_pendapatan) AS pendapatan_terendah,
        MAX(total_pendapatan) AS pendapatan_tertinggi
    FROM (
        SELECT 
            MONTHNAME(tanggal_bayar) AS bulan,
            SUM(jumlah_bayar) AS total_pendapatan
        FROM pembayaran
        GROUP BY MONTH(tanggal_bayar)
    ) AS subquery
";

$result_agregasi = $conn->query($sql_agregasi);

// Variabel untuk menyimpan hasil agregasi
$rata_rata = $pendapatan_terendah = $pendapatan_tertinggi = 0;

if ($result_agregasi && $row_agregasi = $result_agregasi->fetch_assoc()) {
    $rata_rata = $row_agregasi['rata_rata'];
    $pendapatan_terendah = $row_agregasi['pendapatan_terendah'];
    $pendapatan_tertinggi = $row_agregasi['pendapatan_tertinggi'];
}
?>

<!-- Bagian Fungsi Agregasi -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <h5 class="card-title">Rata-rata Pendapatan</h5>
                    <p class="card-text fw-bold text-primary">Rp <?= number_format($rata_rata, 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <h5 class="card-title">Pendapatan Terendah</h5>
                    <p class="card-text fw-bold text-danger">Rp <?= number_format($pendapatan_terendah, 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <h5 class="card-title">Pendapatan Tertinggi</h5>
                    <p class="card-text fw-bold text-success">Rp <?= number_format($pendapatan_tertinggi, 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bagian Tabel -->
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            Laporan Pendapatan
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk mengambil data bulanan
                    $sql = "
                        SELECT 
                            MONTHNAME(tanggal_bayar) AS bulan, 
                            SUM(jumlah_bayar) AS total_pendapatan 
                        FROM pembayaran
                        GROUP BY MONTH(tanggal_bayar)
                        ORDER BY MONTH(tanggal_bayar)
                    ";

                    $result = $conn->query($sql);

                    // Tampilkan hasil query
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $current_month = date('F');
                            $highlight = ($row['bulan'] === $current_month) ? 'class="table-success"' : '';

                            echo "<tr $highlight>
                                    <td>{$row['bulan']}</td>
                                    <td>Rp " . number_format($row['total_pendapatan'], 0, ',', '.') . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2' class='text-center'>Tidak ada data untuk ditampilkan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
