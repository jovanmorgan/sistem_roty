<?php
session_start();

// Hapus sesi id_sales jika ada
if (isset($_SESSION['id_sales'])) {
    unset($_SESSION['id_sales']);
}

// Redirect pengguna kembali ke halaman login_privasi
header("Location: ../../berlangganan/login_privasi");
exit;
