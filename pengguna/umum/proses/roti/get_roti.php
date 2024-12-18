<?php
include '../../../../keamanan/koneksi.php';

if (isset($_GET['nomor_sejenis'])) {
    $nomor_sejenis = mysqli_real_escape_string($koneksi, $_GET['nomor_sejenis']);
    $result = mysqli_query($koneksi, "SELECT * FROM roti WHERE nomor_sejenis='$nomor_sejenis'");

    $rotis = array();
    while ($row = mysqli_fetch_assoc($result)) {

        $rotis[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($rotis);
}
