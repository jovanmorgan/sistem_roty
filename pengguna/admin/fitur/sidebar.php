<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");
?>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'dashboard') ? '' : 'collapsed'; ?>" href="dashboard">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!-- bagian produk -->
        <li class="nav-item">
            <a class="nav-link <?= in_array($current_page, ['roti', 'promo', 'suplay']) ? '' : 'collapsed'; ?>"
                data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-box-seam"></i><span>Produk</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav"
                class="nav-content collapse <?= in_array($current_page, ['roti', 'promo', 'suplay']) ? 'show' : ''; ?>"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="roti"
                        class="<?= ($current_page == 'roti' || $current_page == 'roti_tambah') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i>
                        <span>Roti</span>
                    </a>
                </li>
                <li>
                    <a href="promo" class="<?= ($current_page == 'promo') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i>
                        <span>Promo</span>
                    </a>
                </li>
                <li>
                    <a href="suplay" class="<?= ($current_page == 'suplay') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i>
                        <span>Suplay</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- akhir bagian produk -->

        <!-- bagian transaksi -->
        <li class="nav-item">
            <a class="nav-link <?= in_array($current_page, ['chack_out', 'belum_bayar', 'dikemas', 'dikirim', 'diterima', 'dibatalkan']) ? '' : 'collapsed'; ?>"
                data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-currency-dollar"></i><span>Transaksi</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav"
                class="nav-content collapse <?= in_array($current_page, ['chack_out', 'belum_bayar', 'dikemas', 'dikirim', 'diterima', 'dibatalkan']) ? 'show' : ''; ?>"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="chack_out" class="<?= ($current_page == 'chack_out') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i>
                        <span>Check Out</span>
                    </a>
                </li>
                <li>
                    <a href="belum_bayar" class="<?= ($current_page == 'belum_bayar') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i>
                        <span>Belum Bayar</span>
                    </a>
                </li>
                <li>
                    <a href="dikemas" class="<?= ($current_page == 'dikemas') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i>
                        <span>Dikemas</span>
                    </a>
                </li>
                <li>
                    <a href="dikirim" class="<?= ($current_page == 'dikirim') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i>
                        <span>Dikirim</span>
                    </a>
                </li>
                <li>
                    <a href="diterima" class="<?= ($current_page == 'diterima') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i>
                        <span>Diterima</span>
                    </a>
                </li>
                <li>
                    <a href="dibatalkan" class="<?= ($current_page == 'dibatalkan') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i>
                        <span>Dibatalkan</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- akhir bagian transaksi -->

        <!-- bagian pengguna -->
        <li class="nav-item">
            <a class="nav-link <?= in_array($current_page, ['mitra', 'sales', 'pimpinan']) ? '' : 'collapsed'; ?>"
                data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-people"></i><span>Pengguna</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav"
                class="nav-content collapse <?= in_array($current_page, ['mitra', 'sales', 'pimpinan']) ? 'show' : ''; ?>"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="mitra" class="<?= ($current_page == 'mitra') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i>
                        <span>Mitra</span>
                    </a>
                </li>
                <li>
                    <a href="sales" class="<?= ($current_page == 'sales') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i>
                        <span>Sales</span>
                    </a>
                </li>
                <li>
                    <a href="pimpinan" class="<?= ($current_page == 'pimpinan') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i>
                        <span>Pimpinan</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- akhir bagian pengguna -->

        <!-- galeri -->
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'galeri') ? '' : 'collapsed'; ?>" href="galeri">
                <i class="bi bi-images"></i>
                <span>Galeri</span>
            </a>
        </li>
        <!-- kontak -->
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'kontak') ? '' : 'collapsed'; ?>" href="kontak">
                <i class="bi bi-telephone"></i>
                <span>Kontak</span>
            </a>
        </li>
        <!-- Bank -->
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'bank') ? '' : 'collapsed'; ?>" href="bank">
                <i class="ri-bank-line"></i>
                <span>Bank</span>
            </a>
        </li>

        <li class="nav-heading">Bagian Akun</li>

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'profile') ? '' : 'collapsed'; ?>" href="profile">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'log_out') ? '' : 'collapsed'; ?>" href="log_out">
                <i class="bi bi-box-arrow-right"></i>
                <span>Log Out</span>
            </a>
        </li>
        <!-- End Contact Page Nav -->
    </ul>
</aside>

<!-- End Sidebar-->