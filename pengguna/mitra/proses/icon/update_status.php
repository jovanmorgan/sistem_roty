<?php
include '../../../../keamanan/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $id_mitra = $_POST['id_mitra']; // Ambil id_mitra dari POST

    // Fungsi untuk memperbarui data berdasarkan id_mitra
    function updateStatus($table, $id_mitra)
    {
        global $koneksi;
        $query = "UPDATE $table SET dilihat = 'sudah dilihat' WHERE dilihat = '' AND id_mitra = '$id_mitra'";
        return mysqli_query($koneksi, $query);
    }

    // Memperbarui status berdasarkan parameter yang diterima
    switch ($status) {
        case 'belum_bayar':
            updateStatus('checkout', $id_mitra);
            break;
        case 'dikemas':
            updateStatus('dikemas', $id_mitra);
            break;
        case 'dikirim':
            updateStatus('dikirim', $id_mitra);
            break;
        case 'diterima':
            updateStatus('diterima', $id_mitra);
            break;
        case 'dibatalkan':
            updateStatus('dibatalkan', $id_mitra);
            break;
        case 'keranjang':
            updateStatus('keranjang', $id_mitra);
            break;
        case 'keranjang_promo':
            updateStatus('keranjang', $id_mitra);
            break;
        default:
            echo 'Status tidak dikenal.';
            exit;
    }

    // Menutup koneksi
    mysqli_close($koneksi);

    // Mengirim respon
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}