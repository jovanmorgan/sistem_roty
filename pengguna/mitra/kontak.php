<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== BOXICONS ===============-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css?v=<?= time(); ?>" />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../../assets/css/styles.css?v=<?= time(); ?>" />
    <link rel="stylesheet" href="../../assets/css/loding.css?v=<?= time(); ?>" />
    <link href="img/apple-touch-icon.png?v=<?= time(); ?>" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700?v=<?= time(); ?>"
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

    <!-- Vendor CSS Files -->
    <link href="../../assets_laura/vendor/glightbox/css/glightbox.min.css?v=<?= time(); ?>" rel="stylesheet" />
    <link href="../../assets_laura/vendor/swiper/swiper-bundle.min.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="../../assets_laura/css/style.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- Main Stylesheet File -->
    <link href="css/style.css?v=<?= time(); ?>" rel="stylesheet" />
    <title>KONTAK | Fasya Bakery</title>
</head>


<body translate="no">
    <!--=============== HEADER ===============-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="#" class="nav__logo"><img src="../../assets/img/logo_fasya2.jpeg" alt="" /></a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="home" class="nav__link">
                            <i class="bx bx-home-alt nav__icon"></i>
                            <span class="nav__name">Home</span>
                        </a>
                    </li>

                    <li class="nav__item">
                        <a href="roti" class="nav__link">
                            <i class="bx bx-baguette nav__icon"></i>
                            <span class="nav__name">Roti</span>
                        </a>
                    </li>

                    <li class="nav__item">
                        <a href="galeri" class="nav__link">
                            <i class="bx bx-image nav__icon"></i>
                            <span class="nav__name">Galeri</span>
                        </a>
                    </li>

                    <li class="nav__item">
                        <a href="promo" class="nav__link">
                            <i class="bx bx-gift nav__icon"></i>
                            <span class="nav__name">Promo</span>
                        </a>
                    </li>

                    <li class="nav__item">
                        <a href="kontak" class="nav__link active-link">
                            <i class="bx bx-phone nav__icon"></i>
                            <span class="nav__name">Kontak</span>
                        </a>
                    </li>
                </ul>
            </div>

            <?php

            include '../../keamanan/koneksi.php'; // Pastikan path ke koneksi benar

            // Fungsi untuk menghitung jumlah data belum dibaca
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

            // Menghitung jumlah data dari masing-masing tabel untuk id_mitra tertentu
            $keranjang_count = getCount('keranjang', $id_mitra);

            // Menutup koneksi
            mysqli_close($koneksi);

            ?>

            <style>
            .nav__kiri {
                position: relative;
            }

            .keranjang {
                position: relative;
                display: inline-block;
            }

            .badge {
                position: absolute;
                top: -2px;
                left: 15px;
                background-color: red;
                color: white;
                border-radius: 50%;
                font-size: 10px;
                padding: 4px 5px;
                min-width: 18px;
                text-align: center;
            }

            /* Optional: Adjust size and position for smaller screens */
            @media (max-width: 768px) {
                .badge {
                    font-size: 8px;
                    min-width: 15px;
                    top: -1px;
                    left: 16px;
                }
            }
            </style>

            <div class="nav__kiri" id="load_keranjang">
                <a href="#" class="nav__search-icon">
                    <i class="bx bx-search"></i>
                </a>
                <a href="keranjang" class="keranjang" id="keranjang_btn">
                    <i class="bx bx-cart"></i>
                    <?php if ($keranjang_count > 0): ?>
                    <span class="badge b6"><?php echo $keranjang_count; ?></span>
                    <?php endif; ?>
                </a>
                <a href="akun" class="ml-3">
                    <!-- Icon akun dari Font Awesome -->
                    <i class="fa fa-user"></i>
                </a>
            </div>

            <script>
            function updateBadgePadding() {
                const badges = document.querySelectorAll(".badge");
                badges.forEach((badge) => {
                    const textLength = badge.textContent.length;
                    if (textLength === 1) {
                        badge.style.padding = "4px 5px";
                    } else if (textLength === 2) {
                        badge.style.padding = "4px 3.5px";
                    } else if (textLength === 3) {
                        badge.style.padding = "5px 1px";
                    }
                });
            }

            // Call the function to set the initial padding
            updateBadgePadding();

            document.addEventListener("DOMContentLoaded", function() {
                // Fungsi untuk mengirim permintaan AJAX
                function sendUpdateRequest(status, id_mitra, callback) {
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

                    xhr.send("status=" + encodeURIComponent(status) + "&id_mitra=" + encodeURIComponent(
                        id_mitra));
                }

                // Menambahkan event listener ke masing-masing tombol
                document
                    .getElementById("keranjang_btn")
                    .addEventListener("click", function(event) {
                        event.preventDefault(); // Mencegah tindakan default tautan
                        const id_mitra = "<?php echo $id_mitra; ?>"; // Mengambil id_mitra dari session
                        sendUpdateRequest("keranjang", id_mitra);
                    });

            });
            </script>
        </nav>
    </header>

    <main id="main" class="mt-5">
        <!--==========================
      Contact Section
    ============================-->
        <section id="contact">
            <div class="container wow fadeInUp">
                <div class="section-header">
                    <div class="section-title">
                        <span>Kontak</span>
                        <h2>Kontak</h2>
                    </div>
                    <p class="section-description">
                        Ini adalah kontak dari Cv.Fasya Bakery
                    </p>
                </div>
            </div>

            <!-- Uncomment below if you wan to use dynamic maps -->
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11443.07435885994!2d123.5816993!3d-10.1590933!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c569d6f6c5f165b%3A0xb5ebed021a3fd4a9!2sFasya+bakery!5e0!3m2!1sen!2sid!4v1689730875782"
                width="100%" height="380" frameborder="0" style="border: 0" allowfullscreen aria-hidden="false"
                tabindex="0"></iframe>

            <?php
            // Koneksi ke database
            include '../../keamanan/koneksi.php';

            // Ambil data nomor_hp dan nama_lengkap dari tabel mitra
            $query = "SELECT nomor_hp, nama_lengkap FROM mitra WHERE id_mitra = $id_mitra"; // Pastikan query sesuai dengan kebutuhan Anda
            $result = $koneksi->query($query);

            $mitra = $result->fetch_assoc();
            $nomor_hp = $mitra['nomor_hp'];
            $nama_lengkap = $mitra['nama_lengkap'];
            ?>

            <div class="container wow fadeInUp mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-4">
                        <div class="info">
                            <div>
                                <i class="fa fa-map-marker"></i>
                                <p>CV. Fasya Bakery<br />Kota Kupang</p>
                            </div>

                            <div>
                                <i class="fa fa-envelope"></i>
                                <p>fasyabakery@gmail.com</p>
                            </div>

                            <div>
                                <i class="fa fa-phone"></i>
                                <p><?php echo htmlspecialchars($nomor_hp); ?></p>
                                <!-- Menampilkan nomor_hp dari database -->
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-8">
                        <div class="form">
                            <div id="sendmessage">
                                Silakan masukan pesan anda , terima kasih 😊!
                            </div>
                            <div id="errormessage"></div>
                            <form id="tambahKontakForm" action="" method="post" role="form" class="contactForm">
                                <div class="form-group">
                                    <input type="text" name="nama" class="form-control" id="nama"
                                        placeholder="Nama Anda" data-rule="minlen:4" data-msg="Tolog masukan nama anda"
                                        value="<?php echo htmlspecialchars($nama_lengkap); ?>" />
                                    <div class="validation"></div>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="nomor_hp" id="nomor_hp"
                                        placeholder="Nomor Telepon" data-rule="nomor_hp"
                                        data-msg="Tolong isi nomor hp anda"
                                        value="<?php echo htmlspecialchars($nomor_hp); ?>" />
                                    <div class="validation"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul"
                                        data-rule="minlen:4" data-msg="Tolong masukan judulnya" />
                                    <div class="validation"></div>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="pesan" rows="5" data-rule="required"
                                        data-msg="Tolong tuliskan pesan anda" placeholder="Pesan"></textarea>
                                    <div class="validation"></div>
                                </div>
                                <div class="text-center">
                                    <button type="submit">Kirim Pesan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- #contact -->
    </main>

    <!--==========================
  Footer
