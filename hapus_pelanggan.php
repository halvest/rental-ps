<?php
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus pelanggan
    $stmt = $conn->prepare("DELETE FROM Pelanggan WHERE id_pelanggan = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href = 'pelanggan.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location.href = 'pelanggan.php';</script>";
    }
    exit;
}
?>