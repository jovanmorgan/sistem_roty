<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== BOXICONS ===============-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css?v=<?= time(); ?>" />

    <!-- Favicons -->
    <link href="../../assets/img/loding_donat.png?v=<?= time(); ?>" rel="icon" />
    <link href="../../assets_laura/img/apple-touch-icon.png?v=<?= time(); ?>" rel="apple-touch-icon" />
    <link href="img/apple-touch-icon.png?v=<?= time(); ?>" rel="apple-touch-icon" />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../../assets/css/styles.css?v=<?= time(); ?>" />
    <link rel="stylesheet" href="../../assets/css/loding.css?v=<?= time(); ?>" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700?v=<?= time(); ?>"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Satisfy?v=<?= time(); ?>"
        rel="stylesheet" />

    <!-- Bootstrap CSS File -->
    <link href="lib/bootstrap/css/bootstrap.min.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- Libraries CSS Files -->
    <link href="lib/font-awesome/css/font-awesome.min.css?v=<?= time(); ?>" rel="stylesheet" />
    <link href="lib/animate/animate.min.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="../../assets_laura/vendor/glightbox/css/glightbox.min.css?v=<?= time(); ?>" rel="stylesheet" />
    <link href="../../assets_laura/vendor/swiper/swiper-bundle.min.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="../../assets_laura/css/style.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- Main Stylesheet File -->
    <link href="css/style.css?v=<?= time(); ?>" rel="stylesheet" />
    <title>GALERI | Fasya Bakery</title>
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
                        <a href="galeri" class="nav__link active-link">
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
    <main id="main">
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