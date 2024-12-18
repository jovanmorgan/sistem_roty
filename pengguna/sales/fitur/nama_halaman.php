<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Tentukan judul halaman berdasarkan nama file
switch ($current_page) {
    case 'dashboard':
        $page_title = 'Dashboard';
        break;
    case 'roti':
        $page_title = 'Roti';
        break;
    case 'promo':
        $page_title = 'Promo';
        break;
    case 'chack_out':
        $page_title = 'Check Out';
        break;
    case 'belum_bayar':
        $page_title = 'Belum Bayar';
        break;
    case 'dikemas':
        $page_title = 'Dikemas';
        break;
    case 'dikirim':
        $page_title = 'Dikirim';
        break;
    case 'diterima':
        $page_title = 'Diterima';
        break;
    case 'dibatalkan':
        $page_title = 'Dibatalkan';
        break;
    case 'mitra':
        $page_title = 'Mitra';
        break;
    case 'sales':
        $page_title = 'Sales';
        break;
    case 'galeri':
        $page_title = 'Galeri';
        break;
    case 'kontak':
        $page_title = 'Kontak';
        break;
    case 'profile':
        $page_title = 'Profile';
        break;
    case 'bank':
        $page_title = 'Bank';
        break;
    case 'pimpinan':
        $page_title = 'Pimpinan';
        break;
    case 'roti_tambah':
        $page_title = 'Tambah Roti';
        break;
    case 'suplay':
        $page_title = 'Suplay';
        break;
    case 'chack_out_detail':
        $page_title = 'Detail Chack Out';
        break;
    case 'belum_bayar_detail':
        $page_title = 'Detail Belum Bayar';
        break;
    case 'dikemas_detail':
        $page_title = 'Detail Dikemas';
        break;
    case 'dikirim_detail':
        $page_title = 'Detail Dikirim';
        break;
    case 'diterima_detail':
        $page_title = 'Detail Diterima';
        break;
    case 'dibatalkan_detail':
        $page_title = 'Detail Dibatalkan';
        break;
    case 'log_out':
        $page_title = 'Log Out';
        break;
    default:
        $page_title = 'admin Fasya Bakery';
        break;
}
