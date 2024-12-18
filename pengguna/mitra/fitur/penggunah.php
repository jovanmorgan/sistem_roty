<?php
session_start();

// Periksa apakah pengguna sudah masuk atau belum
if (!isset($_SESSION['id_mitra'])) {
    // Pengguna belum masuk, arahkan kembali ke halaman masuk.php
    header("Location: ../../berlangganan/login_public");
    exit; // Pastikan untuk menghentikan eksekusi skrip setelah mengarahkan
}

$id_mitra = $_SESSION['id_mitra'];
