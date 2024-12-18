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
                                    <a href="dikemas" id="dikemas_btn" class="text-info">
                                        <i class="fas fa-box fa-lg"></i>
                                        <?php if ($dikemas_count > 0): ?>
                                        <span class="badge b2"><?php echo $dikemas_count; ?></span>
                                        <?php endif; ?>
                                        <p class="mb-0">Dikemas</p>
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
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                // Ambil id_mitra dari PHP session
                const idMitra = '<?php echo $_SESSION["id_mitra"]; ?>';

                // Fungsi untuk mengirim status update ke update_status.php
                function updateStatus(status) {
                    $.ajax({
                        url: 'proses/icon/update_status.php', // Ganti dengan path update_status.php sesuai dengan struktur folder Anda
                        type: 'POST',
                        data: {
                            status: status,
                            id_mitra: idMitra
                        },
                        success: function(response) {
                            const res = JSON.parse(response);
                            if (res.status === 'success') {
                                // Redirect ke halaman sesuai dengan status
                                switch (status) {
                                    case 'belum_bayar':
                                        window.location.href = 'belum_bayar';
                                        break;
                                    case 'dikemas':
                                        window.location.href = 'dikemas';
                                        break;
                                    case 'dikirim':
                                        window.location.href = 'dikirim';
                                        break;
                                    case 'diterima':
                                        window.location.href = 'diterima';
                                        break;
                                    case 'dibatalkan':
                                        window.location.href = 'dibatalkan';
                                        break;
                                    default:
                                        alert('Status tidak dikenali.');
                                }
                            } else {
                                alert('Gagal memperbarui status: ' + res.message);
                            }
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat menghubungi server.');
                        }
                    });
                }

                // Tambahkan event listener ke setiap tombol status
                document.getElementById('belum_bayar_btn').addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah navigasi default
                    updateStatus('belum_bayar');
                });

                document.getElementById('dikemas_btn').addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah navigasi default
                    updateStatus('dikemas');
                });

                document.getElementById('dikirim_btn').addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah navigasi default
                    updateStatus('dikirim');
                });

                document.getElementById('diterima_btn').addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah navigasi default
                    updateStatus('diterima');
                });

                document.getElementById('dibatalkan_btn').addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah navigasi default
                    updateStatus('dibatalkan');
                });
                </script>
                <?php
                include '../../keamanan/koneksi.php';

                // Ambil input pencarian
                $search_query = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

                // Ambil semua nomor_pemesanan dari tabel dikemas dengan status 'belum_dikemas'
                $dikemas_query = "SELECT DISTINCT nomor_pemesanan FROM dikemas WHERE status = 'belum_dikemas' AND id_mitra = $id_mitra ORDER BY id_dikemas DESC";

                // Tambahkan kondisi pencarian jika ada input pencarian
                if ($search_query) {
                    $dikemas_query .= " AND nomor_pemesanan LIKE '%$search_query%'";
                }

                $dikemas_result = mysqli_query($koneksi, $dikemas_query);

                if (!$dikemas_result || mysqli_num_rows($dikemas_result) == 0) {
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
                    <b class="text-secondary">Anda tidak memiliki pesanan yang sementara dikemas 😊</b>
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
                                <b class="text-info">Dikemas</b>
                            </h4>
                        </div>
                    </div>

                    <?php
                    $counter = 0; // Inisialisasi counter untuk membuat ID yang unik
                    // Loop untuk setiap nomor_pemesanan
                    while ($dikemas_row = mysqli_fetch_assoc($dikemas_result)) {
                        $nomor_pemesanan = $dikemas_row['nomor_pemesanan'];

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
                                    class="text-info"><?php echo htmlspecialchars($nomor_pemesanan); ?></b>
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
                                Sementara Dikemas, Mohon Bersabar Yaah! 😊
                            </div>
                            <hr />
                            <div class="payment-summary mt-4">
                                <h5>Total Harga: Rp.<span class="total-harga text-info">
                                        <?php
                                            $total_harga = array_sum(array_column($pemesanan_data, 'total'));
                                            echo number_format($total_harga, 0, ',', '.');
                                            ?>
                                    </span></h5>

                                <div class="order-actions mt-3">
                                    <a href="informasi_pemesanan?nomor_pemesanan=<?php echo htmlspecialchars($nomor_pemesanan); ?>"
                                        class="btn btn-info dikemas-now text-white"
                                        style="text-decoration: none; width: 100%">
                                        Lihat Informasi Pemesanan
                                    </a>
                                </div>
                            </div>
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