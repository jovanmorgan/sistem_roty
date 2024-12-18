<?php
include '../../../../keamanan/koneksi.php';

// Terima ID bank yang akan dihapus dari formulir HTML
$id_bank = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_bank)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data bank berdasarkan ID
$query_delete_bank = "DELETE FROM bank WHERE id_bank = '$id_bank'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_bank)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
