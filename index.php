<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental PS Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card-hover:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
        }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
        }
    </style>
</head>
<body>
    <?php 
    include 'config/db.php'; 
    include 'navbar.php';
    ?>

    <div class="content">
        <!-- Dashboard Content -->
        <div class="container mt-4">
            <div class="row">
                <!-- Cards -->
                <?php
                function get_count($table) {
                    global $conn;
                    $result = $conn->query("SELECT COUNT(*) AS total FROM `$table`");
                    $data = $result->fetch_assoc();
                    return $data['total'];
                }
                ?>
                <div class="col-md-3">
                    <div class="card bg-info text-white card-hover">
                        <div class="card-body text-center">
                            <h5 class="card-title">Admin</h5>
                            <h3><?php echo get_count('Admin'); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white card-hover">
                        <div class="card-body text-center">
                            <h5 class="card-title">Pelanggan</h5>
                            <h3><?php echo get_count('Pelanggan'); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white card-hover">
                        <div class="card-body text-center">
                            <h5 class="card-title">PlayStation</h5>
                            <h3><?php echo get_count('Playstation'); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white card-hover">
                        <div class="card-body text-center">
                            <h5 class="card-title">Transaksi</h5>
                            <h3><?php echo get_count('Transaksi'); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table Data -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-success text-white">Data Pelanggan</div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Email</th>
                                        <th>No Telepon</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM Pelanggan";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . $row["id_pelanggan"] . "</td>
                                                    <td>" . $row["nama"] . "</td>
                                                    <td>" . $row["alamat"] . "</td>
                                                    <td>" . $row["email"] . "</td>
                                                    <td>" . $row["no_telepon"] . "</td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>No data found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer mt-5">
        <p>&copy; 2025 Rental PS. All Rights Reserved.</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
