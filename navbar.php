<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
            <i class="bi bi-controller me-2"></i> Rental PS
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">
                        <i class="bi bi-house-door me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo basename($_SERVER['PHP_SELF']) == 'transaksi.php' ? 'active' : ''; ?>" href="transaksi.php">
                        <i class="bi bi-receipt me-2"></i>Transaksi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo basename($_SERVER['PHP_SELF']) == 'pelanggan.php' ? 'active' : ''; ?>" href="pelanggan.php">
                        <i class="bi bi-people me-2"></i>Pelanggan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo basename($_SERVER['PHP_SELF']) == 'add_pembayaran.php' ? 'active' : ''; ?>" href="add_pembayaran.php">
                        <i class="bi bi-wallet2 me-2"></i>Pembayaran
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo basename($_SERVER['PHP_SELF']) == 'pendapatan.php' ? 'active' : ''; ?>" href="pendapatan.php">
                        <i class="bi bi-bar-chart me-2"></i>Laporan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 text-danger" href="logout.php">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Warna biru utama untuk background */
    .bg-primary {
        background-color: #007bff !important; /* Warna biru solid */
    }

    /* Teks link berwarna putih */
    .nav-link {
        color: #ffffff !important;
    }

    /* Warna kuning saat hover */
    .nav-link:hover {
        color: #ffdd57 !important; /* Warna kuning cerah */
    }

    /* Tampilan halaman aktif */
    .nav-link.active {
        background-color: #0056b3 !important; /* Warna biru lebih gelap */
        border-radius: 5px;
        color: #ffffff !important; /* Teks putih */
    }

    /* Tombol toggle warna putih */
    .navbar-toggler-icon {
        background-color: #ffffff !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
