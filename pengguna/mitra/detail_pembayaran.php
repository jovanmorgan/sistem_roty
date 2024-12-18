<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== BOXICONS ===============-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css?v=<?= time(); ?>" />

    <!--=============== CSS ===============-->
    <link href="css/nav_penasanan_saya.css?v=<?= time(); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/loding.css?v=<?= time(); ?>" />
    <link href="img/apple-touch-icon.png?v=<?= time(); ?>" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700&v=<?= time(); ?>"
        rel="stylesheet" />

    <!-- Bootstrap CSS File -->
    <link href="lib/bootstrap/css/bootstrap.min.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- Libraries CSS Files -->
    <link href="lib/font-awesome/css/font-awesome.min.css?v=<?= time(); ?>" rel="stylesheet" />
    <link href="lib/animate/animate.min.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- Favicons -->
    <link href="../../assets/img/loding_donat.png?v=<?= time(); ?>" rel="icon" />
    <link href="../../assets_laura/img/apple-touch-icon.png?v=<?= time(); ?>" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Satisfy?v=<?= time(); ?>"
        rel="stylesheet" />

    <!-- css akun -->
    <link rel="stylesheet" href="css/akun.css?v=<?= time(); ?>" />

    <!-- Vendor CSS Files -->
    <link href="../../assets_laura/vendor/glightbox/css/glightbox.min.css?v=<?= time(); ?>" rel="stylesheet" />
    <link href="../../assets_laura/vendor/swiper/swiper-bundle.min.css?v=<?= time(); ?>" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css?v=<?= time(); ?>"
        rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="../../assets_laura/css/style.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- Main Stylesheet File -->
    <link href="css/style.css?v=<?= time(); ?>" rel="stylesheet" />

    <title>Detail Pembayaran | Fasya Bakery</title>
</head>


