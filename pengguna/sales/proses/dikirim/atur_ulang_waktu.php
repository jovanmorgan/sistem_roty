<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_dikirim = $_POST['id_dikirim'];
$waktu = date('Y-m-d H:i:s');
$waktu_data = $_POST['waktu'];
$type_waktu = $_POST['type_waktu'];
$waktu_batas_pengiriman = $waktu_data . ' ' . $type_waktu;

// Lakukan validasi data
if (empty($waktu_data) || empty($type_waktu)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "UPDATE dikirim SET waktu = '$waktu', waktu_batas_pengiriman = '$waktu_batas_pengiriman' WHERE id_dikirim = '$id_dikirim'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
