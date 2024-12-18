<?php
session_start();

// Periksa apakah pengguna sudah masuk atau belum
if (!isset($_SESSION['id_sales'])) {
    // Pengguna belum masuk, arahkan kembali ke halaman masuk.php
    header("Location: ../../berlangganan/login_privasi");
    exit; // Pastikan untuk menghentikan eksekusi skrip setelah mengarahkan
}

$id_sales = $_SESSION['id_sales'];
