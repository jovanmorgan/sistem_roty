<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$nama = $_POST['nama'];
$nomor_hp = $_POST['nomor_hp'];
$judul = $_POST['judul'];
$pesan = $_POST['pesan'];
$tanggal = date('Y-m-d H:i:s');

// Lakukan validasi data
if (empty($nama) || empty($nomor_hp) || empty($judul) || empty($pesan)) {
    echo "data_tidak_lengkap";
    exit();
}

// Ubah baris baru pada judul menjadi <br>
$judul = nl2br(htmlspecialchars($judul));

// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO kontak (nama, nomor_hp, judul, pesan, tanggal) 
        VALUES ('$nama', '$nomor_hp', '$judul', '$pesan', '$tanggal')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
