<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Keranjang Belanja</title>

    <!--=============== BOXICONS ===============-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css?v=<?= time(); ?>" />
    <link href="../../assets/img/loding_donat.png" rel="icon" />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="css/nav_keranjang.css?v=<?= time(); ?>" />
    <link rel="stylesheet" href="../../assets/css/loding.css?v=<?= time(); ?>" />

    <link rel="stylesheet" href="css/keranjang.css?v=<?= time(); ?>" media="screen" title="no title" charset="utf-8" />
    <script src="https://code.jquery.com/jquery-2.2.4.js?v=<?= time(); ?>" charset="utf-8"></script>
    <meta name="robots" content="noindex,follow" />
</head>


<body translate="no" translate="no">
    <!--=============== HEADER ===============-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="promo" class="nav__logo"><i class="bx bx-arrow-back"
                    style="font-size: 2.3em; position: relative; left: 15px;"></i>
            </a>
            <a href="promo" class="nav__logo">
                <h1><b>Keranjang Saya</b></h1>
            </a>

            <div class="nav__kiri">
                <a href="#" class="nav__search-icon"> </a>
                <a href="#" onclick="hapusSemuaProduk()">
                    <i class="bx bx-trash"></i>
                </a>
            </div>
        </nav>
    </header>
    <!-- jarak -->
    <div class="jarak" style="height: 50px"></div>
    <!-- akhir jarak -->
    <form id="form_keranjang" action="proses/keranjang/tambah.php" method="post">
        <!-- bentuk mobile -->
        <div class="nav__menu chackout" id="nav-menu" style="z-index: 200;">
            <ul class="nav__list">
                <div class="buttons" style="position: relative; bottom: 18px">
                    <input type="checkbox" id="select-all-mobile" />
                </div>
                <li class="nav__item" style="margin-top: 10px">
                    <h4 class="total">Total : <span id="totalSemua">Rp 0</span></h4>
                </li>
                <li class="nav__item">
                    <button class="tombolCheckout" id="pilihSemuaRoti-bentukMobile" type="submit">
                        Checkout
                    </button>
                </li>
            </ul>
        </div>
        <!-- <div class="subtitle" style="justify-content: end; padding: 0; margin: 0; height: 0px; position: relative; right: 30px; bottom: 38px; display: flex">Rasa : ' . htmlspecialchars($row['rasa']) . '</div> -->
        <div class="load_data">
            <?php
            include '../../keamanan/koneksi.php';

            $id_mitra = $_SESSION['id_mitra'];

            $query = "
        SELECT keranjang.*, roti.nama_roti, roti.harga, roti.stok, roti.gambar_roti, roti.rasa
        FROM keranjang
        JOIN roti ON keranjang.id_roti = roti.id_roti
        WHERE keranjang.id_mitra = '$id_mitra'
        ";

            $result = mysqli_query($koneksi, $query);

            $formCount = 0;

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="shopping-cart">
                    <div class="title">' . htmlspecialchars($row['nama_roti']) . '</div>
                    <input type="hidden" id="id_keranjang_' . $formCount . '" name="id_keranjang[]" value="' . htmlspecialchars($row['id_keranjang']) . '">
                    <input type="hidden" id="id_roti_' . $formCount . '" name="id_roti[]" value="' . htmlspecialchars($row['id_roti']) . '">
                    <input type="hidden" id="harga_' . $formCount . '" name="harga[]" value="' . htmlspecialchars($row['harga']) . '">
                    <input type="hidden" id="jumlah_' . $formCount . '" name="jumlah[]" value="' . htmlspecialchars($row['jumlah']) . '">
                    <input type="hidden" id="total_' . $formCount . '" name="total[]" value="' . htmlspecialchars($row['total']) . '">
                    <input type="hidden" id="id_mitra_' . $formCount . '" name="id_mitra[]" value="' . $id_mitra . '">

                    <div class="item">
                        <div class="buttons">
                            <input type="checkbox" class="product-checkbox" name="selected_products[]" value="' . $formCount . '" data-total="' . htmlspecialchars($row['total']) . '" />
                        </div>
                        <div class="image">
                            <img src="../../assets/img/roti/' . htmlspecialchars($row['gambar_roti']) . '" alt="" width="100px" height="100px" style="object-fit: cover; position: relative; bottom: 10px;" />
                        </div>
                        <div class="description">
                            <span>Stok : ' . number_format($row['stok'], 0, ',', '.') . '</span>
                            <span>Rp.' . number_format($row['harga'], 0, ',', '.') . '</span>
                        </div>
                        <div id="formJumlah1" class="quantity">
                            <button class="plus-btn" type="button" name="button" id="tambah1">
                                <img src="img/card_keranjang/plus.svg" alt="" />
                            </button>
                            <input type="text" name="jumlah1" value="' . htmlspecialchars($row['jumlah']) . '" disabled />
                            <button class="minus-btn" type="button" name="button" id="kurang1">
                                <img src="img/card_keranjang/minus.svg" alt="" />
                            </button>
                        </div>
                        <div class="total-price">Rp' . number_format($row['total'], 0, ',', '.') . '</div>
                    </div>
                     <div class="item2">
                            <div class="quantity">
                                <button class="plus-btn" type="button" name="button" id="tambah2">
                                    <img src="img/card_keranjang/plus.svg" alt="" />
                                </button>
                                <input type="text" name="jumlah2" value="' . htmlspecialchars($row['jumlah']) . '" disabled />
                                <button class="minus-btn" type="button" name="button" id="kurang2">
                                    <img src="img/card_keranjang/minus.svg" alt="" />
                                </button>
                            </div>
                            <div class="total-price">Rp' . number_format($row['total'], 0, ',', '.') . '</div>
                        </div>
                </div>';

                        $formCount++;
                    }
                } else {
                    echo '<p style="text-align: center; margin-top: 100px">Keranjang Anda Kosong 😊. <br> Silakan Pesan terlebih dahulu!</p>';
                }
            } else {
                echo 'Terjadi kesalahan saat mengambil data keranjang.';
            }

            mysqli_close($koneksi);
            ?>
        </div>
        <!-- bentuk pc -->
        <div class="shopping-cart2">
            <div class="item">
                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list" style="position: relative; top: 25px">
                        <div class="buttons" style="position: relative; bottom: 25px">
                            <input type="checkbox" id="select-all" />
                        </div>
                        <li class="nav__item">
                            <h4 class="total" style="position: relative; top: -2px">
                                Total : <span id="grand-total">Rp0</span>
                            </h4>
                        </li>
                        <li class="nav__item" style="position: absolute; left: 600px; bottom: 18px;">
                            <button class="tombolCheckout" id="pilihSemuaRoti" type="submit">
                                Checkout
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </form>

    <style>
        .tombolCheckout {
            background-color: hsl(30, 100%, 56%);
            /* Warna latar belakang */
            color: #fff;
            /* Warna teks */
            border: none;
            /* Menghilangkan border default */
            border-radius: 5px;
            /* Membuat sudut tombol melengkung */
            padding: 10px 20px;
            /* Jarak dalam tombol */
            font-size: 16px;
            /* Ukuran font */
            font-weight: bold;
            /* Menebalkan teks */
            text-transform: uppercase;
            /* Mengubah teks menjadi huruf kapital */
            cursor: pointer;
            /* Menunjukkan kursor tangan saat hover */
            transition: all 0.3s ease;
            /* Transisi halus untuk efek hover */
        }

        .tombolCheckout:hover {
            background-color: hsl(30, 100%, 66%);
            /* Warna latar belakang saat hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Bayangan saat hover */
        }

        .tombolCheckout:active {
            background-color: hsl(30, 100%, 46%);
            /* Warna latar belakang saat tombol ditekan */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            /* Bayangan saat tombol ditekan */
            transform: translateY(2px);
            /* Efek tombol ditekan */
        }
    </style>
    <!-- jarak -->
    <div class="jarak" style="height: 80px"></div>

    <!-- akhir jarak -->
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('form_keranjang');
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const selectAllCheckbox = document.getElementById('select-all');
            const selectAllCheckboxhp = document.getElementById('select-all-mobile');

            // Handle form submission
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                const selectedProducts = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                // Remove unchecked products from form data
                checkboxes.forEach((checkbox, index) => {
                    if (!selectedProducts.includes(checkbox.value)) {
                        // Remove corresponding hidden inputs
                        document.getElementById('id_keranjang_' + index).remove();
                        document.getElementById('id_roti_' + index).remove();
                        document.getElementById('harga_' + index).remove();
                        document.getElementById('jumlah_' + index).remove();
                        document.getElementById('total_' + index).remove();
                    }
                });

                if (selectedProducts.length > 0) {
                    // If there are selected products, submit the form
                    var formData = new FormData(form);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', form.action, true);
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            var response = xhr.responseText.trim();

                            if (response.startsWith(
                                    'success:')) { // Check if response starts with 'success:'
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
                            } else if (response === 'data_tidak_lengkap') {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Mohon Maaf!',
                                    text: 'Pesanan anda kosong, silakan buat pesanan terlebih dahulu!',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Gagal menambahkan data',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat mengirim data',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    };
                    xhr.send(formData);
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Tidak ada produk yang dipilih',
                        text: 'Pilih produk yang ingin Anda checkout!',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            });

            // Select all checkboxes
            selectAllCheckbox.addEventListener('change', function() {
                const checked = this.checked;
                checkboxes.forEach(checkbox => checkbox.checked = checked);
                updateGrandTotal();
            });

            // Select all checkboxes bentuk hp
            selectAllCheckboxhp.addEventListener('change', function() {
                const checked = this.checked;
                checkboxes.forEach(checkbox => checkbox.checked = checked);
                updateGrandTotal();
            });

            // Update select-all checkbox based on individual product checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectAllCheckbox();
                    updateGrandTotal();
                });
            });

            // Update select-all checkbox based on individual product checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectAllCheckboxHp();
                    updateGrandTotal();
                });
            });

            function updateSelectAllCheckbox() {
                selectAllCheckbox.checked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            }

            function updateSelectAllCheckboxHp() {
                selectAllCheckboxhp.checked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            }

            // Update total harga
            function updateGrandTotal() {
                let grandTotal = 0;
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        grandTotal += parseInt(checkbox.getAttribute('data-total'));
                    }
                });
                document.getElementById('grand-total').textContent = 'Rp' + grandTotal.toLocaleString('id-ID');
                document.getElementById('totalSemua').textContent = 'Rp' + grandTotal.toLocaleString('id-ID');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            var updateTotal = function(jumlah, harga, totalElement) {
                var total = jumlah * harga;
                totalElement.textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(total);
            };

            var tambahJumlah = function(form, jumlahInput, totalElement) {
                var formData = new FormData(form);
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'proses/keranjang/tambahJumlah.php', true);

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = xhr.responseText.trim();
                        if (response === 'success') {
                            location.reload();
                        } else if (response === 'stok_tidak_cukup') {
                            Swal.fire({
                                title: "Maaf!",
                                text: "Stok roti tidak mencukupi, silakan kurangi stok atau pilih roti lain",
                                icon: "info",
                                timer: 2000, // 2 detik
                                showConfirmButton: false,
                            }).then(() => {
                                location.reload();
                            });
                        } else if (response === 'data_tidak_lengkap') {
                            Swal.fire({
                                title: "Error",
                                text: "Data tidak lengkap",
                                icon: "info",
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        } else {
                            Swal.fire({
                                title: "Error",
                                text: "Gagal mengedit data",
                                icon: "error",
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        }
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan saat mengirim data",
                            icon: "error",
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    }
                };
                xhr.send(formData);
            };

            var kurangJumlah = function(form, jumlahInput, totalElement) {
                var formData = new FormData(form);
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'proses/keranjang/kurangJumlah.php', true);

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = xhr.responseText.trim();
                        if (response === 'success') {
                            location.reload();
                        } else if (response === 'data_tidak_lengkap') {
                            Swal.fire({
                                title: "Error",
                                text: "Data tidak lengkap",
                                icon: "info",
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        } else {
                            Swal.fire({
                                title: "Error",
                                text: "Gagal mengedit data",
                                icon: "error",
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        }
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan saat mengirim data",
                            icon: "error",
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    }
                };
                xhr.send(formData);
            };

            document.querySelectorAll('.plus-btn').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    var form = button.closest('form');
                    var jumlahInput = button.closest('.shopping-cart').querySelector(
                        '[name="jumlah[]"]');
                    var totalElement = button.closest('.shopping-cart').querySelector(
                        '.total-price');
                    jumlahInput.value = parseInt(jumlahInput.value) + 1;
                    tambahJumlah(form, jumlahInput, totalElement);
                });
            });

            document.querySelectorAll('.minus-btn').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    var form = button.closest('form');
                    var jumlahInput = button.closest('.shopping-cart').querySelector(
                        '[name="jumlah[]"]');
                    var totalElement = button.closest('.shopping-cart').querySelector(
                        '.total-price');
                    if (parseInt(jumlahInput.value) > 0) {
                        jumlahInput.value = parseInt(jumlahInput.value) - 1;
                        kurangJumlah(form, jumlahInput, totalElement);
                    }
                });
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
            xhrTable.open('GET', 'proses/promo/load_data.php?page=' + currentPage + '&search=' +
                encodeURIComponent(
                    searchQuery), true);
            xhrTable.send();
        }
    </script>
</body>

</html>