<body translate="no">
    <!--=============== HEADER ===============-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="belum_bayar" class="nav__logo"><i class="bx bx-arrow-back"
                    style="font-size: 2.3em; position: relative; left: 15px;"></i>
            </a>
            <a href="#" class="nav__logo">
                <h1><b>Checkout</b></h1>
            </a>

            <div class="nav__kiri">
                <a href="#" class="nav__search-icon">
                    <i class="bx bx-info-circle"></i>
                </a>
            </div>
        </nav>
    </header>
    <style>
    .order-item {
        display: flex;
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .order-img img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 15px;
    }

    .order-details {
        flex: 1;
    }

    .order-details h6 {
        margin: 0;
        font-size: 16px;
        font-weight: bold;
    }

    .order-details p {
        margin: 5px 0;
    }

    .total-price {
        font-size: 18px;
        margin-top: 20px;
    }

    .total-price span {
        font-weight: bold;
        color: hsl(30, 100%, 50%);
    }

    .payment-info {
        margin-top: 20px;
        border-top: 1px solid #e0e0e0;
        padding-top: 20px;
    }

    .payment-info p {
        font-size: 16px;
        margin: 0;
    }

    .upload-section {
        margin-top: 20px;
    }

    .upload-section input[type="file"] {
        display: none;
    }

    .upload-section label {
        background-color: hsl(30, 100%, 50%);
        color: white;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        display: inline-block;
    }

    .upload-section .file-name {
        margin-top: 10px;
        font-style: italic;
    }

    .uploaded-img {
        margin-top: 10px;
        max-width: 100%;
        height: auto;
        display: none;
    }

    .timer {
        font-size: 14px;
        color: #ff0000;
        text-align: center;
        width: 100%;
        margin-top: 10px;
    }

    .btn-submit {
        margin-top: 20px;
        background-color: hsl(30, 100%, 50%);
        color: white;
        float: right;
    }

    @media (max-width: 768px) {
        .order-item {
            flex-wrap: wrap;
        }

        .order-img {
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }

        .order-img img {
            width: 100%;
            height: auto;
        }

        .order-details {
            width: 100%;
        }

        .order-actions {
            width: 100%;
        }

        .total-price,
        .payment-info,
        .upload-section,
        .timer {
            text-align: center;
        }

        .btn-submit {
            width: 100%;
        }
    }
    </style>
    <?php
    include '../../keamanan/koneksi.php';

    // Ambil nomor_pemesanan dari parameter URL
    $nomor_pemesanan = isset($_GET['nomor_pemesanan']) ? $_GET['nomor_pemesanan'] : '';

    // Cek apakah nomor_pemesanan kosong
    if (empty($nomor_pemesanan)) {
        echo '<p style="text-align: center; margin-top: 100px">Nomor pemesanan tidak tersedia. Terjadi kesalahan saat memproses permintaan Anda. Silakan cek koneksi Anda atau hubungi kami.</p>';
        exit();
    }

    // Ambil data dari tabel checkout berdasarkan nomor_pemesanan
    $checkout_query = "SELECT * FROM checkout WHERE nomor_pemesanan = '$nomor_pemesanan' AND status = 'belum_bayar' AND id_mitra = $id_mitra";
    $checkout_result = mysqli_query($koneksi, $checkout_query);

    if (!$checkout_result || mysqli_num_rows($checkout_result) == 0) {
        echo '<p style="text-align: center; margin-top: 100px">Pesanan anda telah dibayar silakan lihat pada status selanjutnya.</p>';
        mysqli_close($koneksi);
        exit();
    }

    // Ambil data pesanan dari tabel pemesanan
    $pemesanan_query = "SELECT p.id_pemesanan, p.id_mitra, p.id_roti, p.nomor_pemesanan, p.jumlah, p.waktu, p.total,
      r.nama_roti, r.harga, r.gambar_roti, r.rasa
      FROM pemesanan p
      JOIN roti r ON p.id_roti = r.id_roti
      WHERE p.nomor_pemesanan = '$nomor_pemesanan' AND p.id_mitra = '$id_mitra'";
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

    // Periksa apakah waktu pemesanan sudah lewat 24 jam dan hapus jika perlu
    if (!empty($pemesanan_data)) {
        $waktu_pemesanan = new DateTime($pemesanan_data[0]['waktu']);
        $sekarang = new DateTime();
        $interval = $sekarang->diff($waktu_pemesanan);

        if ($interval->days > 0 || $interval->h >= 24) {
            // Kembalikan stok ke tabel roti
            foreach ($pemesanan_data as $data) {
                $id_roti = $data['id_roti'];
                $jumlah = $data['jumlah'];
                $update_stok_query = "UPDATE roti SET stok = stok + $jumlah WHERE id_roti = $id_roti";
                mysqli_query($koneksi, $update_stok_query);
            }

            // Hapus data pesanan dan checkout
            $hapus_pemesanan_query = "DELETE FROM pemesanan WHERE nomor_pemesanan = '$nomor_pemesanan'";
            mysqli_query($koneksi, $hapus_pemesanan_query);

            $hapus_checkout_query = "DELETE FROM checkout WHERE nomor_pemesanan = '$nomor_pemesanan'";
            mysqli_query($koneksi, $hapus_checkout_query);

            echo '<p style="text-align: center; margin-top: 100px">Pesanan sudah lewat 24 jam dan telah dihapus. Jumlah roti telah dikembalikan ke stok. Silakan cek roti jika ingin memesan ulang.</p>';
            mysqli_close($koneksi);
            exit();
        }

        // Menghitung waktu batas
        $waktu_batas = clone $waktu_pemesanan;
        $waktu_batas->modify('+24 hours');
        $waktu_batas_timestamp = $waktu_batas->getTimestamp();
    } else {
        $waktu_batas_timestamp = time(); // Set timestamp saat ini jika data kosong
    }

    // Ambil data bank dari tabel bank
    $bank_query = "SELECT id_bank, bank, nomor_rekening FROM bank";
    $bank_result = mysqli_query($koneksi, $bank_query);

    $bank_data = [];
    if ($bank_result && mysqli_num_rows($bank_result) > 0) {
        while ($bank_row = mysqli_fetch_assoc($bank_result)) {
            $bank_data[] = $bank_row;
        }
    }

    // Tutup koneksi ke database
    mysqli_close($koneksi);
    ?>

    <section style="background-color: #eee">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">
                        <!-- Breadcrumb content -->
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="text-center" style="position: relative; top: 12px">
                                <b>Detail Pesanan</b>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <?php if (!empty($pemesanan_data)): ?>
                            <div class="nomor-pemesanan" style="font-size: 17px">
                                Nomor Pemesanan: <b><?php echo htmlspecialchars($nomor_pemesanan); ?></b>
                            </div>
                            <hr />
                            <?php foreach ($pemesanan_data as $data): ?>
                            <div class="order-item">
                                <div class="order-img">
                                    <img src="img/fb/<?php echo htmlspecialchars($data['gambar_roti']); ?>"
                                        alt="Gambar Roti" />
                                </div>
                                <div class="order-details">
                                    <h6>Nama Roti: <?php echo htmlspecialchars($data['nama_roti']); ?></h6>
                                    <p>Jenis: <?php echo htmlspecialchars($data['rasa']); ?></p>
                                    <p>Jumlah: <?php echo htmlspecialchars($data['jumlah']); ?></p>
                                    <p>Harga: Rp. <?php echo number_format($data['harga'], 0, ',', '.'); ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <div class="total-price">
                                Total Harga: Rp.
                                <span><?php echo number_format(array_sum(array_column($pemesanan_data, 'total')), 0, ',', '.'); ?></span>
                            </div>
                            <?php else: ?>
                            <p>Data pesanan tidak ditemukan. Terjadi kesalahan saat memproses permintaan Anda. Silakan
                                cek koneksi Anda atau hubungi kami.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="text-center"><b>Pembayaran</b></h4>
                            <div class="payment-info">
                                <p>Silakan melakukan pembayaran ke salah satu nomor rekening berikut :</p>
                                <?php if (!empty($bank_data)): ?>
                                <?php foreach ($bank_data as $bank): ?>
                                <div class="d-flex justify-content-center align-items-center mt-3">
                                    <button class="btn btn-success btn-sm" id="copy-button"
                                        title="Klik untuk menyalin nomor HP"
                                        onclick="copyToClipboard(this, '<?php echo htmlspecialchars($bank['nomor_rekening']); ?> (<?php echo htmlspecialchars($bank['bank']); ?>)')">
                                        <?php echo htmlspecialchars($bank['nomor_rekening']); ?>
                                        (<?php echo htmlspecialchars($bank['bank']); ?>)
                                    </button>
                                </div>

                                <?php endforeach; ?>
                                <?php else: ?>
                                <p>Nomor rekening tidak tersedia.</p>
                                <?php endif; ?>
                            </div>
                            <hr />
                            <form id="form-bukti-pembayaran" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="nomor_pemesanan" id="nomor_pemesanan"
                                    value="<?php echo $nomor_pemesanan; ?>">
                                <input type="hidden" name="id_mitra" id="id_mitra" value="<?php echo $id_mitra; ?>">
                                <div class="upload-section">
                                    <label for="upload">Unggah Bukti Pembayaran</label>
                                    <input name="bukti_pembayaran" type="file" id="upload" accept="image/*" />
                                    <div class="file-name mt-2"></div>
                                    <img class="uploaded-img mt-3" id="uploaded-img" alt="Bukti Pembayaran"
                                        style="display: none; max-width: 100%; height: auto;" />
                                </div>
                                <hr />
                                <div class="timer">
                                    <span style="font-size: 16px; color: #888;">Batas Waktu Pembayaran:</span><br>
                                    <span class="countdown" id="countdown"></span>
                                </div>
                                <hr />
                                <div class="pay-now">
                                    <button type="submit" class="btn btn-submit">Bayar Sekarang</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
    /* Menambahkan style untuk tombol */
    #copy-button2 {
        position: relative;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        background-color: #28a745;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    #copy-button2:hover {
        background-color: #218838;
    }

    #copy-button2::after {
        content: attr(title);
        position: absolute;
        bottom: 120%;
        left: 50%;
        transform: translateX(-50%);
        padding: 10px;
        background-color: #000;
        color: #fff;
        font-size: 15px;
        border-radius: 3px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s, visibility 0.3s;
    }

    #copy-button2.show-title::after {
        opacity: 1;
        visibility: visible;
    }


    #copy-button {
        position: relative;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        background-color: #28a745;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    #copy-button:hover {
        background-color: #218838;
    }

    #copy-button::after {
        content: attr(title);
        position: absolute;
        bottom: 120%;
        left: 50%;
        transform: translateX(-50%);
        padding: 10px;
        background-color: #000;
        color: #fff;
        font-size: 15px;
        border-radius: 3px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s, visibility 0.3s;
    }

    #copy-button.show-title::after {
        opacity: 1;
        visibility: visible;
    }
    </style>

    <div class="search-popup" id="searchPopup">
        <div class="search-popup-content p-4 rounded shadow-lg">
            <div class="popup-header d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Informasi Pembayaran</h3>
                <a href="#" class="close-btn" onclick="closeSearchPopup()">
                    <i class="bx bx-x fs-3"></i>
                </a>
            </div>
            <!-- Informasi Langkah-langkah Pembayaran -->
            <div class="popup-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex align-items-center">
                        <i class="bx bx-transfer-alt me-3 fs-4"></i>
                        Transfer pembayaran ke nomor rekening yang sudah disediakan.
                    </li>

                    <?php if (!empty($bank_data)): ?>
                    <?php foreach ($bank_data as $bank): ?>
                    <li class="list-group-item d-flex align-items-center justify-content-center">
                        <div class="d-flex justify-content-center align-items-center mt-3">
                            <button class="btn btn-success btn-sm" id="copy-button2"
                                title="Klik untuk menyalin nomor HP"
                                onclick="copyToClipboard(this, '<?php echo htmlspecialchars($bank['nomor_rekening']); ?> (<?php echo htmlspecialchars($bank['bank']); ?>)')">
                                <?php echo htmlspecialchars($bank['nomor_rekening']); ?>
                                (<?php echo htmlspecialchars($bank['bank']); ?>)
                            </button>
                        </div>
                    </li>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p>Nomor rekening tidak tersedia.</p>
                    <?php endif; ?>
                    <li class="list-group-item d-flex align-items-center">
                        <i class="bx bx-upload me-3 fs-4"></i>
                        Unggah bukti pembayaran di bagian atas halaman ini.
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i class="bx bx-timebagianfs-4"></i>
                        Pastikan Anda menyelesaikan pembayaran sebelum batas waktu yang ditentukan.
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.getElementById('form-bukti-pembayaran').addEventListener('submit', function(event) {
        event.preventDefault(); // Menghentikan aksi default form submit

        var form = this;
        var formData = new FormData(form);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'proses/chackout/tambah.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = xhr.responseText.trim();

                if (response === 'success') {
                    form.reset();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil ditambahkan',
                        timer: 1200, // 1,2 detik
                        showConfirmButton: false // Menghilangkan tombol OK
                    }).then(() => {
                        window.location.href = 'dikemas';
                    })
                } else if (response === 'upload_error') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Error',
                        text: 'Anda belum memsukan foto bukti pembayaran',
                        timer: 2000, // 2 detik
                        showConfirmButton: false // Menghilangkan tombol OK
                    });
                } else if (response === 'data_tidak_lengkap') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Error',
                        text: 'Data yang Anda masukkan belum lengkap',
                        timer: 2000, // 2 detik
                        showConfirmButton: false // Menghilangkan tombol OK
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal menambahkan data',
                        timer: 2000, // 2 detik
                        showConfirmButton: false // Menghilangkan tombol OK
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengirim data',
                    timer: 2000, // 2 detik
                    showConfirmButton: false // Menghilangkan tombol OK
                });
            }
        };
        xhr.send(formData);
    });

    function copyToClipboard(button, text) {
        // Menyalin teks ke clipboard
        navigator.clipboard.writeText(text).then(function() {
            // Mengubah title tombol menjadi 'Berhasil Tersalin'
            button.setAttribute('title', 'Berhasil Tersalin ✅');

            // Mengatur ulang title setelah 2 detik
            setTimeout(function() {
                button.setAttribute('title', 'Klik untuk menyalin nomor HP');
            }, 2000);
        }, function() {
            // Menangani kesalahan jika salinan gagal
            alert('Gagal menyalin teks.');
        });
    }

    // Menambahkan event listener untuk mengatur class show-title saat hover
    document.getElementById('copy-button2').addEventListener('mouseenter', function() {
        this.classList.add('show-title');
    });

    document.getElementById('copy-button2').addEventListener('mouseleave', function() {
        this.classList.remove('show-title');
    });

    // Menambahkan event listener untuk mengatur class show-title saat hover
    document.getElementById('copy-button').addEventListener('mouseenter', function() {
        this.classList.add('show-title');
    });

    document.getElementById('copy-button').addEventListener('mouseleave', function() {
        this.classList.remove('show-title');
    });

    // Hitung mundur batas waktu pembayaran
    function countdownTimer(endTime) {
        const countdownElement = document.getElementById('countdown');
        const interval = setInterval(() => {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance <= 0) {
                clearInterval(interval);
                countdownElement.textContent = 'Waktu Habis';
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownElement.textContent = `${hours} Jam : ${minutes} Menit : ${seconds} Detik`;
        }, 1000);
    }

    // Memulai hitung mundur saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const endTime = <?php echo $waktu_batas_timestamp * 1000; ?>;
        countdownTimer(endTime);
    });

    document.getElementById('upload').addEventListener('change', function(event) {
        const fileInput = event.target;
        const fileNameElement = document.querySelector('.file-name');
        const imgElement = document.getElementById('uploaded-img');

        if (fileInput.files && fileInput.files[0]) {
            const file = fileInput.files[0];
            fileNameElement.textContent = `File: ${file.name}`;

            const reader = new FileReader();
            reader.onload = function(e) {
                imgElement.src = e.target.result;
                imgElement.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            fileNameElement.textContent = '';
            imgElement.style.display = 'none';
        }
    });

    // Menutup popup saat mengklik di luar popup
    window.onclick = function(event) {
        if (event.target == document.getElementById("searchPopup")) {
            closeSearchPopup();
        } else if (event.target == document.getElementById("buyPopup")) {
            closeBuyPopup();
        }
    };

    function updateBadgePadding() {
        const badges = document.querySelectorAll(
            ".order-status .status-item .badge"
        );
        badges.forEach((badge) => {
            const textLength = badge.textContent.length;
            if (textLength === 1) {
                badge.style.padding = "3px 5px";
                // badge.style.right = "4px";
            } else if (textLength === 2) {
                badge.style.padding = "4px 3.5px";
                // badge.style.right = "6px";
            } else if (textLength === 3) {
                badge.style.padding = "5px 1px";
                // badge.style.right = "-1px";
            }
        });
    }

    // Call the function to set the initial padding
    updateBadgePadding();
    </script>

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