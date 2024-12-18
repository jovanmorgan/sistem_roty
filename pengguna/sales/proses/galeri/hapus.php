<?php
include '../../../../keamanan/koneksi.php';

// Terima ID galeri yang akan dihapus dari formulir HTML
$id_galeri = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_galeri)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mendapatkan path gambar_galeri yang akan dihapus
$query_get_gambar_galeri = "SELECT gambar_galeri FROM galeri WHERE id_galeri = ?";
$stmt = mysqli_prepare($koneksi, $query_get_gambar_galeri);
mysqli_stmt_bind_param($stmt, 'i', $id_galeri);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$gambar_galeri_to_delete = $row['gambar_galeri'];

// Buat query SQL untuk memeriksa apakah ada data lain yang menggunakan file gambar_galeri yang akan dihapus
$query_check_gambar_galeri = "SELECT COUNT(*) AS total FROM galeri WHERE gambar_galeri = ?";
$stmt_check = mysqli_prepare($koneksi, $query_check_gambar_galeri);
mysqli_stmt_bind_param($stmt_check, 's', $gambar_galeri_to_delete);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);
$row_check = mysqli_fetch_assoc($result_check);
$total_pengguna_gambar_galeri = $row_check['total'];

// Jika tidak ada data lain yang menggunakan file gambar_galeri, hapus gambar_galeri
if ($total_pengguna_gambar_galeri <= 1 && file_exists($gambar_galeri_to_delete)) {
    // Hapus file gambar_galeri dari folder
    if (!unlink($gambar_galeri_to_delete)) {
        echo "error"; // Error saat menghapus file
        exit();
    }
}

// Buat query SQL untuk menghapus data galeri berdasarkan ID
$query_delete_galeri = "DELETE FROM galeri WHERE id_galeri = ?";
$stmt_delete = mysqli_prepare($koneksi, $query_delete_galeri);
mysqli_stmt_bind_param($stmt_delete, 'i', $id_galeri);
if (mysqli_stmt_execute($stmt_delete)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
