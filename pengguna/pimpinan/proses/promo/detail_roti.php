<?php
include '../../../../keamanan/koneksi.php';

$id_roti = isset($_GET['id_roti']) ? intval($_GET['id_roti']) : 0;

// Query untuk mendapatkan detail roti
$query = "SELECT harga, gambar_roti FROM roti WHERE id_roti = $id_roti";
$result = mysqli_query($koneksi, $query);
$roti = mysqli_fetch_assoc($result);

if ($roti) {
    // Cek apakah roti sudah dipromosikan
    $promoQuery = "SELECT COUNT(*) AS count FROM promo WHERE id_roti = $id_roti";
    $promoResult = mysqli_fetch_assoc(mysqli_query($koneksi, $promoQuery));

    // Tambahkan informasi promosi ke dalam array data roti
    $roti['sudah_dipromosikan'] = ($promoResult['count'] > 0);
}

header('Content-Type: application/json');
echo json_encode($roti);
