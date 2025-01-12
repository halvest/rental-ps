<?php
include 'config/db.php';
include 'navbar.php';

$notification = ""; // Variabel untuk menyimpan notifikasi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi dan sanitasi input
    $id_pelanggan = intval($_POST['id_pelanggan']);
    $tanggal_sewa = $_POST['tanggal_sewa'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $id_playstation = $_POST['id_playstation'];
    $jumlah_item = $_POST['jumlah_item'];

    if (!$id_pelanggan || empty($tanggal_sewa) || empty($tanggal_kembali) || empty($id_playstation) || empty($jumlah_item)) {
        $notification = "<div class='alert alert-danger'>Input tidak valid. Pastikan semua data telah diisi dengan benar.</div>";
    } else {
        try {
            $conn->begin_transaction();

            // Simpan transaksi utama
            $stmt = $conn->prepare("INSERT INTO transaksi (id_pelanggan, tanggal_sewa, tanggal_kembali, status) VALUES (?, ?, ?, 'Proses')");
            $stmt->bind_param("iss", $id_pelanggan, $tanggal_sewa, $tanggal_kembali);
            if (!$stmt->execute()) {
                throw new Exception("Gagal menyimpan transaksi utama: " . $stmt->error);
            }
            $id_transaksi = $stmt->insert_id;

            // Ambil harga sewa untuk semua playstation dalam satu query
            $ids = implode(',', array_map('intval', $id_playstation));
            $result = $conn->query("SELECT id_playstation, harga_sewa FROM playstation WHERE id_playstation IN ($ids)");
            $harga_sewa_map = [];
            while ($row = $result->fetch_assoc()) {
                $harga_sewa_map[$row['id_playstation']] = $row['harga_sewa'];
            }

            // Simpan detail transaksi
            $stmt_detail = $conn->prepare("INSERT INTO detail_transaksi (id_transaksi, id_playstation, jumlah_item, harga_sewa) VALUES (?, ?, ?, ?)");
            for ($i = 0; $i < count($id_playstation); $i++) {
                $id_ps = intval($id_playstation[$i]);
                $jumlah = intval($jumlah_item[$i]);
                $harga_sewa = $harga_sewa_map[$id_ps] ?? null;

                if ($harga_sewa === null) {
                    throw new Exception("ID Playstation tidak valid: $id_ps");
                }

                $stmt_detail->bind_param("iiid", $id_transaksi, $id_ps, $jumlah, $harga_sewa);
                if (!$stmt_detail->execute()) {
                    throw new Exception("Gagal menyimpan detail transaksi: " . $stmt_detail->error);
                }
            }

            $conn->commit();
            $notification = "<div class='alert alert-success'>Transaksi berhasil disimpan.</div>";
        } catch (Exception $e) {
            $conn->rollback();
            $notification = "<div class='alert alert-danger'>Terjadi kesalahan: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <!-- Notifikasi -->
    <?php if (!empty($notification)): ?>
        <div class="mb-4">
            <?php echo $notification; ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Transaksi</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="id_pelanggan" class="form-label">Pilih Pelanggan</label>
                    <select name="id_pelanggan" class="form-select select2" required>
                        <option value="" disabled selected>Pilih Pelanggan</option>
                        <?php
                        $pelanggan = $conn->query("SELECT id_pelanggan, nama FROM pelanggan");
                        while ($row = $pelanggan->fetch_assoc()) {
                            echo "<option value='{$row['id_pelanggan']}'>{$row['nama']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal_sewa" class="form-label">Tanggal Sewa</label>
                    <input type="date" name="tanggal_sewa" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" class="form-control" required>
                </div>

                <label class="form-label">Item Rental</label>
                <div id="item-container" class="mb-3">
                    <div class="item-row d-flex gap-3 mb-2">
                        <select name="id_playstation[]" class="form-select" style="flex: 3;" required>
                            <option value="" disabled selected>Pilih Item</option>
                            <?php
                            $items = $conn->query("SELECT id_playstation, kategori, harga_sewa FROM playstation");
                            while ($row = $items->fetch_assoc()) {
                                echo "<option value='{$row['id_playstation']}'>{$row['kategori']} (Rp " . number_format($row['harga_sewa'], 0, ',', '.') . ")</option>";
                            }
                            ?>
                        </select>
                        <input type="number" name="jumlah_item[]" class="form-control" placeholder="Jumlah" style="flex: 1;" required>
                        <button type="button" class="btn btn-danger btn-remove-item">Hapus</button>
                    </div>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <button type="button" id="add-item" class="btn btn-primary">Tambah Item</button>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script>
    // Inisialisasi Select2 untuk dropdown pelanggan
    document.addEventListener('DOMContentLoaded', function () {
        $('.select2').select2({
            placeholder: "Pilih Pelanggan",
            allowClear: true
        });
    });

    // Menambahkan item baru
    document.getElementById('add-item').addEventListener('click', function () {
        const container = document.getElementById('item-container');
        const row = document.querySelector('.item-row').cloneNode(true);
        row.querySelectorAll('input, select').forEach(input => input.value = '');
        row.querySelector('.btn-remove-item').addEventListener('click', function () {
            row.remove();
        });
        container.appendChild(row);
    });

    // Hapus item yang dipilih
    document.querySelectorAll('.btn-remove-item').forEach(button => {
        button.addEventListener('click', function () {
            button.closest('.item-row').remove();
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