============================-->
    <footer id="footer">
        <div class="footer-top">
            <div class="container"></div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong>Fasya Bakery</strong>.
            </div>
            <div class="credits" style="padding-bottom: 60px">
                Devoloper Website By Jovandy Morchan Mere Guju
            </div>
        </div>
    </footer>
    <!-- #footer -->



    <!-- Ikon panah ke atas -->
    <div class="geser-ke-atas" id="geserKeAtas">
        <i class="bx bx-chevron-up"></i>
    </div>

    <!--=============== LOADING ===============-->
    <div class="loading">
        <div class="loading-top"></div>
        <div class="loading-bottom"></div>
        <div class="loading-putar">
            <img src="../../assets/img/loding_donat.png" alt="" width="200px" class="loading-img" />
        </div>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('tambahKontakForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Menghentikan aksi default form submit

            var form = this;
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'proses/kontak/tambah.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = xhr.responseText.trim();
                    console.log(response); // Debugging

                    if (response === 'success') {
                        form.reset();
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Pesan anda berhasil terkirim",
                            icon: "success",
                            timer: 1200, // 1,2 detik
                            showConfirmButton: false, // Tidak menampilkan tombol OK
                        });
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
    </script>

    <!-- Vendor JS Files -->
    <script src="../../assets_laura/vendor/purecounter/purecounter_vanilla.js?v=<?= time(); ?>"></script>
    <script src="../../assets_laura/vendor/bootstrap/js/bootstrap.bundle.min.js?v=<?= time(); ?>"></script>
    <script src="../../assets_laura/vendor/glightbox/js/glightbox.min.js?v=<?= time(); ?>"></script>
    <script src="../../assets_laura/vendor/isotope-layout/isotope.pkgd.min.js?v=<?= time(); ?>"></script>
    <script src="../../assets_laura/vendor/swiper/swiper-bundle.min.js?v=<?= time(); ?>"></script>
    <script src="../../assets_laura/vendor/waypoints/noframework.waypoints.js?v=<?= time(); ?>"></script>
    <script src="../../assets_laura/vendor/php-email-form/validate.js?v=<?= time(); ?>"></script>

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

    <!-- Contact Form JavaScript File -->
    <script src="contactform/contactform.js?v=<?= time(); ?>"></script>

    <!-- Template Main Javascript File -->
    <script src="js/main.js?v=<?= time(); ?>"></script>

    <!--=============== MAIN JS ===============-->
    <script src="../../assets/js/main.js?v=<?= time(); ?>"></script>
    <script src="../../assets/js/loding.js?v=<?= time(); ?>"></script>

</body>

</html>