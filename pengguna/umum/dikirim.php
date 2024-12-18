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
                            <!-- pada bagian pemesanan ini taru icon belum bayar, dikemas, dikirim, dan diterima dan berikan dengan angka pada iconnya di pojok kanan atas-->
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
                                    <a href="dikemas" id="dikemas_btn" class="text-secondary">
                                        <i class="fas fa-box fa-lg"></i>
                                        <?php if ($dikemas_count > 0): ?>
                                        <span class="badge b2"><?php echo $dikemas_count; ?></span>
                                        <?php endif; ?>
                                        <p class="mb-0 dikemas">Dikemas</p>
                                    </a>
                                </div>
                                <div class="status-item">
                                    <a href="dikirim" id="dikirim_btn" class="text-primary">
                                        <i class="fas fa-truck fa-lg"></i>
                                        <?php if ($dikirim_count > 0): ?>
                                        <span class="badge b3"><?php echo $dikirim_count; ?></span>
                                        <?php endif; ?>
                                        <p class="mb-0">Dikirim</p>
                                    </a>
                                </div>
                                <div class="status-item">
                                    <a href="diterima" id="diterima_btn" class="text-secondary">
                                        <i class="fas fa-check-circle fa-lg"></i>
                                        <?php if ($diterima_count > 0): ?>
                                        <span class="badge b4"><?php echo $diterima_count; ?></span>
                                        <?php endif; ?>
                                        <p class="mb-0 diterima">Diterima</p>
                                    </a>
                                </div>
                                <div class="status-item">
                                    <a href="dibatalkan" id="dibatalkan_btn" class="text-secondary">
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
                    <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        // Fungsi untuk mengirim permintaan AJAX
                        function sendUpdateRequest(status, callback) {
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "proses/icon/update_status.php", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    var response = JSON.parse(xhr.responseText);
                                    if (response.status === "success") {
                                        // Redirect ke halaman yang sesuai setelah pembaruan
                                        window.location.href = status;
                                    } else {
                                        console.error("Error: " + response.message);
                                    }
                                }
                            };

                            xhr.send("status=" + encodeURIComponent(status));
                        }

                        // Menambahkan event listener ke masing-masing tombol
                        document
                            .getElementById("belum_bayar_btn")
                            .addEventListener("click", function(event) {
                                event.preventDefault(); // Mencegah tindakan default tautan
                                sendUpdateRequest("belum_bayar");
                            });

                        document
                            .getElementById("dikemas_btn")
                            .addEventListener("click", function(event) {
                                event.preventDefault(); // Mencegah tindakan default tautan
                                sendUpdateRequest("dikemas");
                            });

                        document
                            .getElementById("dikirim_btn")
                            .addEventListener("click", function(event) {
                                event.preventDefault(); // Mencegah tindakan default tautan
                                sendUpdateRequest("dikirim");
                            });

                        document
                            .getElementById("diterima_btn")
                            .addEventListener("click", function(event) {
                                event.preventDefault(); // Mencegah tindakan default tautan
                                sendUpdateRequest("diterima");
                            });

                        document
                            .getElementById("dibatalkan_btn")
                            .addEventListener("click", function(event) {
                                event.preventDefault(); // Mencegah tindakan default tautan
                                sendUpdateRequest("dibatalkan");
                            });

                        // Menambahkan event listener ke masing-masing tombol
                        document
                            .getElementById("keranjang_btn")
                            .addEventListener("click", function(event) {
                                event.preventDefault(); // Mencegah tindakan default tautan
                                sendUpdateRequest("keranjang");
                            });
                    });
                    </script>
                </div>

                <?php
                include '../../keamanan/koneksi.php';

                // Ambil semua nomor_pemesanan dari tabel dikirim dengan status 'belum_diterima'
                $dikirim_query = "SELECT DISTINCT nomor_pemesanan, waktu, waktu_batas_pengiriman FROM dikirim WHERE status = 'belum_diterima' AND id_mitra = $id_mitra ORDER BY id_dikirim DESC";
                $dikirim_result = mysqli_query($koneksi, $dikirim_query);

                if (!$dikirim_result || mysqli_num_rows($dikirim_result) == 0) {
                    echo '<div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="text-center" style="position: relative; top: 12px">
                    <b class="warna_orange">Belum Bayar</b>
                </h4>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="text-center" style="position: relative; top: 12px; font-size: 16px">
                    <b class="text-secondary">Anda tidak memiliki pesanan yang dikirim 😊</b>
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
                            <h4 class="text-center" style="position: relative; top: 12px">
                                <b class="text-primary">Dikirim</b>
                            </h4>
                        </div>
                    </div>

                    <?php
                    $counter = 0; // Inisialisasi counter untuk membuat ID yang unik
                    // Loop untuk setiap nomor_pemesanan
                    while ($dikirim_row = mysqli_fetch_assoc($dikirim_result)) {
                        $nomor_pemesanan = $dikirim_row['nomor_pemesanan'];
                        $waktu_dikirim = new DateTime($dikirim_row['waktu']); // Mengambil waktu dari database
                        $waktu_batas_pengiriman = $dikirim_row['waktu_batas_pengiriman'];

                        // Menghitung waktu batas pengiriman berdasarkan waktu_dikirim dan waktu_batas_pengiriman
                        if (strpos($waktu_batas_pengiriman, 'Jam') !== false) {
                            $interval = str_replace(' Jam', '', $waktu_batas_pengiriman);
                            $waktu_dikirim->modify("+$interval hours");
                        } elseif (strpos($waktu_batas_pengiriman, 'Menit') !== false) {
                            $interval = str_replace(' Menit', '', $waktu_batas_pengiriman);
                            $waktu_dikirim->modify("+$interval minutes");
                        } elseif (strpos($waktu_batas_pengiriman, 'Detik') !== false) {
                            $interval = str_replace(' Detik', '', $waktu_batas_pengiriman);
                            $waktu_dikirim->modify("+$interval seconds");
                        }

                        $waktu_batas_timestamp = $waktu_dikirim->getTimestamp();

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
                                    class="text-primary"><?php echo htmlspecialchars($nomor_pemesanan); ?></b>
                            </div>
                            <hr />
                            <?php if (!empty($pemesanan_data)): ?>
                            <?php foreach ($pemesanan_data as $item): ?>
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
                                <span style="font-size: 16px; color: #888;">Batas Waktu Pengiriman:</span> <br>
                                <span class="countdown text-primary" id="countdown-<?php echo $counter; ?>"></span>
                            </div>
                            <hr />
                            <div class="payment-summary mt-4">
                                <h5>Total Harga: Rp.<span class="total-harga text-primary">
                                        <?php
                                            $total_harga = array_sum(array_column($pemesanan_data, 'total'));
                                            echo number_format($total_harga, 0, ',', '.');
                                            ?>
                                    </span></h5>
                                <div class="order-actions mt-3">
                                    <a href="informasi_pengiriman?nomor_pemesanan=<?php echo htmlspecialchars($nomor_pemesanan); ?>"
                                        class="btn btn-info dikirim-now text-white"
                                        style="text-decoration: none; width: 100%">
                                        Lihat Informasi Dikirim
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        function startCountdown(elementId, endTimestamp) {
                            var countdownElement = document.getElementById(elementId);
                            var endDate = new Date(endTimestamp * 1000); // Convert timestamp to milliseconds

                            function updateCountdown() {
                                var now = new Date();
                                var timeDiff = endDate - now;

                                if (timeDiff <= 0) {
                                    countdownElement.textContent = "Mohon bersabar, pesanan sedang diantar";
                                    return; // Countdown finished
                                }

                                var hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                var minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

                                countdownElement.textContent =
                                    hours.toString().padStart(2, '0') + " Jam : " +
                                    minutes.toString().padStart(2, '0') + " Menit : " +
                                    seconds.toString().padStart(2, '0') + " Detik ";
                            }

                            updateCountdown(); // Initial call to display immediately
                            setInterval(updateCountdown, 1000); // Update every second
                        }

                        // Mulai countdown untuk setiap elemen dengan ID unik
                        startCountdown("countdown-<?php echo $counter; ?>",
                            <?php echo $waktu_batas_timestamp; ?>);
                    });
                    </script>
                    <?php
                        $counter++; // Increment counter for the next item
                    }
                    mysqli_close($koneksi);
                    ?>

                </div>

            </div>
        </div>
    </section>

    <script>
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