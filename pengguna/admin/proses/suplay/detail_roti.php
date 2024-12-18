<?php
include '../../../../keamanan/koneksi.php';

$id_roti = isset($_GET['id_roti']) ? intval($_GET['id_roti']) : 0;

// Query untuk mendapatkan detail roti
$query = "SELECT stok, gambar_roti FROM roti WHERE id_roti = $id_roti";
$result = mysqli_query($koneksi, $query);
$roti = mysqli_fetch_assoc($result);

if ($roti) {
    // Cek apakah roti sudah disuplaysikan
    $suplayQuery = "SELECT COUNT(*) AS count FROM suplay WHERE id_roti = $id_roti";
    $suplayResult = mysqli_fetch_assoc(mysqli_query($koneksi, $suplayQuery));

    // Tambahkan informasi suplaysi ke dalam array data roti
    $roti['sudah_disuplaykan'] = ($suplayResult['count'] > 0);
}

header('Content-Type: application/json');
echo json_encode($roti);
