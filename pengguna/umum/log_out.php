<?php
session_start();

// Hapus sesi id_mitra jika ada
if (isset($_SESSION['id_mitra'])) {
    unset($_SESSION['id_mitra']);
}

// Redirect pengguna kembali ke halaman login_public
header("Location: ../../berlangganan/login_public");
exit;
