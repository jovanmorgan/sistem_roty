<?php
// Pastikan Anda sudah menghubungkan ke database
include '../../../../keamanan/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $deskripsi = $_POST['deskripsi'];

    // Memeriksa apakah semua data telah diisi
    if (empty($nama) || empty($jenis) || empty($deskripsi)) {
        echo 'data_tidak_lengkap';
        exit;
    }

    // Memeriksa apakah file gambar diunggah
    if (isset($_FILES['gambar_galeri']) && $_FILES['gambar_galeri']['error'] == 0) {
        // Mengambil informasi file gambar
        $file_name = $_FILES['gambar_galeri']['name'];
        $file_tmp = $_FILES['gambar_galeri']['tmp_name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

        // Memeriksa ekstensi file
        if (in_array($file_ext, $allowed_extensions)) {
            // Membuat nama unik untuk file yang akan diunggah
            $new_file_name = uniqid() . '.' . $file_ext;
            $upload_dir = '../../../../assets/img/galeri/'; // Tentukan direktori untuk menyimpan gambar
            $upload_path = $upload_dir . $new_file_name;

            // Memindahkan file yang diunggah ke direktori yang telah ditentukan
            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Menyimpan data ke database
                $query = "INSERT INTO galeri (nama, jenis, deskripsi, gambar_galeri) VALUES ('$nama', '$jenis', '$deskripsi', '$new_file_name')";
                if (mysqli_query($koneksi, $query)) {
                    echo 'success';
                } else {
                    echo 'database_error';
                }
            } else {
                echo 'upload_failed';
            }
        } else {
            echo 'invalid_file_type';
        }
    } else {
        echo 'no_file_uploaded';
    }
} else {
    echo 'invalid_request';
}