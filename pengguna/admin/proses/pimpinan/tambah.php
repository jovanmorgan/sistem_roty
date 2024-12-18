<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$nama_lengkap = $_POST['nama_lengkap'];
$nomor_pengguna = $_POST['nomor_pengguna'];
$password = $_POST['password'];

// Lakukan validasi data
if (empty($nama_lengkap) || empty($nomor_pengguna) || empty($password)) {
    echo "data_tidak_lengkap";
    exit();
}

// Cek apakah nomor_pengguna sudah ada di database
$check_query = "SELECT * FROM pimpinan WHERE nomor_pengguna = '$nomor_pengguna'";
$result = mysqli_query($koneksi, $check_query);
if (mysqli_num_rows($result) > 0) {
    echo "error_nomor_pengguna_exists"; // Kirim respon "error_email_exists" jika email sudah terdaftar
    exit();
}

// Cek apakah nomor_pengguna sudah ada di database
$check_query_sales = "SELECT * FROM sales WHERE nomor_pengguna = '$nomor_pengguna'";
$result_sales = mysqli_query($koneksi, $check_query_sales);
if (mysqli_num_rows($result_sales) > 0) {
    echo "error_nomor_pengguna_exists"; // Kirim respon "error_email_exists" jika email sudah terdaftar
    exit();
}
// Cek apakah nomor_pengguna sudah ada di database
$check_query_admin = "SELECT * FROM admin WHERE nomor_pengguna = '$nomor_pengguna'";
$result_admin = mysqli_query($koneksi, $check_query_admin);
if (mysqli_num_rows($result_admin) > 0) {
    echo "error_nomor_pengguna_exists"; // Kirim respon "error_email_exists" jika email sudah terdaftar
    exit();
}

if (strlen($password) < 8) {
    echo "error_password_length"; // Kirim respon "error_password_length" jika panjang password kurang dari 8 karakter
    exit();
}

// Tambahkan logika untuk memeriksa password
if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/", $password)) {
    echo "error_password_strength"; // Kirim respon "error_password_strength" jika password tidak memenuhi syarat
    exit();
}

// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO pimpinan (nama_lengkap, nomor_pengguna, password) 
        VALUES ('$nama_lengkap','$nomor_pengguna', '$password')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
