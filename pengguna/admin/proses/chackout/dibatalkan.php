<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_mitra = $_POST['id_mitra'];
$nomor_pemesanan = $_POST['nomor_pemesanan'];
$alasan = $_POST['alasan'];

// Lakukan validasi data
if (empty($nomor_pemesanan) || empty($alasan)) {
    echo "data_tidak_lengkap";
    exit();
}
// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO dibatalkan (id_mitra, nomor_pemesanan, alasan) 
        VALUES ('$id_mitra','$nomor_pemesanan','$alasan')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    // Buat query SQL untuk menghapus data checkout berdasarkan nomor_pemesanan
    $query_delate = "DELETE FROM checkout WHERE nomor_pemesanan = '$nomor_pemesanan'";

    // Jalankan query
    if (mysqli_query($koneksi, $query_delate)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
