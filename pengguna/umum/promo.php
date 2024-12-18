<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== BOXICONS ===============-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../../assets/css/styles.css?v=<?= time(); ?>" />
    <link rel="stylesheet" href="../../assets/css/loding.css?v=<?= time(); ?>" />
    <link href="img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700"
        rel="stylesheet" />

    <!-- Bootstrap CSS File -->
    <link href="lib/bootstrap/css/bootstrap.min.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- Libraries CSS Files -->
    <link href="lib/font-awesome/css/font-awesome.min.css?v=<?= time(); ?>" rel="stylesheet" />
    <link href="lib/animate/animate.min.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- Favicons -->
    <link href="../../assets/img/loding_donat.png" rel="icon" />
    <link href="../../assets_laura/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Satisfy"
        rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="../../assets_laura/vendor/glightbox/css/glightbox.min.css?v=<?= time(); ?>" rel="stylesheet" />
    <link href="../../assets_laura/vendor/swiper/swiper-bundle.min.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="../../assets_laura/css/style.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- Main Stylesheet File -->
    <link href="css/style.css?v=<?= time(); ?>" rel="stylesheet" />

    <!-- bagian card -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="css/produk.css?v=<?= time(); ?>" />
    <link rel="stylesheet" href="css/akun.css?v=<?= time(); ?>" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>ROTI | Fasya Bakery</title>
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
                        <a href="promo" class="nav__link active-link">
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

    <div id="load_data">
        <section class="section">
            <div class="row align-items-start">
                <?php
                include '../../keamanan/koneksi.php';

                // Pagination variables
                $limit = 6; // Jumlah roti per halaman
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                // Searching
                $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

                // Query to count total records that are in promo
                $total_result = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM roti r JOIN promo p ON r.id_roti = p.id_roti WHERE r.nama_roti LIKE '%$search%'");
                $total_row = mysqli_fetch_assoc($total_result);
                $total_roti = $total_row['total'];
                $total_pages = ceil($total_roti / $limit);

                // Query to fetch roti records that are in promo with search
                $result = mysqli_query($koneksi, "SELECT r.*, p.potongan_harga FROM roti r JOIN promo p ON r.id_roti = p.id_roti WHERE r.nama_roti LIKE '%$search%' LIMIT $limit OFFSET $offset");

                if (mysqli_num_rows($result) > 0) {
                    // Looping data roti
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id_roti = $row['id_roti'];
                        $nama_roti = $row['nama_roti'];
                        $harga = $row['harga'];
                        $stok = $row['stok'];
                        $berat = $row['berat'];
                        $rasa = $row['rasa'];
                        $vitamin = $row['vitamin'];
                        $gula = $row['gula'];
                        $deskripsi = $row['deskripsi'];
                        $gambar_roti = $row['gambar_roti'];
                        $potongan_harga = $row['potongan_harga'];

                        // Harga setelah potongan
                        $harga_potongan = $harga - $potongan_harga;

                        // Format harga
                        $formatted_harga = number_format($harga, 0, ',', '.');
                        $formatted_harga_potongan = number_format($harga_potongan, 0, ',', '.');
                        $formatted_potongan_harga = number_format($potongan_harga, 0, ',', '.');

                ?>
                <div class="col-lg-4 mb-4" style="margin: 0;">
                    <div class="cards">
                        <div class="wrapper">
                            <div class="container">
                                <div class="top">
                                    <img src="../../assets/img/roti/<?php echo htmlspecialchars($gambar_roti); ?>"
                                        alt="Roti" class="lazy-img" loading="lazy"
                                        style="width: 100%; height: 100%; object-fit: cover" />
                                </div>
                                <div class="bottom">
                                    <div class="left">
                                        <div class="details">
                                            <h1><?php echo htmlspecialchars($nama_roti); ?></h1>
                                            <p><span style="text-decoration: line-through;">Rp
                                                    <?php echo $formatted_harga; ?></span> <span
                                                    class="text-success">(Rp
                                                    -<?php echo $formatted_potongan_harga; ?>)</span></p>
                                            <p><strong>Rp <?php echo $formatted_harga_potongan; ?></strong></p>
                                        </div>
                                        <div class="buy">
                                            <a href="../../../../fasya_bakery/berlangganan/login_public"
                                                style="text-decoration: none;"><i
                                                    class="material-icons">add_shopping_cart</i></a>
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="done"><i class="material-icons">done</i></div>
                                        <div class="details">
                                            <h1><?php echo htmlspecialchars($nama_roti); ?></h1>
                                            <p>Added to your cart</p>
                                        </div>
                                        <div class="remove"><i class="material-icons">clear</i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="inside">
                                <div class="icon"><i class="material-icons">info_outline</i></div>
                                <div class="contents">
                                    <h3 class="title text-center mt-3 text-white"><b>Deskripsi</b></h3>
                                    <table class="table">
                                        <tr>
                                            <th>Berat</th>
                                            <th>Rasa</th>
                                        </tr>
                                        <tr>
                                            <td><?php echo htmlspecialchars($berat); ?>g</td>
                                            <td><?php echo htmlspecialchars($rasa); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Vitamin</th>
                                            <th>Gula</th>
                                        </tr>
                                        <tr>
                                            <td><?php echo htmlspecialchars($vitamin); ?></td>
                                            <td><?php echo htmlspecialchars($gula); ?>g</td>
                                        </tr>
                                    </table>
                                    <p class="text-center"><?php echo htmlspecialchars($deskripsi); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<div class='col-12'><p class='text-center'>Tidak ada data roti dalam promo 😖.</p></div>";
                }
                ?>
            </div>
        </section>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <!-- Pagination with icons -->
                            <nav aria-label="Page navigation example" style="position: relative; top: .5rem;">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                        <a class="page-link"
                                            href="<?php if ($page > 1) echo "?page=" . ($page - 1) . "&search=" . urlencode($search); ?>"
                                            aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                        <a class="page-link"
                                            href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                    </li>
                                    <?php } ?>
                                    <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                                        <a class="page-link"
                                            href="<?php if ($page < $total_pages) echo "?page=" . ($page + 1) . "&search=" . urlencode($search); ?>"
                                            aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            <!-- End Pagination with icons -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



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
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Masukkan kata kunci..."
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                <button type="submit"><i class="bx bx-search"></i></button>
            </form>
        </div>
    </div>

    <!-- Popup pembelian -->
    <div class="buy-popup" id="buyPopup">
        <div class="buy-popup-content">
            <div class="popup-header">
                <h3>Beli Roti</h3>
                <a href="#" class="close-btn" onclick="closeBuyPopup()">
                    <i class="bx bx-x"></i>
                </a>
            </div>

            <form id="buyForm">
                <input type="hidden" name="id_roti" id="id_roti">
                <input type="hidden" name="total" id="total">
                <input type="hidden" name="id_mitra" id="id_mitra" value="<?php echo $id_mitra; ?>">
                <!-- bagian pemunculan gambar, nama, harga, rasa, dan deskripsi -->
                <div class="selected-roti">
                    <img id="selected-roti-image" src="img/bg/bg4.jpeg" alt="Selected Roti"
                        class="selected-roti-image" />
                    <div class="roti-info">
                        <h4 id="selected-roti-name" style="margin: 0px 0px 1px 0px">Nama Roti</h4>
                        <p id="selected-roti-price" style="margin: 0px 0px 1px 0px">Harga: Rp 0</p>
                        <p id="selected-roti-rasa" style="margin: 0px 0px 1px 0px">Rasa: -</p>
                        <p id="selected-roti-stok" style="margin: 0px 0px 1px 0px">Stok: 0</p>
                        <p id="selected-roti-description" style="margin: 0px 0px 1px 0px">Deskripsi: -</p>
                    </div>
                </div>

                <!-- Garis Pembatas -->
                <div class="divider"></div>

                <!-- Bagian pemilihan roti -->
                <label for="jenisRoti">Jenis Roti:</label>
                <div class="jenis-roti-container" id="jenisRotiContainer">
                    <!-- Thumbnail roti akan dimasukkan di sini melalui JavaScript -->
                </div>

                <!-- Garis Pembatas -->
                <div class="divider"></div>

                <!-- bagian jumlah roti -->
                <div class="jumlah-container">
                    <label for="jumlahRoti" class="jumlah-label">Jumlah:</label>
                    <div class="quantity-buttons">
                        <button type="button" class="quantity-btn" onclick="decreaseQuantity()">
                            <i class="bx bx-minus"></i>
                        </button>
                        <input type="number" id="jumlahRoti" name="jumlah" value="1" min="1" readonly />
                        <button type="button" class="quantity-btn" onclick="increaseQuantity()">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                    <!-- Garis Pembatas -->
                    <div class="divider"></div>
                    <div class="total">
                        <p>Total : <span id="totalPrice">Rp 0</span></p>
                    </div>
                </div>
                <!-- Garis Pembatas -->
                <div class="divider"></div>

                <div class="button-container">
                    <button type="button" class="cart-button" style="background-color: #737373;"
                        id="masukan_kekeranjang">Masukan
                        Kekeranjang</button>
                    <button type="button" class="buy-button" id="beli_sekarang">Beli
                        Sekarang</button>
                </div>
            </form>
        </div>
    </div>
    <style>
    .button-container {
        display: flex;
        justify-content: space-between;
        /* Ruang antara tombol */
        gap: 10px;
        /* Jarak antara tombol */
    }

    .button-container button {
        flex: 1;
        /* Agar kedua tombol memiliki lebar yang sama */
        padding: 10px 20px;
        /* Menambahkan padding untuk ukuran tombol */
        font-size: 16px;
        /* Ukuran font tombol */
        cursor: pointer;
        /* Mengubah kursor menjadi pointer saat di atas tombol */
    }

    .cart-button {
        /* Warna latar untuk tombol Masukan Kekeranjang */
        color: white;
        border: none;
        border-radius: 5px;
        /* Menambahkan sedikit radius pada tombol */
    }

    .buy-button {
        /* Warna latar untuk tombol Beli Sekarang */
        color: white;
        border: none;
        border-radius: 5px;
        /* Menambahkan sedikit radius pada tombol */
    }

    .button-container button:hover {
        opacity: 0.9;
        /* Efek hover pada tombol */
    }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    let selectedPrice = 0; // Variabel untuk menyimpan harga roti yang dipilih

    function openBuyPopup(namaRoti, hargaRoti, stokRoti, gambarRoti, deskripsiRoti, rasaRoti, nomorSejenis, id) {
        // Update data pada pop-up
        document.getElementById('selected-roti-name').textContent = namaRoti;
        document.getElementById('selected-roti-price').textContent = 'Harga: Rp ' + hargaRoti;
        document.getElementById('selected-roti-image').src = '../../assets/img/roti/' + gambarRoti;
        document.getElementById('selected-roti-description').textContent = 'Deskripsi: ' + deskripsiRoti;
        document.getElementById('selected-roti-rasa').textContent = 'Rasa: ' + rasaRoti;
        document.getElementById('selected-roti-stok').textContent = 'Stok: ' + stokRoti;
        document.getElementById('id_roti').value = id;

        selectedPrice = parseInt(hargaRoti.replace(/\D/g, '')); // Simpan harga roti yang dipilih

        // Hapus thumbnail sebelumnya
        const container = document.querySelector('.jenis-roti-container');
        container.innerHTML = '';

        // Lakukan Ajax request untuk mendapatkan roti dengan nomor_sejenis yang sama
        fetch(`proses/roti/get_promo.php?nomor_sejenis=${nomorSejenis}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Pastikan data adalah array
                if (Array.isArray(data)) {
                    data.forEach(roti => {
                        const img = document.createElement('img');
                        img.src = `../../assets/img/roti/${roti.gambar_roti}`;
                        img.alt = roti.nama_roti;
                        img.classList.add('roti-thumbnail');
                        img.onclick = function() {
                            selectRoti(roti.nama_roti, `../../assets/img/roti/${roti.gambar_roti}`, roti
                                .harga, roti.stok, roti.deskripsi, roti.rasa, roti.id_roti);
                        };
                        container.appendChild(img);
                    });
                } else {
                    console.error('Data yang diterima bukan array:', data);
                }
            })
            .catch(error => console.error('Error fetching roti:', error));

        // Tampilkan pop-up
        document.getElementById("buyPopup").classList.add("active");

        updateTotalPrice(); // Update total price saat pop-up dibuka
    }

    function closeBuyPopup() {
        document.getElementById("buyPopup").classList.remove("active");
    }

    function increaseQuantity() {
        var jumlahRoti = document.getElementById("jumlahRoti");
        jumlahRoti.value = parseInt(jumlahRoti.value) + 1;
        updateTotalPrice(); // Update total price saat jumlah roti berubah
    }

    function decreaseQuantity() {
        var jumlahRoti = document.getElementById("jumlahRoti");
        if (jumlahRoti.value > 1) {
            jumlahRoti.value = parseInt(jumlahRoti.value) - 1;
            updateTotalPrice(); // Update total price saat jumlah roti berubah
        }
    }

    function selectRoti(name, imageUrl, price, stok, description, rasa, id_roti) {

        selectedRotiId =
            // Memperbarui gambar, nama, harga, deskripsi, dan rasa
            document.getElementById("selected-roti-image").src = imageUrl;
        document.getElementById("selected-roti-name").textContent = name;
        document.getElementById("selected-roti-price").textContent = "Harga: Rp " + price;
        document.getElementById("selected-roti-description").textContent = "Deskripsi: " + description;
        document.getElementById("selected-roti-rasa").textContent = "Rasa: " + rasa;
        document.getElementById("selected-roti-stok").textContent = "Stok: " + stok;
        document.getElementById('id_roti').value = id_roti;
        selectedPrice = parseInt(price.replace(/\D/g, '')); // Simpan harga roti yang dipilih

        // Menghapus kelas 'selected' dari semua thumbnail
        var thumbnails = document.querySelectorAll(".roti-thumbnail");
        thumbnails.forEach(function(thumbnail) {
            thumbnail.classList.remove("selected");
        });

        // Menambahkan kelas 'selected' pada thumbnail yang dipilih
        var selectedThumbnail = document.querySelector(
            `.roti-thumbnail[alt="${name}"]`
        );
        if (selectedThumbnail) {
            selectedThumbnail.classList.add("selected");
        } else {
            console.error('Thumbnail dengan nama yang dipilih tidak ditemukan:', name);
        }

        updateTotalPrice(); // Update total price saat roti dipilih
    }

    function updateTotalPrice() {
        var jumlahRoti = document.getElementById("jumlahRoti");
        var totalPrice = selectedPrice * parseInt(jumlahRoti.value);
        document.getElementById("totalPrice").textContent = 'Rp ' + totalPrice.toLocaleString();
        document.getElementById('total').value = totalPrice.toLocaleString();
    }

    // Menggulir ke atas saat ikon diklik
    window.addEventListener("scroll", function() {
        var geserKeAtas = document.getElementById("geserKeAtas");
        if (window.scrollY > 300) {
            geserKeAtas.classList.add("show");
        } else {
            geserKeAtas.classList.remove("show");
        }
    });

    document.getElementById("geserKeAtas").addEventListener("click", function() {
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    });

    // Menutup popup saat mengklik di luar popup
    window.onclick = function(event) {
        if (event.target == document.getElementById("searchPopup")) {
            closeSearchPopup();
        } else if (event.target == document.getElementById("buyPopup")) {
            closeBuyPopup();
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('masukan_kekeranjang').addEventListener('click', function(event) {
            event.preventDefault();

            var form = document.getElementById('buyForm');
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'proses/keranjang/keranjang.php', true);
            xhr.onload = function() {

                if (xhr.status === 200) {
                    var response = xhr.responseText.trim();
                    console.log(response); // Debugging

                    if (response === 'success') {
                        form.reset();
                        closeBuyPopup()
                        loadTable();
                        loadKeranjang()

                        Swal.fire({
                            title: "Suksess!",
                            text: "Roti Telah ditambahkan kedalam keranjang 😊",
                            icon: "success",
                            timer: 2300,
                            showConfirmButton: false, // Tidak menampilkan tombol OK
                        });
                    } else if (response === 'success_update') {
                        form.reset();
                        closeBuyPopup()
                        loadTable();
                        loadKeranjang()
                        Swal.fire({
                            title: "Suksess!",
                            text: "Jumlah Roti Telah ditambahkan ke Roti didalam Keranjang 😊",
                            icon: "success",
                            timer: 2900,
                            showConfirmButton: false,
                        });
                    } else if (response === 'stok_dikeranjang_masih_ada') {
                        Swal.fire({
                            title: "Maaf!",
                            text: "Maaf stok roti tidak mencukupi, Karenah ditambah dengan stok anda didalam keranjang",
                            icon: "info",
                            timer: 4000, // 2 detik
                            showConfirmButton: false,
                        });
                    } else if (response === 'stok_tidak_cukup') {
                        Swal.fire({
                            title: "Maaf!",
                            text: "Maaf stok roti tidak mencukupi, silakan kurangi stok roti atau pilih roti lain",
                            icon: "info",
                            timer: 4000, // 2 detik
                            showConfirmButton: false,
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
                            text: "Gagal mengedit data",
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

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('beli_sekarang').addEventListener('click', function(event) {
            event.preventDefault();

            var form = document.getElementById('buyForm');
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'proses/keranjang/pemesanan.php', true);
            xhr.onload = function() {

                if (xhr.status === 200) {
                    var response = xhr.responseText.trim();

                    if (response.startsWith(
                            'success:')) { // Check if response starts with 'success:'
                        form.reset();
                        closeBuyPopup()
                        loadTable();
                        var nomor_pemesanan = response.substring('success:'.length);
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data berhasil di-checkout 😊',
                            timer: 1200,
                            showConfirmButton: false
                        }).then(() => {
                            // Redirect to detail_pembayaran page with nomor_pemesanan
                            window.location.href =
                                'detail_pembayaran?nomor_pemesanan=' +
                                encodeURIComponent(nomor_pemesanan);
                        });
                    } else if (response === 'stok_dikeranjang_masih_ada') {
                        Swal.fire({
                            title: "Maaf!",
                            text: "Maaf stok roti tidak mencukupi, Karenah ditambah dengan stok anda didalam keranjang",
                            icon: "info",
                            timer: 4000, // 2 detik
                            showConfirmButton: false,
                        });
                    } else if (response === 'stok_tidak_cukup') {
                        Swal.fire({
                            title: "Maaf!",
                            text: "Maaf stok roti tidak mencukupi, silakan kurangi stok roti atau pilih roti lain",
                            icon: "info",
                            timer: 4000, // 2 detik
                            showConfirmButton: false,
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
                            text: "Gagal mengedit data",
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

    function loadTable() {
        // Get current page and search query from URL
        var currentPage = new URLSearchParams(window.location.search).get('page') || 1;
        var searchQuery = new URLSearchParams(window.location.search).get('search') || '';

        var xhrTable = new XMLHttpRequest();
        xhrTable.onreadystatechange = function() {
            if (xhrTable.readyState == 4 && xhrTable.status == 200) {
                document.getElementById('load_data').innerHTML = xhrTable.responseText;
            }
        };

        // Send request with current page and search query
        xhrTable.open('GET', 'proses/promo/load_data.php?page=' + currentPage + '&search=' + encodeURIComponent(
            searchQuery), true);
        xhrTable.send();
    }

    function loadKeranjang() {
        // Get current page and search query from URL
        var currentPage = new URLSearchParams(window.location.search).get('page') || 1;
        var searchQuery = new URLSearchParams(window.location.search).get('search') || '';

        var xhrTable = new XMLHttpRequest();
        xhrTable.onreadystatechange = function() {
            if (xhrTable.readyState == 4 && xhrTable.status == 200) {
                document.getElementById('load_keranjang').innerHTML = xhrTable.responseText;
            }
        };

        // Send request with current page and search query
        xhrTable.open('GET', 'proses/promo/load_keranjang_promo.php');
        xhrTable.send();
    }
    </script>


    <!-- jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js?v=<?= time(); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js?v=<?= time(); ?>"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js?v=<?= time(); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js?v=<?= time(); ?>"></script>
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