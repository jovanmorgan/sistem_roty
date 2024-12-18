<?php
include '../../../../keamanan/koneksi.php';

// Terima ID roti yang akan dihapus dari formulir HTML
$id_roti = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_roti)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mendapatkan path gambar_roti yang akan dihapus
$query_get_gambar_roti = "SELECT gambar_roti FROM roti WHERE id_roti = ?";
$stmt = mysqli_prepare($koneksi, $query_get_gambar_roti);
mysqli_stmt_bind_param($stmt, 'i', $id_roti);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$gambar_roti_to_delete = $row['gambar_roti'];

// Buat query SQL untuk memeriksa apakah ada data lain yang menggunakan file gambar_roti yang akan dihapus
$query_check_gambar_roti = "SELECT COUNT(*) AS total FROM roti WHERE gambar_roti = ?";
$stmt_check = mysqli_prepare($koneksi, $query_check_gambar_roti);
mysqli_stmt_bind_param($stmt_check, 's', $gambar_roti_to_delete);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);
$row_check = mysqli_fetch_assoc($result_check);
$total_pengguna_gambar_roti = $row_check['total'];

// Jika tidak ada data lain yang menggunakan file gambar_roti, hapus gambar_roti
if ($total_pengguna_gambar_roti <= 1 && file_exists($gambar_roti_to_delete)) {
    // Hapus file gambar_roti dari folder
    if (!unlink($gambar_roti_to_delete)) {
        echo "error"; // Error saat menghapus file
        exit();
    }
}

// Buat query SQL untuk menghapus data roti berdasarkan ID
$query_delete_roti = "DELETE FROM roti WHERE id_roti = ?";
$stmt_delete = mysqli_prepare($koneksi, $query_delete_roti);
mysqli_stmt_bind_param($stmt_delete, 'i', $id_roti);
if (mysqli_stmt_execute($stmt_delete)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
