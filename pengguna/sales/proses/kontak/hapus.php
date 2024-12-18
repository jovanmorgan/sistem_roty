<?php
include '../../../../keamanan/koneksi.php';

// Terima ID kontak yang akan dihapus dari formulir HTML
$id_kontak = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_kontak)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data kontak berdasarkan ID
$query_delete_kontak = "DELETE FROM kontak WHERE id_kontak = '$id_kontak'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_kontak)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
