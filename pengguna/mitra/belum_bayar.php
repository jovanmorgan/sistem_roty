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

    <style>
    .popup {
        position: fixed;
        top: -100%;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        transition: top 0.5s;
    }

    .popup-content {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        width: 80%;
        max-width: 500px;
        text-align: center;
        position: relative;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 24px;
        cursor: pointer;
    }

    .popup textarea {
        width: 100%;
        margin: 10px 0;
        padding: 10px;
    }

    .popup.show {
        top: 0;
    }

    .popup-buttons {
        display: flex;
        justify-content: space-between;
    }
    </style>
    <section style="background-color: #eee">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4"></nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-5">
                    <!-- bagian pesanan saya-->
                    <?php
                    include '../../keamanan/koneksi.php';

                    // Fungsi untuk menghitung jumlah data belum dibaca berdasarkan id_mitra
                    function getCount($table, $id_mitra)
                    {
                        global $koneksi;
                        $query = "SELECT COUNT(*) AS jumlah FROM $table WHERE dilihat = '' AND id_mitra = '$id_mitra'";
                        $result = mysqli_query($koneksi, $query);

                        // Cek apakah query berhasil
                        if (!$result) {
                            die("Query Error: " . mysqli_error($koneksi));
                        }

                        $row = mysqli_fetch_assoc($result);
                        return $row['jumlah'];
                    }

                    // Ambil id_mitra dari POST atau session (sesuaikan sesuai kebutuhan)
                    $id_mitra = $_POST['id_mitra'] ?? $_SESSION['id_mitra'];

                    // Menghitung jumlah data dari masing-masing tabel
                    $belum_bayar_count = getCount('checkout', $id_mitra);
                    $dikemas_count = getCount('dikemas', $id_mitra);
                    $dikirim_count = getCount('dikirim', $id_mitra);
                    $diterima_count = getCount('diterima', $id_mitra);
                    $dibatalkan_count = getCount('dibatalkan', $id_mitra);

                    // Menutup koneksi
                    mysqli_close($koneksi);
                    ?>



                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-0">
                            <!-- pada bagian pemesanan ini taru icon belum bayar, dikemas, dikirim, dan diterima dan berikan dengan angka pada iconnya di pojok kanan atas -->
                            <div class="order-status">
                                <div class="status-item">
                                    <a href="belum_bayar" id="belum_bayar_btn" class="pm">
                                        <i class="fas fa-money-bill-wave fa-lg s"></i>
                                        <?php if ($belum_bayar_count > 0): ?>
                                        <span class="badge b1"><?php echo $belum_bayar_count; ?></span>
                                        <?php endif; ?>
                                        <p class="mb-0 s">Belum Bayar</p>
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


                </div>
                <?php
                include '../../keamanan/koneksi.php';

                // Ambil semua nomor_pemesanan dari tabel checkout dengan status 'belum_bayar'
                $checkout_query = "SELECT DISTINCT nomor_pemesanan FROM checkout WHERE id_mitra = $id_mitra AND status = 'belum_bayar' ORDER BY id_checkout DESC";
                $checkout_result = mysqli_query($koneksi, $checkout_query);

                if (!$checkout_result || mysqli_num_rows($checkout_result) == 0) {
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
                    <b class="text-secondary">Anda tidak memiliki pesanan yang checkout 😊</b>
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
                        <form id="searchForm">
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
                                <b class="warna_orange">Belum Bayar</b>
                            </h4>
                        </div>
                    </div>

                    <?php
                    $counter = 0; // Inisialisasi counter untuk membuat ID yang unik
                    while ($checkout_row = mysqli_fetch_assoc($checkout_result)) {
                        $nomor_pemesanan = $checkout_row['nomor_pemesanan'];

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

                        $pemesanan_data = [];
                        while ($row = mysqli_fetch_assoc($pemesanan_result)) {
                            $pemesanan_data[] = $row;
                        }

                        // Periksa batas waktu untuk setiap item pesanan
                        $batas_waktu_tersisa = true;
                        foreach ($pemesanan_data as $data) {
                            $waktu_pemesanan = new DateTime($data['waktu']);
                            $sekarang = new DateTime();
                            $interval = $sekarang->diff($waktu_pemesanan);

                            // Misalkan batas waktu pemesanan adalah 24 jam
                            if ($interval->days > 0 || $interval->h >= 24) {
                                $batas_waktu_tersisa = false;
                                // Kembalikan stok ke tabel roti
                                $id_roti = $data['id_roti'];
                                $jumlah = $data['jumlah'];
                                $update_stok_query = "UPDATE roti SET stok = stok + $jumlah WHERE id_roti = $id_roti";
                                mysqli_query($koneksi, $update_stok_query);

                                // Hapus data pesanan dan checkout
                                $hapus_pemesanan_query = "DELETE FROM pemesanan WHERE nomor_pemesanan = '$nomor_pemesanan'";
                                mysqli_query($koneksi, $hapus_pemesanan_query);

                                $hapus_checkout_query = "DELETE FROM checkout WHERE nomor_pemesanan = '$nomor_pemesanan'";
                                mysqli_query($koneksi, $hapus_checkout_query);

                                echo '<p style="text-align: center; margin-top: 100px">Pesanan sudah lewat 24 jam dan telah dihapus. Jumlah roti telah dikembalikan ke stok. Silakan cek roti jika ingin memesan ulang.</p>';
                                break;
                            }
                        }

                        if (!$batas_waktu_tersisa) {
                            continue; // Jika waktu sudah habis, lanjutkan ke nomor pemesanan berikutnya
                        }

                        // Menghitung waktu batas
                        $waktu_batas = clone $waktu_pemesanan;
                        $waktu_batas->modify('+24 hours');
                        $waktu_batas_timestamp = $waktu_batas->getTimestamp();
                    ?>

                    <div class="card mb-4" data-nomor-pemesanan="<?php echo htmlspecialchars($nomor_pemesanan); ?>">
                        <div class="card-body">
                            <div class="nomor-pemesanan">
                                Nomor Pemesanan: <b
                                    class="warna_orange"><?php echo htmlspecialchars($nomor_pemesanan); ?></b>
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
                            <div class="timer">
                                <span style="font-size: 16px; color: #888;"> Batas Waktu Pembayaran :</span> <br>
                                <!-- Gunakan ID unik untuk setiap countdown -->
                                <span class="countdown" id="countdown-<?php echo $counter; ?>"></span>
                            </div>
                            <hr />
                            <div class="payment-summary mt-4">
                                <h5>Total Harga: Rp.<span class="total-harga">
                                        <?php
                                            $total_harga = array_sum(array_column($pemesanan_data, 'total'));
                                            echo number_format($total_harga, 0, ',', '.');
                                            ?>
                                    </span></h5>

                                <div class="order-actions mt-3 d-flex justify-content-between">
                                    <a href="#" class="btn btn-secondary text-white"
                                        style="text-decoration: none; flex: 1; margin-right: 5px"
                                        onclick="showPopup('<?php echo htmlspecialchars($nomor_pemesanan); ?>')">
                                        Batalkan
                                    </a>
                                    <a href="detail_pembayaran?nomor_pemesanan=<?php echo $nomor_pemesanan; ?>"
                                        class="btn btn-warning pay-now text-white"
                                        style="text-decoration: none; flex: 1; margin-left: 5px">
                                        Bayar Sekarang
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
                                    countdownElement.textContent = "Waktu Habis";
                                    return;
                                }

                                var days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                                var hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                var minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

                                countdownElement.textContent = days + " Hari " + hours + " Jam " + minutes +
                                    " Menit " + seconds + " Detik ";
                            }

                            updateCountdown();
                            setInterval(updateCountdown, 1000);
                        }

                        <?php foreach ($pemesanan_data as $index => $data): ?>
                        var endTimestamp = <?php echo $waktu_batas_timestamp; ?>;
                        startCountdown('countdown-<?php echo $counter++; ?>', endTimestamp);
                        <?php endforeach; ?>
                    });
                    </script>

                    <?php
                    }
                    mysqli_close($koneksi);
                    ?>
                </div>



                <!-- Pop-up Cancel -->
                <div id="cancelPopup" class="popup">
                    <div class="popup-content">
                        <form id="dibatalkanForm" action="proses/dibatalkan/tambah.php" method="POST">
                            <span class="close" onclick="hidePopup()">&times;</span>
                            <input type="hidden" name="id_mitra" value="<?php echo htmlspecialchars($id_mitra); ?>"
                                id="id_mitra">
                            <input type="hidden" name="nomor_pemesanan" id="popup_nomor_pemesanan">
                            <h5>Alasan Pembatalan</h5>
                            <textarea id="alasan" name="alasan" rows="4"
                                placeholder="Masukkan alasan pembatalan..."></textarea>
                            <div class="popup-buttons mt-3">
                                <button type="submit" class="btn btn-danger">
                                    Kirim
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="hidePopup()">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('dibatalkanForm').addEventListener('submit', function(event) {
                        event.preventDefault(); // Menghentikan aksi default form submit

                        var form = this;
                        var formData = new FormData(form);

                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'proses/dibatalkan/tambah.php', true);
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                var response = xhr.responseText.trim();
                                console.log(response); // Debugging

                                if (response === 'success') {
                                    form.reset();
                                    hidePopup()
                                    Swal.fire({
                                        title: "Berhasil!",
                                        text: "Data berhasil ditambahkan",
                                        icon: "success",
                                        timer: 1200, // 1,2 detik
                                        showConfirmButton: false, // Tidak menampilkan tombol OK
                                    }).then(() => {
                                        location.reload();
                                        window.location.href = "dibatalkan";
                                    })
                                } else if (response === 'data_tidak_lengkap') {
                                    Swal.fire({
                                        title: "Error",
                                        text: "Data yang anda masukan belum lengkap",
                                        icon: "info",
                                        timer: 2000, // 2 detik
                                        showConfirmButton: false,
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Error",
                                        text: "Gagal menambahkan data",
                                        icon: "error",
                                        timer: 2000, // 2 detik
                                        showConfirmButton: false,
                                    });
                                }
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: "Terjadi kesalahan saat mengirim data",
                                    icon: "error",
                                    timer: 2000, // 2 detik
                                    showConfirmButton: false,
                                });
                            }
                        };
                        xhr.send(formData);
                    });
                });

                function showPopup(nomor_pemesanan) {
                    document.getElementById('popup_nomor_pemesanan').value = nomor_pemesanan;
                    document.getElementById("cancelPopup").classList.add("show");
                }

                function hidePopup() {
                    document.getElementById("cancelPopup").classList.remove("show");
                }

                window.onclick = function(event) {
                    const popup = document.getElementById("cancelPopup");
                    if (event.target == popup) {
                        hidePopup();
                    }
                };
                </script>
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

                // Show the search popup when the search button is clicked
                document.querySelector('.search-popup .popup-header a').addEventListener('click', openSearchPopup);
                </script>
                <!-- pesanan saya js -->
                <script src="js/icon_pesanan.js?v=<?= time(); ?>"></script>
                <script src="js/pesanan_saya.js?v=<?= time(); ?>"></script>

                <!-- Template Main JS File -->
                <script src="../../assets_laura/js/main.js?v=<?= time(); ?>"></script>

                <!-- JavaScript Libraries -->
                <script src="lib/jquery/jquery.min.js?v=<?= time(); ?>"></script>
                <script src="lib/jquery/jquery-migrate.min.js?v=<?= time(); ?>"></script>
                <script src="lib/bootstrap/js/bootstrap.bundle.min.js?v=<?= time(); ?>"></script>
                <script src="lib/easing/easing.min.js?v=<?= time(); ?>"></script>
                <script src="lib/wow/wow.min.js?v=<?= time(); ?>"></script>
                <script src="lib/waypoints/waypoints.min.js?v=<?= time(); ?>"></script>
                <script src="lib/counterup/counterup.min.js?v=<?= time(); ?>"></script>
                <script src="lib/superfish/hoverIntent.js?v=<?= time(); ?>"></script>
                <script src="lib/superfish/superfish.min.js?v=<?= time(); ?>"></script>

                <!--=============== MAIN JS ===============-->
                <script src="../../assets/js/main.js?v=<?= time(); ?>"></script>
                <script src="../../assets/js/loding.js?v=<?= time(); ?>"></script>

                <!-- Contact Form JavaScript File -->
                <script src="contactform/contactform.js?v=<?= time(); ?>"></script>

</body>

</html>