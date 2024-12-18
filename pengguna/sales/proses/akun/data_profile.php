<?php
// Lakukan koneksi ke database
include '../../../../keamanan/koneksi.php';

// Cek apakah terdapat data yang dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirimkan melalui form
    $id_sales = $_POST['id_sales'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $password = $_POST['password'];
    $nomor_pengguna = $_POST['nomor_pengguna'];

    // Lakukan validasi data
    if (empty($nama_lengkap) || empty($nomor_pengguna) || empty($password)) {
        echo "data tidak lengkap";
        exit();
    }
    // Cek apakah nomor_pengguna sudah ada di database
    $check_query = "SELECT * FROM admin WHERE nomor_pengguna = '$nomor_pengguna'";
    $result = mysqli_query($koneksi, $check_query);
    if (mysqli_num_rows($result) > 0) {
        echo "error_nomor_pengguna_exists"; // Kirim respon "error_nomor_pengguna_exists" jika email sudah terdaftar
        exit();
    }
    // Cek apakah nomor_pengguna sudah ada di database
    $check_query_sales = "SELECT * FROM sales WHERE nomor_pengguna = '$nomor_pengguna' AND id_sales != '$id_sales'";
    $result_sales = mysqli_query($koneksi, $check_query_sales);
    if (mysqli_num_rows($result_sales) > 0) {
        echo "error_nomor_pengguna_exists"; // Kirim respon "error_nomor_pengguna_exists" jika email sudah terdaftar
        exit();
    }
    // Cek apakah nomor_pengguna sudah ada di database
    $check_query_pimpinan = "SELECT * FROM pimpinan WHERE nomor_pengguna = '$nomor_pengguna'";
    $result_pimpinan = mysqli_query($koneksi, $check_query_pimpinan);
    if (mysqli_num_rows($result_pimpinan) > 0) {
        echo "error_nomor_pengguna_exists"; // Kirim respon "error_nomor_pengguna_exists" jika email sudah terdaftar
        exit();
    }
    // Query SQL untuk update data foto profile
    $query = "UPDATE sales SET password='$password', nama_lengkap='$nama_lengkap', nomor_pengguna='$nomor_pengguna' WHERE id_sales='$id_sales'";

    // Lakukan proses update data foto profile di database
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        echo "success";
        exit();
    } else {
        // Jika terjadi kesalahan saat melakukan proses update, tampilkan pesan kesalahan
        echo "Gagal melakukan proses update data foto profile: " . mysqli_error($koneksi);
    }
} else {
    // Jika metode request bukan POST, berikan respons yang sesuai
    echo "Invalid request method";
    exit();
}

// Tutup koneksi ke database
mysqli_close($koneksi);
