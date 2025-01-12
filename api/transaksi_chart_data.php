<?php
// Include database connection
include '../config/db.php';

// Inisialisasi array untuk menyimpan data
$response = [
    'transaksi_counts' => [],
    'labels' => []
];

try {
    // Query untuk mendapatkan jumlah transaksi berdasarkan jenis PlayStation
    $query = "SELECT tipe_ps, COUNT(*) AS jumlah_transaksi 
              FROM Transaksi 
              GROUP BY tipe_ps";

    $result = $conn->query($query);

    // Memproses hasil query
    while ($row = $result->fetch_assoc()) {
        $response['labels'][] = $row['tipe_ps']; // Misal: PS1, PS2, dll.
        $response['transaksi_counts'][] = (int)$row['jumlah_transaksi'];
    }

    // Kirim response JSON
    header('Content-Type: application/json');
    echo json_encode($response);

} catch (Exception $e) {
    // Kirim error jika terjadi masalah
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
