<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">

<?php include('fitur/head_1.php'); ?>

<body translate="no">
    <!--=============== HEADER ===============-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="akun" class="nav__logo"><i class="bx bx-arrow-back"
                    style="font-size: 2.3em; position: relative; left: 15px;"></i>
            </a>
            <a href="#" class="nav__logo">
                <h1><b>Pesanan Saya</b></h1>
            </a>

            <div class="nav__kiri">
                <a href="#" class="nav__search-icon">
                    <i class="bx bx-search"></i>
                </a>
            </div>
        </nav>
    </header>
    <section style="background-color: #eee">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4"></nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-5">
                    <?php
                    include '../../keamanan/koneksi.php';

                    // Fungsi untuk menghitung jumlah data belum dibaca
                    function getCount($table)
                    {
                        global $koneksi;
                        $query = "SELECT COUNT(*) AS jumlah FROM $table WHERE dilihat = ''";
                        $result = mysqli_query($koneksi, $query);

                        // Cek apakah query berhasil
                        if (!$result) {
                            die("Query Error: " . mysqli_error($koneksi));
                        }

                        $row = mysqli_fetch_assoc($result);
                        return $row['jumlah'];
                    }

                    // Menghitung jumlah data dari masing-masing tabel
                    $belum_bayar_count = getCount('checkout');
                    $dikemas_count = getCount('dikemas');
                    $dikirim_count = getCount('dikirim');
                    $diterima_count = getCount('diterima');
                    $dibatalkan_count = getCount('dibatalkan');

                    // Menutup koneksi
                    mysqli_close($koneksi);
                    ?>

                    <!-- bagian pesanan saya -->
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-0">
                            <!-- pada bagian pemesanan ini taru icon belum bayar, diterima, dikirim, dan diterima dan berikan dengan angka pada iconnya di pojok kanan atas -->
                            <div class="order-status">
                                <div class="status-item">
                                    <a href="belum_bayar" id="belum_bayar_btn" class="text-secondary">
                                        <i class="fas fa-money-bill-wave fa-lg"></i>
                                        <?php if ($belum_bayar_count > 0): ?>
                                            <span class="badge b1"><?php echo $belum_bayar_count; ?></span>
                                        <?php endif; ?>
                                        <p class="mb-0 belum_bayar">Belum Bayar</p>
                                    </a>
                                </div>
                                <div class="status-item">
                                    <a href="diterima" id="dikemas_btn" class="text-secondary">
                                        <i class="fas fa-box fa-lg"></i>
                                        <?php if ($dikemas_count > 0): ?>
                                            <span class="badge b2"><?php echo $dikemas_count; ?></span>
                                        <?php endif; ?>
                                        <p class="mb-0 diterima">Diterima</p>
                                    </a>
                                </div>
                                <div class="status-item">
                                    <a href="dikirim" id="dikirim_btn" class="text-secondary">
                                        <i class="fas fa-truck fa-lg"></i>
                                        <?php if ($dikirim_count > 0): ?>
                                            <span class="badge b3"><?php echo $dikirim_count; ?></span>
                                        <?php endif; ?>
                                        <p class="mb-0 dikirim">Dikirim</p>
                                    </a>
                                </div>
                                <div class="status-item">
                                    <a href="diterima" id="diterima_btn" class="text-success">
                                        <i class="fas fa-check-circle fa-lg"></i>
                                        <?php if ($diterima_count > 0): ?>
                                            <span class="badge b4"><?php echo $diterima_count; ?></span>
                                        <?php endif; ?>
                                        <p class="mb-0">Diterima</p>
                                    </a>
                                </div>
                                <div class="status-item">
                                    <a href="dibatalkan" id="dibatalkan_btn" class="text-secondary dibatalkan">
                                        <i class="fas fa-times-circle fa-lg"></i>
                                        <?php if ($dibatalkan_count > 0): ?>
                                            <span class="badge b5"><?php echo $dibatalkan_count; ?></span>
                                        <?php endif; ?>
                                        <p class="mb-0 dibatalkan">Dibatalkan</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <?php
                include '../../keamanan/koneksi.php';

                // Ambil semua nomor_pemesanan dari tabel diterima dengan status 'sudah_diterima'
                $diterima_query = "SELECT DISTINCT nomor_pemesanan FROM diterima WHERE id_mitra = $id_mitra ORDER BY id_diterima DESC";
                $diterima_result = mysqli_query($koneksi, $diterima_query);

                if (!$diterima_result || mysqli_num_rows($diterima_result) == 0) {
                    echo '<div class="col-lg-7">
    <div class="card mb-4">
        <div class="card-body">
            <!-- bagian data data belum dibayar -->
            <h4 class="text-center" style="position: relative; top: 12px">
                <b class="warna_orange">Belum Bayar</b>
            </h4>
        </div>
        </div>
        <div class="card mb-4">
        <div class="card-body">
            <!-- bagian data data belum dibayar -->
            <h5 class="text-center" style="position: relative; top: 12px; font-size: 16px">
                <b class="text-secondary">Anda tidak memiliki pesanan yang diterima 😊</b>
            </h5>
        </div>
        </div>
    </div>';
                    mysqli_close($koneksi);
                    exit();
                }
                ?>
                <!-- Popup pencarian -->
                <div class="search-popup" id="searchPopup">
                    <div class="search-popup-content">
                        <div class="popup-header">
                            <h3>Cari Nomor Pemesanan</h3>
                            <a href="#" class="close-btn" onclick="closeSearchPopup()">
                                <i class="bx bx-x"></i>
                            </a>
                        </div>
                        <form id="searchForm" onsubmit="event.preventDefault(); performSearch();">
                            <input type="text" id="searchInput" placeholder="Masukkan nomor pemesanan" />
                            <button type="button" onclick="performSearch()"><i class="bx bx-search"></i></button>
                        </form>
                        <div id="searchResults"></div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- bagian data data Diterima -->
                            <h4 class="text-center" style="position: relative; top: 12px">
                                <b class="text-success">Diterima</b>
                            </h4>
                        </div>
                    </div>

                    <?php
                    $counter = 0; // Inisialisasi counter untuk membuat ID yang unik
                    // Loop untuk setiap nomor_pemesanan
                    while ($diterima_row = mysqli_fetch_assoc($diterima_result)) {
                        $nomor_pemesanan = $diterima_row['nomor_pemesanan'];

                        // Ambil data pesanan dari tabel pemesanan untuk setiap nomor_pemesanan
                        $pemesanan_query = "SELECT p.id_pemesanan, p.id_roti, p.nomor_pemesanan, p.jumlah, p.waktu, p.total,
                                        r.nama_roti, r.harga, r.gambar_roti, r.rasa
                                        FROM pemesanan p
                                        JOIN roti r ON p.id_roti = r.id_roti
                                        WHERE p.nomor_pemesanan = '$nomor_pemesanan' AND id_mitra = '$id_mitra'";
                        $pemesanan_result = mysqli_query($koneksi, $pemesanan_query);

                        if (!$pemesanan_result) {
                            echo '<p style="text-align: center; margin-top: 100px">Terjadi kesalahan saat mengambil data pesanan. Silakan cek koneksi Anda atau hubungi kami.</p>';
                            mysqli_close($koneksi);
                            exit();
                        }

                        // Simpan data pesanan ke dalam array
                        $pemesanan_data = [];
                        while ($row = mysqli_fetch_assoc($pemesanan_result)) {
                            $pemesanan_data[] = $row;
                        }

                    ?>

                        <div class="card mb-4" data-nomor-pemesanan="<?php echo htmlspecialchars($nomor_pemesanan); ?>">
                            <div class="card-body">
                                <div class="nomor-pemesanan">
                                    Nomor Pemesanan: <b
                                        class="text-success"><?php echo htmlspecialchars($nomor_pemesanan); ?></b>
                                </div>
                                <hr />
                                <?php if (!empty($pemesanan_data)): ?>
                                    <?php foreach ($pemesanan_data as $item): ?>
                                        <!-- Mulai dari sini -->
                                        <div class="order-item">
                                            <div class="order-img">
                                                <img src="img/fb/<?php echo htmlspecialchars($item['gambar_roti']); ?>"
                                                    alt="Gambar Roti" />
                                            </div>
                                            <div class="order-details">
                                                <h6>Nama Roti: <?php echo htmlspecialchars($item['nama_roti']); ?></h6>
                                                <p>Jenis: <?php echo htmlspecialchars($item['rasa']); ?></p>
                                                <p>Jumlah: <?php echo htmlspecialchars($item['jumlah']); ?></p>
                                                <p>Harga: Rp. <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p style="text-align: center; margin-top: 100px">Tidak ada data pesanan untuk nomor
                                        pemesanan ini.</p>
                                <?php endif; ?>
                                <div class="timer mb-3 text-end text-dark">
                                    Terimakasi Sudah Memesan Roti Kami! 😊
                                </div>
                                <!-- Tambahkan lebih banyak item pesanan di sini -->
                                <hr />
                                <!-- Tombol Bayar Sekarang, Batas Waktu, dan Total Harga -->
                                <form id="formBatal-<?php echo $nomor_pemesanan; ?>"
                                    data-nomor-pemesanan="<?php echo htmlspecialchars($nomor_pemesanan); ?>">
                                    <input type="hidden" name="id_mitra" value="<?php echo $id_mitra; ?>">
                                    <input type="hidden" name="nomor_pemesanan"
                                        value="<?php echo htmlspecialchars($nomor_pemesanan); ?>">
                                    <div class="payment-summary mt-4">
                                        <h5>Total Harga: Rp.<span
                                                class="total-harga"><?php echo number_format($item['total'], 0, ',', '.'); ?></span>
                                        </h5>
                                        <div class="order-actions mt-3 d-flex justify-content-between">
                                            <a href="informasi_bukti_diterima?nomor_pemesanan=<?php echo htmlspecialchars($nomor_pemesanan); ?>"
                                                type="button" class="btn btn-success text-white"
                                                style="text-decoration: none; flex: 1; margin-right: 5px">Lihat Bukti</a>
                                            <button type="button" class="btn btn-warning pay-now text-white"
                                                style="text-decoration: none; flex: 1; margin-left: 5px"
                                                onclick="pesan_lagi('<?php echo $nomor_pemesanan; ?>')">Pesan Lagi</button>
                                        </div>
                                    </div>
                                </form>
                                <!-- End of Tombol Bayar Sekarang, Batas Waktu, dan Total Harga -->
                            </div>
                        </div>
                    <?php
                        $counter++; // Increment counter for the next item
                    }
                    mysqli_close($koneksi);
                    ?>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function pesan_lagi(nomor_pemesanan) {
            var form = document.querySelector('form[data-nomor-pemesanan="' + nomor_pemesanan + '"]');
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'proses/diterima/masukan_kekeranjang.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = xhr.responseText.trim();
                    console.log(response); // Debugging

                    if (response === 'success') {
                        Swal.fire({
                            title: "Sukses!",
                            text: "Roti telah ditambahkan ke dalam keranjang 😊",
                            icon: "success",
                            timer: 2300,
                            showConfirmButton: false,
                        }).then(function() {
                            location.reload();
                        });
                    } else if (response === 'success_update') {
                        Swal.fire({
                            title: "Sukses!",
                            text: "Jumlah roti telah ditambahkan ke keranjang 😊",
                            icon: "success",
                            timer: 2900,
                            showConfirmButton: false,
                        }).then(function() {
                            location.reload();
                        });
                    } else if (response === 'stok_dikeranjang_masih_ada') {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Roti yang dipesan masih ada di dalam keranjang 😥",
                            icon: "error",
                            timer: 2300,
                            showConfirmButton: false,
                        }).then(function() {
                            location.reload();
                        });
                    } else if (response === 'gagal') {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Gagal menambahkan roti ke dalam keranjang 😥",
                            icon: "error",
                            timer: 2300,
                            showConfirmButton: false,
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: "Terjadi kesalahan: " + response,
                            icon: "error",
                        });
                    }
                }
            };
            xhr.send(formData);
        }

        // Mencegah refresh halaman ketika tombol diklik
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
            });
        });

        function performSearch() {
            var keyword = document.getElementById('searchInput').value.toLowerCase();
            var cards = document.querySelectorAll('.card[data-nomor-pemesanan]');

            cards.forEach(function(card) {
                var nomorPemesanan = card.getAttribute('data-nomor-pemesanan').toLowerCase();
                if (nomorPemesanan.includes(keyword)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });

            closeSearchPopup();
        }

        function openSearchPopup() {
            document.getElementById('searchPopup').style.display = 'block';
        }

        function closeSearchPopup() {
            document.getElementById('searchPopup').style.display = 'none';
        }

        // Show the search popup when the search button is clicked
        document.querySelector('.search-popup .popup-header a').addEventListener('click', closeSearchPopup);
    </script>

    <?php include('fitur/js_1.php'); ?>
</body>

</html>