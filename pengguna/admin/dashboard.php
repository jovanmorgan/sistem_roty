<!-- penggunah -->
<?php include 'fitur/penggunah.php'; ?>

<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<?php include 'fitur/head.php'; ?>

<body translate="no">

    <!-- Header -->
    <?php include 'fitur/header.php'; ?>

    <!-- sidebar -->
    <?php include 'fitur/sidebar.php'; ?>

    <main id="main" class="main">

        <!-- title -->
        <?php include 'fitur/title.php'; ?>
        <?php include 'fitur/nama_halaman.php'; ?>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 30px;">Halaman Datang</h5>
                            <p>
                                Silakan lihat informsi yang kami sajikan pada website ini, sistem ini berfungsi untuk
                                membantu penjualan toko <span style="color: #FF8000">Fasya Bekry</span>. berikut adalah
                                informasi data pada Halaman
                                <?= $page_title ?>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
        include '../../keamanan/koneksi.php';

        // Query untuk mendapatkan data roti terlaris berdasarkan jumlah pesanan
        $query_roti = "
        SELECT roti.nama_roti, COUNT(pemesanan.id_pemesanan) as total_pesanan
        FROM pemesanan
        INNER JOIN roti ON pemesanan.id_roti = roti.id_roti
        GROUP BY roti.nama_roti
        ORDER BY total_pesanan DESC
        LIMIT 7
    ";
        $result_roti = mysqli_query($koneksi, $query_roti);

        $roti_nama = [];
        $total_pesanan = [];

        while ($row_roti = mysqli_fetch_assoc($result_roti)) {
            $roti_nama[] = $row_roti['nama_roti'];
            $total_pesanan[] = $row_roti['total_pesanan'];
        }

        mysqli_free_result($result_roti);

        // Query untuk mendapatkan jumlah checkout per hari berdasarkan waktu pada tabel pemesanan
        $query_checkout = "
        SELECT DATE(pemesanan.waktu) AS hari, COUNT(checkout.id_checkout) AS total_checkout
        FROM checkout
        INNER JOIN pemesanan ON checkout.nomor_pemesanan = pemesanan.nomor_pemesanan
        GROUP BY DATE(pemesanan.waktu)
        ORDER BY DATE(pemesanan.waktu)
    ";
        $result_checkout = mysqli_query($koneksi, $query_checkout);

        $hari_checkout = [];
        $total_checkout = [];

        while ($row_checkout = mysqli_fetch_assoc($result_checkout)) {
            $hari_checkout[] = date("d F Y", strtotime($row_checkout['hari']));
            $total_checkout[] = $row_checkout['total_checkout'];
        }

        mysqli_free_result($result_checkout);

        // Query untuk mendapatkan jumlah dibatalkan per hari berdasarkan waktu pada tabel pemesanan
        $query_dibatalkan = "
        SELECT DATE(pemesanan.waktu) AS hari, COUNT(dibatalkan.id_dibatalkan) AS total_dibatalkan
        FROM dibatalkan
        INNER JOIN pemesanan ON dibatalkan.nomor_pemesanan = pemesanan.nomor_pemesanan
        GROUP BY DATE(pemesanan.waktu)
        ORDER BY DATE(pemesanan.waktu)
    ";
        $result_dibatalkan = mysqli_query($koneksi, $query_dibatalkan);

        $hari_dibatalkan = [];
        $total_dibatalkan = [];

        while ($row_dibatalkan = mysqli_fetch_assoc($result_dibatalkan)) {
            $hari_dibatalkan[] = date("d F Y", strtotime($row_dibatalkan['hari']));
            $total_dibatalkan[] = $row_dibatalkan['total_dibatalkan'];
        }

        mysqli_free_result($result_dibatalkan);

        // Query untuk mendapatkan jumlah roti yang paling banyak dibatalkan
        $query_roti_dibatalkan = "
        SELECT roti.nama_roti, COUNT(dibatalkan.id_dibatalkan) AS total_dibatalkan
        FROM dibatalkan
        INNER JOIN pemesanan ON dibatalkan.nomor_pemesanan = pemesanan.nomor_pemesanan
        INNER JOIN roti ON pemesanan.id_roti = roti.id_roti
        GROUP BY roti.nama_roti
        ORDER BY total_dibatalkan DESC
        LIMIT 7
    ";
        $result_roti_dibatalkan = mysqli_query($koneksi, $query_roti_dibatalkan);

        $roti_nama_dibatalkan = [];
        $total_dibatalkan_roti = [];

        while ($row_roti_dibatalkan = mysqli_fetch_assoc($result_roti_dibatalkan)) {
            $roti_nama_dibatalkan[] = $row_roti_dibatalkan['nama_roti'];
            $total_dibatalkan_roti[] = $row_roti_dibatalkan['total_dibatalkan'];
        }

        mysqli_free_result($result_roti_dibatalkan);


        // Query untuk menghitung jumlah data pada setiap tabel
        $tables = [
            'checkout' => ['label' => 'Checkout', 'icon' => 'ri-money-dollar-circle-fill', 'color' => '#FFC107'], // Yellow
            'dibatalkan' => ['label' => 'Dibatalkan', 'icon' => 'bi bi-x-circle', 'color' => '#DC3545'], // Red
            'dikemas' => ['label' => 'Dikemas', 'icon' => 'bi bi-box-seam', 'color' => '#0D6EFD'], // Blue
            'dikirim' => ['label' => 'Dikirim', 'icon' => 'bi bi-truck', 'color' => '#0332cf'], // Green
            'diterima' => ['label' => 'Diterima', 'icon' => 'bi bi-check-circle', 'color' => '#198754'], // Gray
            'galeri' => ['label' => 'Galeri', 'icon' => 'bi bi-images', 'color' => '#17A2B8'], // Teal
            'keranjang' => ['label' => 'Keranjang', 'icon' => 'ri-shopping-cart-2-line', 'color' => '#FFC107'], // Yellow
            'kontak' => ['label' => 'Kontak', 'icon' => 'bi bi-telephone', 'color' => '#6C757D'], // Gray
            'mitra' => ['label' => 'Mitra', 'icon' => 'bi bi-file-earmark-person-fill', 'color' => '#0D6EFD'], // Blue
            'admin' => ['label' => 'admin', 'icon' => 'bi bi-person-badge', 'color' => '#198754'], // Green
            'promo' => ['label' => 'Promo', 'icon' => 'bi bi-tag', 'color' => '#DC3545'], // Red
            'roti' => ['label' => 'Roti', 'icon' => 'ri-cake-2-fill', 'color' => '#17A2B8'], // Teal
            'sales' => ['label' => 'Sales', 'icon' => 'ri-user-2-fill', 'color' => '#FFC107'], // Yellow
        ];

        $counts = [];

        foreach ($tables as $table => $details) {
            $query = "SELECT COUNT(*) as count FROM $table";
            $result = mysqli_query($koneksi, $query);
            $row = mysqli_fetch_assoc($result);
            $counts[$table] = $row['count'];
            mysqli_free_result($result);
        }

        mysqli_close($koneksi);
        ?>

        <section class="section">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Roti Terlaris</h5>
                            <!-- Bar Chart -->
                            <canvas id="barChart" style="max-height: 400px"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new Chart(document.querySelector("#barChart"), {
                                        type: "bar",
                                        data: {
                                            labels: <?= json_encode($roti_nama); ?>,
                                            datasets: [{
                                                label: "Total Pesanan",
                                                data: <?= json_encode($total_pesanan); ?>,
                                                backgroundColor: [
                                                    "rgba(255, 99, 132, 0.2)",
                                                    "rgba(255, 159, 64, 0.2)",
                                                    "rgba(255, 205, 86, 0.2)",
                                                    "rgba(75, 192, 192, 0.2)",
                                                    "rgba(54, 162, 235, 0.2)",
                                                    "rgba(153, 102, 255, 0.2)",
                                                    "rgba(201, 203, 207, 0.2)",
                                                ],
                                                borderColor: [
                                                    "rgb(255, 99, 132)",
                                                    "rgb(255, 159, 64)",
                                                    "rgb(255, 205, 86)",
                                                    "rgb(75, 192, 192)",
                                                    "rgb(54, 162, 235)",
                                                    "rgb(153, 102, 255)",
                                                    "rgb(201, 203, 207)",
                                                ],
                                                borderWidth: 1,
                                            }],
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                },
                                            },
                                        },
                                    });
                                });
                            </script>
                            <!-- End Bar Chart -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Checkout Per Hari</h5>
                            <!-- Line Chart -->
                            <canvas id="checkoutChart" style="max-height: 400px"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new Chart(document.querySelector("#checkoutChart"), {
                                        type: "line",
                                        data: {
                                            labels: <?= json_encode($hari_checkout); ?>,
                                            datasets: [{
                                                label: "Jumlah Chackout",
                                                data: <?= json_encode($total_checkout); ?>,
                                                backgroundColor: "rgba(220, 53, 69, 0.2)",
                                                borderColor: "rgba(220, 53, 69, 1)",
                                                borderWidth: 1,
                                                fill: true,
                                            }],
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                },
                                            },
                                        },
                                    });
                                });
                            </script>
                            <!-- End Line Chart -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Dibatalkan Per Hari</h5>
                            <!-- Line Chart -->
                            <canvas id="dibatalkanChart" style="max-height: 400px"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new Chart(document.querySelector("#dibatalkanChart"), {
                                        type: "line",
                                        data: {
                                            labels: <?= json_encode($hari_dibatalkan); ?>,
                                            datasets: [{
                                                label: "Jumlah Dibatalkan",
                                                data: <?= json_encode($total_dibatalkan); ?>,
                                                backgroundColor: "rgba(220, 53, 69, 0.2)",
                                                borderColor: "rgba(220, 53, 69, 1)",
                                                borderWidth: 1,
                                                fill: true,
                                            }],
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                },
                                            },
                                        },
                                    });
                                });
                            </script>
                            <!-- End Line Chart -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Roti Paling Banyak Dibatalkan</h5>
                            <!-- Bar Chart -->
                            <canvas id="rotiDibatalkanChart" style="max-height: 400px"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new Chart(document.querySelector("#rotiDibatalkanChart"), {
                                        type: "bar",
                                        data: {
                                            labels: <?= json_encode($roti_nama_dibatalkan); ?>,
                                            datasets: [{
                                                label: "Jumlah Dibatalkan",
                                                data: <?= json_encode($total_dibatalkan_roti); ?>,
                                                backgroundColor: [
                                                    "rgba(255, 99, 132, 0.2)",
                                                    "rgba(255, 159, 64, 0.2)",
                                                    "rgba(255, 205, 86, 0.2)",
                                                    "rgba(75, 192, 192, 0.2)",
                                                    "rgba(54, 162, 235, 0.2)",
                                                    "rgba(153, 102, 255, 0.2)",
                                                    "rgba(201, 203, 207, 0.2)",
                                                ],
                                                borderColor: [
                                                    "rgb(255, 99, 132)",
                                                    "rgb(255, 159, 64)",
                                                    "rgb(255, 205, 86)",
                                                    "rgb(75, 192, 192)",
                                                    "rgb(54, 162, 235)",
                                                    "rgb(153, 102, 255)",
                                                    "rgb(201, 203, 207)",
                                                ],
                                                borderWidth: 1,
                                            }],
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                },
                                            },
                                        },
                                    });
                                });
                            </script>
                            <!-- End Bar Chart -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section dashboard">
            <div class="row">
                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row">
                        <?php foreach ($tables as $table => $details): ?>
                            <div class="col-xxl-4 col-md-4">
                                <div class="card info-card sales-card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $details['label']; ?> <span>| Fasya Bakery</span></h5>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="<?= $details['icon']; ?>"
                                                    style="color: <?= $details['color']; ?>;"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6><?= $counts[$table]; ?></h6>
                                                <span class="text-muted small pt-2 ps-1">Semua data
                                                    <?= strtolower($details['label']); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="icon_bagian_luar"><i class="<?= $details['icon']; ?>"
                                            style="color: <?= $details['color']; ?>;"></i></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- End Left side columns -->
            </div>
        </section>

    </main>
    <!-- End #main -->

    <?php include 'fitur/bagian_akhir.php'; ?>

</body>

</html>