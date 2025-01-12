<?php include 'config/db.php'; ?>
<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <!-- Notifikasi -->
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-<?php echo $_GET['type'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
            <?php echo $_GET['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
</div>

<!-- Tombol Add New Pelanggan di luar container -->
<div class="d-flex justify-content-end px-4 mb-3">
    <a href="add_pelanggan.php" class="btn btn-success btn-sm d-flex align-items-center">
        <i class="bi bi-plus-circle me-2"></i> Add New Pelanggan
    </a>
</div>

<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">Data Pelanggan</div>
        <div class="card-body">
            <!-- Pencarian -->
            <form method="GET" action="" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari pelanggan..." value="<?php echo $_GET['search'] ?? ''; ?>">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </div>
            </form>

            <!-- Tabel Pelanggan -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>No Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Pagination
                    $limit = 10;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    // Pencarian
                    $search = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : "%";

                    $stmt = $conn->prepare("SELECT * FROM Pelanggan WHERE nama LIKE ? LIMIT ?, ?");
                    $stmt->bind_param('sii', $search, $offset, $limit);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id_pelanggan']}</td>
                                    <td>{$row['nama']}</td>
                                    <td>{$row['alamat']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['no_telepon']}</td>
                                    <td>
                                        <a href='update_pelanggan.php?id={$row['id_pelanggan']}' class='btn btn-warning btn-sm'>Edit</a>
                                        <a href='hapus_pelanggan.php?id={$row['id_pelanggan']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Delete</a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>Tidak ada data ditemukan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Pagination Links -->
            <?php
            $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM Pelanggan WHERE nama LIKE ?");
            $stmt->bind_param('s', $search);
            $stmt->execute();
            $result = $stmt->get_result();
            $total = $result->fetch_assoc()['total'];
            $total_pages = ceil($total / $limit);
            ?>
            <nav>
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $_GET['search'] ?? ''; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
