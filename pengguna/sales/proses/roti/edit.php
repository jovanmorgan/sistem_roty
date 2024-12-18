<?php
include '../../../../keamanan/koneksi.php';

$id_roti = $_POST['id_roti'];
$nama_roti = $_POST['nama_roti'];
$harga = $_POST['harga'];
$berat = $_POST['berat'];
$rasa = $_POST['rasa'];
$vitamin = $_POST['vitamin'];
$gula = $_POST['gula'];
$deskripsi = $_POST['deskripsi'];
$stok = $_POST['stok']; // Tambahkan ini

// Lakukan validasi data
if (empty($id_roti) || empty($nama_roti) || empty($harga) || empty($berat)) {
    echo "data_tidak_lengkap";
    exit();
}

// Proses upload file
$kover_path = '';
if (isset($_FILES['gambar_roti']) && $_FILES['gambar_roti']['error'] == 0) {
    $kover_name = $_FILES['gambar_roti']['name'];
    $kover_tmp = $_FILES['gambar_roti']['tmp_name'];
    $kover_path = '../../../../assets/img/roti/' . basename($kover_name);

    // Simpan file gambar_roti di folder tujuan
    if (!move_uploaded_file($kover_tmp, $kover_path)) {
        echo "error";
        exit();
    }
}

// Konversi tag <br> kembali menjadi newline (\n)
$deskripsi_data = str_replace('<br>', "\n", $deskripsi);

// Buat query SQL untuk mengupdate data
$query_update = "UPDATE roti SET 
    nama_roti = '$nama_roti', 
    harga = '$harga', 
    berat = '$berat', 
    rasa = '$rasa', 
    vitamin = '$vitamin', 
    gula = '$gula', 
    deskripsi = '$deskripsi_data', 
    stok = '$stok'"; // Tambahkan ini

// Tambahkan kolom gambar_roti jika ada file baru yang diupload
if (!empty($kover_path)) {
    $query_update .= ", gambar_roti = '$kover_name'";
}

$query_update .= " WHERE id_roti = '$id_roti'";

// Jalankan query
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
