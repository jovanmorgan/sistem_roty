<?php
include '../../../../keamanan/koneksi.php';

if (isset($_GET['nomor_sejenis'])) {
    $nomor_sejenis = mysqli_real_escape_string($koneksi, $_GET['nomor_sejenis']);
    // Mengambil data roti dengan nomor_sejenis yang sesuai dan juga ada di tabel promo
    $query = "
        SELECT roti.* 
        FROM roti 
        INNER JOIN promo ON roti.id_roti = promo.id_roti 
        WHERE roti.nomor_sejenis = '$nomor_sejenis'
    ";

    $result = mysqli_query($koneksi, $query);

    $rotis = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rotis[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($rotis);
}
