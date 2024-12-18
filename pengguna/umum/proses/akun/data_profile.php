<?php
// Lakukan koneksi ke database
include '../../../../keamanan/koneksi.php';

// Cek apakah terdapat data yang dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirimkan melalui form
    $id_mitra = $_POST['id_mitra'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $nomor_hp = $_POST['nomor_hp'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];

    // Lakukan validasi data
    if (empty($nama_lengkap) || empty($nomor_hp) || empty($password)) {
        echo "data tidak lengkap";
        exit();
    }
    // Cek apakah nomor_hp sudah ada di database
    $check_query = "SELECT * FROM mitra WHERE nomor_hp = '$nomor_hp' AND id_mitra != '$id_mitra'";
    $result = mysqli_query($koneksi, $check_query);
    if (mysqli_num_rows($result) > 0) {
        echo "error_nomor_hp_exists"; // Kirim respon "error_email_exists" jika email sudah terdaftar
        exit();
    }
    // Query SQL untuk update data foto profile
    $query = "UPDATE mitra SET nomor_hp='$nomor_hp', password='$password', nama_lengkap='$nama_lengkap', alamat='$alamat' WHERE id_mitra='$id_mitra'";

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
