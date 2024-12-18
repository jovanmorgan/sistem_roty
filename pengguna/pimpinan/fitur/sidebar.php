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