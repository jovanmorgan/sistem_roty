<?php
// Daftar halaman yang tersedia
$pages = [
    '../dashboard' => 'Dashboard',
    '../roti' => 'Roti',
    '../promo' => 'Promo',
    '../chack_out' => 'Check Out',
    '../belum_bayar' => 'Belum Bayar',
    '../dikemas' => 'Dikemas',
    '../dikirim' => 'Dikirim',
    '../diterima' => 'Diterima',
    '../dibatalkan' => 'Dibatalkan',
    '../mitra' => 'Mitra',
    '../sales' => 'Sales',
    '../pimpinan' => 'Pimpinan',
    '../galeri' => 'Galeri',
    '../kontak' => 'Kontak',
    '../profile' => 'Profile',
    '../bank' => 'Bank',
    '../log_out' => 'Log Out'
];

// Dapatkan query pencarian dari input
$query = isset($_POST['query']) ? strtolower(trim($_POST['query'])) : '';

// Variabel untuk menyimpan halaman yang cocok
$matched_page = null;

if ($query) {
    // Cari halaman yang tepat atau mendekati
    foreach ($pages as $page => $title) {
        if (strpos(strtolower($title), $query) !== false) {
            $matched_page = $page;
            break;
        }
    }

    // Redirect ke halaman yang cocok, atau ke halaman 404 jika tidak ada yang cocok
    if ($matched_page) {
        header("Location: $matched_page");
    } else {
        header("Location: ../404");
    }
    exit;
}