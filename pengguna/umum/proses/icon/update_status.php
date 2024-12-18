<?php
include '../../../../keamanan/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];

    // Fungsi untuk memperbarui data
    function updateStatus($table)
    {
        global $koneksi;
        $query = "UPDATE $table SET dilihat = 'sudah dilihat' WHERE dilihat = ''";
        return mysqli_query($koneksi, $query);
    }

    // Memperbarui status berdasarkan parameter yang diterima
    switch ($status) {
        case 'belum_bayar':
            updateStatus('checkout');
            break;
        case 'dikemas':
            updateStatus('dikemas');
            break;
        case 'dikirim':
            updateStatus('dikirim');
            break;
        case 'diterima':
            updateStatus('diterima');
            break;
        case 'dibatalkan':
            updateStatus('dibatalkan');
            break;
        case 'keranjang':
            updateStatus('keranjang');
            break;
        case 'keranjang_promo':
            updateStatus('keranjang');
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
