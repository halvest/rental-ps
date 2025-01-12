<?php
include 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        th, td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Data Transaksi</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h6 class="text-secondary">Tabel berikut menampilkan data transaksi lengkap beserta detail item dan pembayaran.</h6>
                <a href="add_transaksi.php" class="btn btn-success">+ Add New Transaksi</a>
            </div>
            <table id="transaksiTable" class="table table-bordered table-hover table-striped">
                <thead class="table-light">
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Detail Item</th>
                        <th>Tanggal Sewa</th>
                        <th>Tanggal Kembali</th>
                        <th>Tanggal Bayar</th>
                        <th>Metode Bayar</th>
                        <th>Jumlah Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "
                        SELECT 
                            t.id_transaksi, 
                            p.nama AS pelanggan_nama, 
                            GROUP_CONCAT(CONCAT(d.jumlah_item, ' x ', ps.kategori) SEPARATOR '<br>') AS detail_item,
                            t.tanggal_sewa, 
                            t.tanggal_kembali, 
                            pb.tanggal_bayar,
                            pb.metode_bayar,
                            pb.jumlah_bayar,
                            t.status
                        FROM transaksi t
                        JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
                        JOIN detail_transaksi d ON t.id_transaksi = d.id_transaksi
                        JOIN playstation ps ON d.id_playstation = ps.id_playstation
                        LEFT JOIN pembayaran pb ON t.id_transaksi = pb.id_transaksi
                        GROUP BY t.id_transaksi
                        ORDER BY t.tanggal_sewa DESC
                    ";
                    $result = $conn->query($sql);

                    if ($result === false) {
                        echo "<tr><td colspan='9'>Query error: " . $conn->error . "</td></tr>";
                    } else {
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['id_transaksi']}</td>
                                        <td>{$row['pelanggan_nama']}</td>
                                        <td>{$row['detail_item']}</td>
                                        <td class='text-nowrap'>{$row['tanggal_sewa']}</td>
                                        <td class='text-nowrap'>{$row['tanggal_kembali']}</td>
                                        <td class='text-nowrap'>" . ($row['tanggal_bayar'] ?? '<span class="text-danger">Belum Dibayar</span>') . "</td>
                                        <td>" . ($row['metode_bayar'] ?? '-') . "</td>
                                        <td class='text-nowrap'>" . ($row['jumlah_bayar'] ? '<span class="fw-bold text-success">Rp ' . number_format($row['jumlah_bayar'], 2, ',', '.') . '</span>' : '-') . "</td>
                                        <td>{$row['status']}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>No transactions found.</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#transaksiTable').DataTable({
            "order": [[3, "desc"]] // Default sorting by Tanggal Sewa (kolom ke-4)
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
