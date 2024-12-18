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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i?v=<?= time(); ?>"
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

    <title>AKUN | Fasya Bakery</title>
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
                        <a href="kontak" class="nav__link">
                            <i class="bx bx-phone nav__icon"></i>
                            <span class="nav__name">Kontak</span>
                        </a>
                    </li>
                </ul>
            </div>
            <?php
            include '../../keamanan/koneksi.php'; // Pastikan path ke koneksi benar

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

            // Menghitung jumlah data dari masing-masing tabel berdasarkan id_mitra
            $keranjang_count = getCount('keranjang', $id_mitra);
            $belum_bayar_count = getCount('checkout', $id_mitra);
            $dikemas_count = getCount('dikemas', $id_mitra);
            $dikirim_count = getCount('dikirim', $id_mitra);
            $diterima_count = getCount('diterima', $id_mitra);
            $dibatalkan_count = getCount('dibatalkan', $id_mitra);

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

                .badge_keranjang {
                    position: absolute;
                    top: -2px;
                    left: 15px;
                    background-color: red;
                    color: white;
                    border-radius: 50%;
                    font-size: 10px;
                    padding: 1.5px 5px;
                    min-width: 18px;
                    text-align: center;
                }

                /* Optional: Adjust size and position for smaller screens */
                @media (max-width: 768px) {
                    .badge_keranjang {
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
                        <span class="badge_keranjang b6"><?php echo $keranjang_count; ?></span>
                    <?php endif; ?>
                </a>
                <a href="akun">
                    <img src="../../assets/img/user.png" alt="" />
                </a>
            </div>
            <script>
                function updateBadgePadding2() {
                    const badge_keranjang = document.querySelectorAll(".badge_keranjang");
                    badge_keranjang.forEach((bk) => {
                        const textLength = bk.textContent.length;
                        if (textLength === 1) {
                            bk.style.padding = "1.5px 5px";
                        } else if (textLength === 2) {
                            bk.style.padding = "1.5px 3.5px";
                        } else if (textLength === 3) {
                            bk.style.padding = "2px 1.5px";
                        }
                    });
                }

                // Call the function to set the initial padding
                updateBadgePadding2();
            </script>
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
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <div class="profile-picturess">
                                <?php
                                // Lakukan koneksi ke database
                                include '../../keamanan/koneksi.php';

                                // Periksa apakah session id_mitra telah diset
                                if (isset($_SESSION['id_mitra'])) {
                                    $id_mitra = $_SESSION['id_mitra'];

                                    // Query SQL untuk mengambil data mitra berdasarkan id_mitra dari session
                                    $query = "SELECT * FROM mitra WHERE id_mitra = '$id_mitra'";
                                    $result = mysqli_query($koneksi, $query);

                                    // Periksa apakah query berhasil dieksekusi
                                    if ($result) {
                                        // Periksa apakah terdapat data mitra
                                        if (mysqli_num_rows($result) > 0) {
                                            // Ambil data mitra sebagai array asosiatif
                                            $mitra = mysqli_fetch_assoc($result);
                                ?>
                                            <a href="javascript:void(0)"
                                                onclick="document.getElementById('editFotoProfile').click()">
                                                <?php if (!empty($mitra['fp'])): ?>
                                                    <img src="../../assets/img/fp_pengguna/mitra/<?php echo $mitra['fp']; ?>"
                                                        alt="ananddavis" class="gbrr" />
                                                <?php else: ?>
                                                    <img src="../../assets/img/user.png" alt="ananddavis" class="img-fluid" />
                                                <?php endif; ?>
                                            </a>
                                            <!-- Input file tersembunyi untuk memilih gambar -->
                                            <input type="file" class="d-none" id="editFotoProfile" name="editFotoProfile"
                                                accept="image/*" onchange="previewAndUpdateProfile(this)">

                                            <!-- Modal untuk memilih gambar profile -->
                                            <div class="modal fade" id="editFotoProfileModal" tabindex="-1" role="dialog"
                                                aria-labelledby="editFotoProfileModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editFotoProfileModalLabel"
                                                                style="font-size: 150%;">Edit Foto Profile</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close" onclick="location.reload();">
                                                                <span aria-hidden="true" style="font-size: 140%;">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="gambar">
                                                                <img id="editFotoProfilePreview" src="#" alt="Preview Foto Profile"
                                                                    class="img-fluid">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                                onclick="location.reload();">Close</button>
                                                            <button type="button" class="btn btn-primary" id="btnSaveProfile">Save
                                                                changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                            </div>
                            <h5 class="my-3"><?php echo $mitra['nama_lengkap']; ?></h5>
                            <p class="text-muted mb-1"><?php echo $mitra['nomor_hp']; ?></p>
                        </div>
                        <a href="log_out" class="btn btn-secondary btn-sm" type="button">Logout</a>
                    </div>
                    <style>
                        .profile-picturess .gbrr {
                            border-radius: 50%;
                            width: 150px;
                            /* Sesuaikan dengan ukuran yang diinginkan */
                            height: 150px;
                            /* Sesuaikan dengan ukuran yang diinginkan */
                            object-fit: cover;
                            /* Memastikan gambar mengisi area tanpa distorsi */
                        }
                    </style>
                    <!-- bagian pesanan saya-->
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-0">
                            <div class="order-status">
                                <div class="status-item">
                                    <a href="belum_bayar" id="belum_bayar_btn" class="warna_orange">
                                        <i class="fas fa-money-bill-wave fa-lg s"></i>
                                        <?php if ($belum_bayar_count > 0): ?>
                                            <span class="badge b1"><?php echo $belum_bayar_count; ?></span>
                                        <?php endif; ?>
                                        <p class="mb-0 s">Belum Bayar</p>
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
                                    <a href="dikirim" id="dikirim_btn" class="text-primary">
                                        <i class="fas fa-truck fa-lg"></i>
                                        <?php if ($dikirim_count > 0): ?>
                                            <span class="badge b3"><?php echo $dikirim_count; ?></span>
                                        <?php endif; ?>
                                        <p class="mb-0">Dikirim</p>
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
                                    <a href="dibatalkan" id="dibatalkan_btn" class="text-danger">
                                        <i class="fas fa-times-circle fa-lg"></i>
                                        <?php if ($dibatalkan_count > 0): ?>
                                            <span class="badge b5"><?php echo $dibatalkan_count; ?></span>
                                        <?php endif; ?>
                                        <p class="mb-0">Dibatalkan</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-7">
                    <div class="card mb-4">
                        <form id="form_akun" action="proses/akun/edit.php" method="POST">
                            <input type="hidden" name="id_mitra" id="id_mitra" value="<?php echo $id_mitra; ?>">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Nama lengkap</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Masukan Nama lengkap anda"
                                            id="nama_lengkap" name="nama_lengkap"
                                            value="<?php echo $mitra['nama_lengkap']; ?>" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Nomor Hp</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="number" min="0" class="form-control" name="nomor_hp"
                                            placeholder="Masukan Nomor Hp" id="nomor_hp"
                                            value="<?php echo $mitra['nomor_hp']; ?>" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Password</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Masukan Password"
                                            name="password" id="password" value="<?php echo $mitra['password']; ?>" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Alamat Lengkap</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <textarea class="form-control"
                                            placeholder="Alamat Lengkap Anda Dikota kupang..." id="alamat" name="alamat"
                                            rows="3"
                                            value="<?php echo $mitra['alamat']; ?>"><?php echo $mitra['alamat']; ?></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 text-end">
                                        <button type="submit" class="btn btn-primary" style="padding: 2px 5px 5px 9px"
                                            id="editButton">
                                            <i class="fas fa-edit">Edit</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
                                        } else {
                                            // Jika tidak ada data mitra
                                            echo "Tidak ada data mitra.";
                                        }
                                    } else {
                                        // Jika query tidak berhasil dieksekusi
                                        echo "Gagal mengambil data mitra: " . mysqli_error($koneksi);
                                    }
                                } else {
                                    // Jika session id_mitra tidak diset
                                    echo "Session id_mitra tidak tersedia.";
                                }

                                // Tutup koneksi ke database
                                mysqli_close($koneksi);
?>

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

<!--=============== LOADING ===============-->
<div class="loading">
    <div class="loading-top"></div>
    <div class="loading-bottom"></div>
    <div class="loading-putar">
        <img src="../../assets/img/loding_donat.png" alt="" width="200px" class="loading-img" />
    </div>
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    // Variabel global untuk menyimpan instance Cropper
    var cropper;

    const loding = document.querySelector('.loading');

    // Fungsi untuk menampilkan gambar yang dipilih dan menampilkan modal
    function previewAndUpdateProfile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#editFotoProfilePreview').attr('src', e.target.result);
                $('#editFotoProfileModal').modal('show');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Fungsi untuk memotong gambar dan menyimpannya
    function cropImage() {
        var croppedCanvas = cropper.getCroppedCanvas({
            width: 200, // Tentukan lebar gambar yang diinginkan
            height: 200 // Tentukan tinggi gambar yang diinginkan
        });
        var croppedDataUrl = croppedCanvas.toDataURL();

        // Tampilkan elemen .loading sebelum mengirimkan permintaan AJAX
        loding.style.display = 'flex';

        // Simpan data gambar ke server menggunakan AJAX
        $.ajax({
            type: 'POST',
            url: 'proses/akun/foto_profile.php',
            data: {
                imageBase64: croppedDataUrl
            },
            success: function(response) {

                // Sembunyikan elemen .loading setelah permintaan AJAX selesai
                loding.style.display = 'none';

                // Tampilkan sweet alert dengan pesan respon tanpa tombol OK dan hilang dalam 1,5 detik
                swal({
                    title: "Sukses!",
                    text: "Foto profile berhasil diperbarui.",
                    icon: "success",
                    timer: 1500,
                    buttons: false
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr, status, error) {
                // Tampilkan sweet alert dengan pesan error
                swal("Error!", xhr.responseText, "error");
            }
        });

        // Sembunyikan modal pemotongan gambar
        $('#editFotoProfileModal').modal('hide');
    }

    $(document).ready(function() {
        $('#editFotoProfileModal').on('shown.bs.modal', function() {
            // Inisialisasi Cropper setelah modal ditampilkan
            var containerWidth = $('.gambar').width();
            var containerHeight = $('.gambar').height();
            cropper = new Cropper($('#editFotoProfilePreview')[0], {
                aspectRatio: 1, // 1:1 aspect ratio
                viewMode: 1, // Crop mode
                minContainerWidth: containerWidth, // Set minimum container width to match image container width
                minContainerHeight: containerHeight, // Set minimum container height to match image container height
            });
        });

        $('#btnSaveProfile').on('click', function() {
            cropImage();
        });

        $('#editFotoProfileModal').on('hidden.bs.modal', function() {
            // Hapus cropper ketika modal ditutup
            if (cropper) {
                cropper.destroy();
            }
        });
    });

    $(document).ready(function() {
        $('#form_akun').on('submit', function(event) {
            event.preventDefault(); // Mencegah perilaku default form submit

            // Tangkap data formulir
            var formData = $('#form_akun').serialize();

            // Tampilkan elemen .loading sebelum mengirimkan permintaan AJAX
            loding.style.display = 'flex';

            $.ajax({
                type: 'POST',
                url: 'proses/akun/data_profile.php',
                data: formData, // Kirim data formulir yang telah ditangkap
                success: function(response) {

                    // Sembunyikan elemen .loading setelah permintaan AJAX selesai
                    loding.style.display = 'none';

                    // Periksa apakah respons adalah 'success'
                    if (response === 'success') {
                        // Tampilkan sweet alert dengan pesan sukses tanpa tombol OK dan hilang dalam 1,5 detik
                        swal({
                            title: "Sukses!",
                            text: "Data diri berhasil diperbarui",
                            icon: "success",
                            timer: 1500,
                            buttons: false
                        }).then(() => {
                            location
                                .reload(); // Muat ulang halaman setelah SweetAlert hilang
                        });
                    } else if (response === 'error_nomor_hp_exists') {
                        // Jika Nomor Hp sudah ada, tampilkan pesan khusus
                        swal({
                            title: "Nomor Hp Sudah Ada!",
                            text: "Nomor Hp yang Anda masukkan sudah terdaftar",
                            icon: "info",
                            timer: 2500,
                            buttons: false
                        });
                    } else {
                        // Jika respons adalah sesuatu yang tidak diharapkan, tampilkan pesan error
                        swal({
                            title: "Error!",
                            text: response,
                            icon: "error",
                            timer: 1500,
                            buttons: false
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Tampilkan sweet alert dengan pesan error
                    swal("Error!", xhr.responseText, "error");
                }
            });
        });
    });
</script>

<!--   Core JS Files   -->
<script src="../../assets/js/core/jquery.min.js?v=<?= time(); ?>"></script>
<script src="../../assets/js/core/popper.min.js?v=<?= time(); ?>"></script>
<script src="../../assets/js/core/bootstrap.min.js?v=<?= time(); ?>"></script>
<script src="../../assets/js/plugins/perfect-scrollbar.jquery.min.js?v=<?= time(); ?>"></script>

<!-- Template Main JS File -->
<script src="js/icon_pesanan.js?v=<?= time(); ?>"></script>
<script src="../../assets/js/main.js?v=<?= time(); ?>"></script>

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
<script src="js/sercing.js?v=<?= time(); ?>"></script>

</body>

</html>