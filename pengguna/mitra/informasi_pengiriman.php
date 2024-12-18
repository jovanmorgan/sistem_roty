<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">

<?php include('fitur/head_informasi.php'); ?>

<body translate="no">
    <!--=============== HEADER ===============-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="dikirim" class="nav__logo"><i class="bx bx-arrow-back"
                    style="font-size: 2.3em; position: relative; left: 15px;"></i>


            </a>
            <a href="#" class="nav__logo">
                <h1><b>Detail Pengiriman</b></h1>
            </a>

            <div class="nav__kiri">
                <a href="#" class="nav__search-icon">
                    <i class="bx bx-search"></i>
                </a>
            </div>
        </nav>
    </header>

    <?php
    // Memasukkan koneksi dari file eksternal
    include '../../keamanan/koneksi.php';

    // Mengambil nomor_pemesanan dari query string
    $nomor_pemesanan = isset($_GET['nomor_pemesanan']) ? mysqli_real_escape_string($koneksi, $_GET['nomor_pemesanan']) : '';

    // Array untuk menyimpan riwayat pesan
    $riwayat_pesan = [];
    $bukti_pengiriman = '';

    // Mengecek status pesanan di tabel 'dikemas'
    $query_dikemas = "SELECT status FROM dikemas WHERE nomor_pemesanan = '$nomor_pemesanan'";
    $result_dikemas = mysqli_query($koneksi, $query_dikemas);

    if (mysqli_num_rows($result_dikemas) > 0) {
        $row = mysqli_fetch_assoc($result_dikemas);
        if ($row['status'] == 'belum_dikemas') {
            $riwayat_pesan[] = 'Pesanan sementara dikemas, mohon tunggu sebentar.';
        } elseif ($row['status'] == 'sudah_dikemas') {
            $riwayat_pesan[] = 'Pesanan sudah dikemas, mohon tunggu pengiriman.';
        }
    }

    // Mengecek status pesanan di tabel 'dikirim'
    $query_dikirim = "SELECT status FROM dikirim WHERE nomor_pemesanan = '$nomor_pemesanan'";
    $result_dikirim = mysqli_query($koneksi, $query_dikirim);

    if (mysqli_num_rows($result_dikirim) > 0) {
        $row = mysqli_fetch_assoc($result_dikirim);
        if ($row['status'] == 'belum_diterima') {
            $riwayat_pesan[] = 'Pesanan sudah diambil kurir, sementara menuju ke lokasi Anda.';
        } elseif ($row['status'] == 'sudah_diterima') {
            $riwayat_pesan[] = 'Pesanan sudah diterima mitra.';
        }
    }

    // Mengecek status pesanan di tabel 'diterima'
    $query_diterima = "SELECT status, bukti_pengiriman FROM diterima WHERE nomor_pemesanan = '$nomor_pemesanan'";
    $result_diterima = mysqli_query($koneksi, $query_diterima);

    if (mysqli_num_rows($result_diterima) > 0) {
        $row = mysqli_fetch_assoc($result_diterima);
        if ($row['status'] == 'sudah_diterima') {
            $riwayat_pesan[] = 'Terimakan sudah memesan di Fasya Bakery 😊.';
            $bukti_pengiriman = $row['bukti_pengiriman']; // Path atau URL ke gambar bukti pengiriman
        }
    }

    // Menutup koneksi
    mysqli_close($koneksi);

    // Menentukan pesan terakhir
    $pesan_terakhir = end($riwayat_pesan);
    ?>


    <section id="resume" class="resume mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h4 class="resume-title text-center">Status Pengiriman</h4>
                            <hr />
                            <div class="pd" style="padding: 15px">
                                <?php foreach ($riwayat_pesan as $index => $pesan): ?>
                                    <div
                                        class="resume-item <?php echo ($index === array_key_last($riwayat_pesan)) ? 'latest-update' : ''; ?>">
                                        <h4><?php echo $pesan; ?></h4>
                                    </div>
                                <?php endforeach; ?>
                                <?php if (!empty($bukti_pengiriman)): ?>
                                    <div class="resume-item latest-update">
                                        <h4 onclick="openSearchPopup()">
                                            <a href="#" class="">Lihat Bukti</a>
                                        </h4>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popup pencarian -->
    <div class="search-popup" id="searchPopup">
        <div class="search-popup-content">
            <div class="popup-header">
                <h3>Cari Roti Favorit Anda</h3>
                <a href="#" class="close-btn" onclick="closeSearchPopup()">
                    <i class="bx bx-x"></i>
                </a>
            </div>
            <form class="search-form d-flex align-items-center" method="POST" action="fitur/search.php">
                <input type="text" name="query" placeholder="Masukkan kata kunci..." title="Enter search keyword" />
                <button type="submit"><i class="bx bx-search"></i></button>
            </form>
        </div>
    </div>
    <?php include('fitur/js_1.php'); ?>
</body>

</html>