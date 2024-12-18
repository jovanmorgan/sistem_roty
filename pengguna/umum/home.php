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

    <title>HOME | Fasya Bakery</title>
</head>


<body translate="no">
    <!--=============== HEADER ===============-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="#" class="nav__logo"><img src="../../assets/img/logo_fasya2.jpeg" alt="" /></a>
            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="home" class="nav__link active-link">
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
                        <a href="kontak" class="nav__link">
                            <i class="bx bx-phone nav__icon"></i>
                            <span class="nav__name">Kontak</span>
                        </a>
                    </li>
                </ul>
            </div>

            <?php include 'proses/roti/nav_keranjang.php'; ?>
        </nav>
    </header>

    <!--========================== Hero Section ============================-->
    <section id="hero">
        <div class="hero-container">
            <h1>Selamat Datang</h1>
            <h2>
                di <b>Fasya Bakery</b>, tempat terbaik untuk berbagai macam roti lezat
            </h2>
            <a href="#about" class="btn-get-started">Jelajahi Sekarang</a>
        </div>
    </section>
    <!-- #hero -->

    <main id="main">
        <!--========================== About Us Section ============================-->
        <section id="about">
            <div class="container">
                <div class="row about-container">
                    <div class="col-lg-6 content order-lg-1 order-2">
                        <div class="section-title">
                            <span>Tentang Kami</span>
                            <h2>Tentang Kami</h2>
                        </div>
                        <p>
                            CV. FASYA BAKERY adalah bisnis roti yang menawarkan berbagai
                            macam produk berkualitas tinggi di Kota Kupang dan sekitarnya.
                            <br />
                            Kami menjalin kemitraan dengan kios-kios dan toko-toko lokal
                            untuk mendistribusikan produk kami. Para mitra memesan produk
                            terlebih dahulu untuk dijual di toko mereka, dan kami memberikan
                            layanan pengiriman ulang saat stok hampir habis.
                        </p>

                        <div class="icon-box wow fadeInUp">
                            <div class="icon"><i class="bx bx-baguette"></i></div>
                            <h4 class="title"><a href="">Roti Yang Lezat</a></h4>
                            <p class="description">
                                Nikmati sensasi roti yang lembut, harum, dan penuh dengan cita
                                rasa yang menggugah selera. Setiap gigitan membawa
                                kebahagiaan.
                            </p>
                        </div>

                        <div class="icon-box wow fadeInUp" data-wow-delay="0.2s">
                            <div class="icon"><i class="bx bx-headphone"></i></div>
                            <h4 class="title"><a href="">Admin Siap Melayani</a></h4>
                            <p class="description">
                                Tim layanan pelanggan kami siap membantu Anda dengan ramah dan
                                profesional, memastikan setiap kebutuhan Anda terpenuhi dengan
                                cepat dan tepat.
                            </p>
                        </div>

                        <div class="icon-box wow fadeInUp" data-wow-delay="0.4s">
                            <div class="icon"><i class="bx bx-package"></i></div>
                            <h4 class="title"><a href="">Pengiriman Cepat</a></h4>
                            <p class="description">
                                Pengiriman roti kami cepat dan aman. Pastikan roti Anda tiba
                                dalam kondisi terbaik, segar, dan siap dinikmati kapan saja.
                            </p>
                        </div>

                        <div class="icon-box wow fadeInUp" data-wow-delay="0.6s">
                            <div class="icon"><i class="bx bx-dollar-circle"></i></div>
                            <h4 class="title"><a href="">Harga Terjangkau</a></h4>
                            <p class="description">
                                Kami menawarkan roti berkualitas tinggi dengan harga yang
                                bersahabat di kantong Anda. Nikmati roti premium tanpa harus
                                merogoh kocek dalam-dalam.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-6 background order-lg-2 order-1 wow fadeInRight">
                        <img src="img/tempat_fcb.jpg" class="img-fluid" alt="Tentang Kami Gambar"
                            style="border-radius: 50px" />
                    </div>
                </div>
            </div>
        </section>
        <!-- #about -->

        <?php
        // Menghubungkan ke database
        include '../../keamanan/koneksi.php';

        // Fungsi untuk menghitung total data dari tabel
        function getTotalCount($koneksi, $table)
        {
            $query = "SELECT COUNT(*) as total FROM $table";
            $result = mysqli_query($koneksi, $query);
            $data = mysqli_fetch_assoc($result);
            return $data['total'];
        }

        // Mengambil data dari tabel
        $roti_count = getTotalCount($koneksi, 'roti');
        $galeri_count = getTotalCount($koneksi, 'galeri');
        $promo_count = getTotalCount($koneksi, 'promo');
        $pesanan_count = getTotalCount($koneksi, 'pemesanan');
        ?>
        <!--==========================
      Facts Section
    ============================-->
        <section id="facts">
            <div class="container wow fadeIn">
                <div class="section-header">
                    <div class="section-title">
                        <span>Jumlah</span>
                        <h2>Jumlah</h2>
                    </div>
                    <p class="section-description">Jumlah data yang kami sediakan</p>
                </div>
                <div class="row counters">
                    <!-- untuk tabel roti -->
                    <div class="col-lg-3 col-6 text-center">
                        <span data-toggle="counter-up"><?= number_format($roti_count); ?></span>
                        <p>Roti</p>
                    </div>

                    <!-- untuk tabel galeri -->
                    <div class="col-lg-3 col-6 text-center">
                        <span data-toggle="counter-up"><?= number_format($galeri_count); ?></span>
                        <p>Galery</p>
                    </div>

                    <!-- untuk tabel promo -->
                    <div class="col-lg-3 col-6 text-center">
                        <span data-toggle="counter-up"><?= number_format($promo_count); ?></span>
                        <p>Promo</p>
                    </div>

                    <!-- untuk tabel pemesanan -->
                    <div class="col-lg-3 col-6 text-center">
                        <span data-toggle="counter-up"><?= number_format($pesanan_count); ?></span>
                        <p>Pesanan Terjual</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- #facts -->

        <!--==========================
      Services Section
    ============================-->
        <section id="services">
            <div class="container wow fadeIn">
                <div class="section-header">
                    <div class="section-title">
                        <span>Tutorial</span>
                        <h2>Tutorial</h2>
                    </div>
                    <p class="section-description">
                        Ikuti langkah-langkah berikut untuk memesan roti di Fasya Bakery!
                    </p>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="box">
                            <div class="icon">
                                <a href=""><i class="fa fa-user-plus"></i></a>
                            </div>
                            <h4 class="title"><a href="">Langkah 1: Daftar Akun</a></h4>
                            <p class="description">
                                Buat akun baru dan lengkapi data diri Anda untuk memulai
                                proses pemesanan.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="box">
                            <div class="icon">
                                <a href=""><i class="fa fa-sign-in"></i></a>
                            </div>
                            <h4 class="title"><a href="">Langkah 2: Masuk Akun</a></h4>
                            <p class="description">
                                Login dengan akun yang telah Anda buat untuk mengakses fitur
                                pemesanan.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="box">
                            <div class="icon">
                                <a href=""><i class="fa fa-search"></i></a>
                            </div>
                            <h4 class="title"><a href="">Langkah 3: Cari Produk</a></h4>
                            <p class="description">
                                Cari dan pilih roti yang ingin Anda beli dari berbagai pilihan
                                yang tersedia.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="box">
                            <div class="icon">
                                <a href=""><i class="fa fa-shopping-cart"></i></a>
                            </div>
                            <h4 class="title"><a href="">Langkah 4: Pesan dan Bayar</a></h4>
                            <p class="description">
                                Tambahkan produk ke keranjang, lakukan pembayaran, dan
                                konfirmasi pesanan Anda.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="box">
                            <div class="icon">
                                <a href=""><i class="fa fa-truck"></i></a>
                            </div>
                            <h4 class="title">
                                <a href="">Langkah 5: Tunggu Pengiriman</a>
                            </h4>
                            <p class="description">
                                Tunggu hingga pesanan Anda dikirim dan sampai di lokasi yang
                                Anda tentukan.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="box">
                            <div class="icon">
                                <a href=""><i class="fa fa-check-circle"></i></a>
                            </div>
                            <h4 class="title">
                                <a href="">Langkah 6: Konfirmasi dan Ulasan</a>
                            </h4>
                            <p class="description">
                                Setelah menerima pesanan, konfirmasikan penerimaan dan berikan
                                ulasan untuk feedback.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- #services -->

        <!--==========================
    Call To Action Section
    ============================-->
        <section id="call-to-action">
            <div class="container wow fadeIn">
                <div class="row">
                    <div class="col-lg-9 text-center text-lg-left">
                        <h3 class="cta-title">Segera Pesan Sekarang</h3>
                        <p class="cta-text">
                            Nikmati roti lezat dari CV. FASYA BAKERY yang dibuat dengan
                            bahan-bahan berkualitas tinggi. Pesan sekarang dan rasakan
                            kenikmatan setiap gigitan!
                        </p>
                    </div>
                    <div class="col-lg-3 cta-btn-container text-center">
                        <a class="cta-btn align-middle" href="#">
                            Pesan Sekarang <i class="bx bx-cart"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- #call-to-action -->
        <?php
        // Menghubungkan ke database
        include '../../keamanan/koneksi.php';

        // Pagination variables
        $limit = 6; // Jumlah item per halaman
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Query untuk menghitung total item
        $total_query = "SELECT COUNT(*) AS total FROM galeri";
        $total_result = mysqli_query($koneksi, $total_query);
        $total_row = mysqli_fetch_assoc($total_result);
        $total_items = $total_row['total'];
        $total_pages = ceil($total_items / $limit);

        // Query untuk mengambil data galeri dengan pagination
        $query = "SELECT * FROM galeri LIMIT $limit OFFSET $offset";
        $result = mysqli_query($koneksi, $query);

        $galeri_items = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $galeri_items[] = $row;
            }
        }
        ?>
        <!-- ======= Galery Section ======= -->
        <section id="portfolio" class="portfolio">
            <div class="container">
                <div class="section-title">
                    <span>Galery</span>
                    <h2>Galery</h2>
                    <p>Silakan lihat bagian galeri.</p>
                </div>

                <ul id="portfolio-flters" class="d-flex justify-content-center">
                    <li data-filter=".roti, .roti kering, .tempat" class="filter-active">All</li>
                    <li data-filter=".roti">Roti</li>
                    <li data-filter=".roti kering">Roti Kering</li>
                    <li data-filter=".tempat">Tempat</li>
                </ul>

                <div class="row portfolio-container">
                    <?php foreach ($galeri_items as $item): ?>
                    <div class="col-lg-4 col-md-6 portfolio-item <?php echo htmlspecialchars($item['jenis']); ?>">
                        <div class="portfolio-img">
                            <img src="../../assets/img/galeri/<?php echo htmlspecialchars($item['gambar_galeri']); ?>"
                                class="img-fluid" alt="<?php echo htmlspecialchars($item['nama']); ?>" />
                        </div>
                        <div class="portfolio-info">
                            <h4><?php echo htmlspecialchars($item['nama']); ?></h4>
                            <p><?php echo htmlspecialchars($item['jenis']); ?></p>
                            <a href="../../assets/img/galeri/<?php echo htmlspecialchars($item['gambar_galeri']); ?>"
                                data-gallery="portfolioGallery" class="portfolio-lightbox preview-link"
                                title="<?php echo htmlspecialchars($item['nama']); ?>"><i class="bx bx-plus"></i></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <ul class="pagination justify-content-center mt-4">
                        <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                            <a class="page-link" href="<?php if ($page > 1) echo "?page=" . ($page - 1); ?>"
                                aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php endfor; ?>
                        <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                            <a class="page-link" href="<?php if ($page < $total_pages) echo "?page=" . ($page + 1); ?>"
                                aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End Pagination -->

            </div>
        </section>
        <!-- End Galery Section -->
        <style>
        /* Styling untuk pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .pagination .page-link {
            border-radius: 0.25rem;
        }
        </style>

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
                                <p>+082-339-573-409</p>
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
                                        placeholder="Nama Anda" data-rule="minlen:4"
                                        data-msg="Tolog masukan nama anda" />
                                    <div class="validation"></div>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="nomor_hp" id="nomor_hp"
                                        placeholder="Nomor Telepon" data-rule="nomor_hp"
                                        data-msg="Tolong isi nomor hp anda" />
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