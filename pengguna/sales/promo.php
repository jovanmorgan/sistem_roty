<!-- penggunah -->
<?php include 'fitur/penggunah.php'; ?>

<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<?php include 'fitur/head.php'; ?>

<body translate="no">

    <!-- Header -->
    <?php include 'fitur/header.php'; ?>

    <!-- sidebar -->
    <?php include 'fitur/sidebar.php'; ?>

    <main id="main" class="main">

        <!-- title -->
        <?php include 'fitur/title.php'; ?>

        <?php include 'fitur/papan_nama.php'; ?>
        <div id="load_data">
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <!-- Search Form -->
                                <form method="GET" action="">
                                    <div class="input-group mt-3">
                                        <input type="text" class="form-control" placeholder="Cari roti..." name="search"
                                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

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

                    // Query to count total records
                    $total_result = mysqli_query($koneksi, "SELECT COUNT(DISTINCT roti.id_roti) AS total
            FROM roti
            LEFT JOIN promo ON roti.id_roti = promo.id_roti
            WHERE roti.nama_roti LIKE '%$search%'");
                    $total_row = mysqli_fetch_assoc($total_result);
                    $total_roti = $total_row['total'];
                    $total_pages = ceil($total_roti / $limit);

                    // Query to fetch limited records with search and join promo
                    $result = mysqli_query($koneksi, "SELECT promo.*, roti.nama_roti, roti.harga, roti.stok, roti.berat, roti.rasa, roti.vitamin, roti.gula, roti.deskripsi, roti.gambar_roti
            FROM promo
            LEFT JOIN roti ON promo.id_roti = roti.id_roti
            WHERE roti.nama_roti LIKE '%$search%'
            LIMIT $limit OFFSET $offset");

                    if (mysqli_num_rows($result) > 0) {
                        // Looping data roti
                        while ($row = mysqli_fetch_assoc($result)) {
                            $nama_roti = $row['nama_roti'];
                            $harga = $row['harga'];
                            $stok = $row['stok'];
                            $potongan_harga = $row['potongan_harga'];
                            $berat = $row['berat'];
                            $rasa = $row['rasa'];
                            $vitamin = $row['vitamin'];
                            $gula = $row['gula'];
                            $deskripsi = $row['deskripsi'];
                            $gambar_roti = $row['gambar_roti'];

                            // Calculate final price after discount
                            $harga_total = $harga + $potongan_harga;
                            $harga_final = $harga + $potongan_harga;
                            if (!empty($potongan_harga)) {
                                $harga_final -= $potongan_harga;
                            }
                    ?>
                            <div class="col-lg-4">
                                <div class="card">
                                    <img src="../../assets/img/roti/<?php echo $gambar_roti; ?>" class="card-img-top"
                                        alt="Gambar <?php echo $nama_roti; ?>" />
                                    <div class="card-body">
                                        <!-- Title -->
                                        <h5 class="card-title" style="font-size: 25px;"><?php echo $nama_roti; ?></h5>

                                        <!-- Description -->
                                        <p class="card-text">"<?php echo $deskripsi; ?>"</p>

                                        <!-- Price -->
                                        <h4 class="card-price">
                                            Rp <?php echo number_format($harga_final, 0, ',', '.'); ?>
                                            <?php if (!empty($potongan_harga)): ?>
                                                <span class="text-muted text-decoration-line-through">Rp
                                                    <?php echo number_format($harga_total, 0, ',', '.'); ?></span><br>
                                                <span class="text-success">(- Rp
                                                    <?php echo number_format($potongan_harga, 0, ',', '.'); ?>)</span>
                                            <?php endif; ?>
                                        </h4>

                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingOne">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#flush-collapseOne-<?php echo $row['id_promo']; ?>"
                                                        aria-expanded="false"
                                                        aria-controls="flush-collapseOne-<?php echo $row['id_promo']; ?>">
                                                        Detail Roti
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseOne-<?php echo $row['id_promo']; ?>"
                                                    class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        <!-- Item Details -->
                                                        <ul class="list-unstyled">
                                                            <li><strong>Stok:</strong> <?php echo $stok; ?></li>
                                                            <li><strong>Berat:</strong> <?php echo $berat; ?>g</li>
                                                            <li><strong>Rasa:</strong> <?php echo $rasa; ?></li>
                                                            <li><strong>Vitamin:</strong> <?php echo $vitamin; ?></li>
                                                            <li><strong>Gula:</strong> <?php echo $gula; ?>g</li>
                                                            <?php if (!empty($potongan_harga)): ?>
                                                                <li><strong>Potongan Harga:</strong> Rp
                                                                    <?php echo number_format($potongan_harga, 0, ',', '.'); ?></li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Action Buttons -->
                                        <div class="d-flex justify-content-between mt-3">
                                            <button onclick="hapus('<?php echo $row['id_promo']; ?>');"
                                                class="btn btn-danger">Delete</button>
                                            <!-- Button Edit (Bagian yang sudah ada, ditambahkan script edit) -->
                                            <button
                                                onclick="openEditModal('<?php echo $row['id_promo']; ?>', '<?php echo addslashes($row['id_roti']); ?>', '<?php echo addslashes($row['potongan_harga']); ?>');"
                                                class="btn btn-primary">Edit</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<div class='col-12'><p class='text-center'>Tidak ada data roti 😖.</p></div>";
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
                                <nav aria-label="Page navigation example" style="margin-top: 2.2rem;">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item <?php if ($page <= 1) {
                                                                    echo 'disabled';
                                                                } ?>">
                                            <a class="page-link" href="<?php if ($page > 1) {
                                                                            echo "?page=" . ($page - 1) . "&search=" . $search;
                                                                        } ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                            <li class="page-item <?php if ($i == $page) {
                                                                        echo 'active';
                                                                    } ?>">
                                                <a class="page-link"
                                                    href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php } ?>
                                        <li class="page-item <?php if ($page >= $total_pages) {
                                                                    echo 'disabled';
                                                                } ?>">
                                            <a class="page-link" href="<?php if ($page < $total_pages) {
                                                                            echo "?page=" . ($page + 1) . "&search=" . $search;
                                                                        } ?>" aria-label="Next">
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

        <!-- Modal -->
        <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahDataModalLabel">Tambah Promo</h5>
                        <button type="button" class="btn-close" id="closeTambahModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="tambahForm" method="POST" action="proses/promo/tambah.php"
                            enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="id_roti" class="form-label">Nama Roti</label>
                                <select id="id_roti" class="form-select" name="id_roti" aria-label="Pilih Nama Roti"
                                    required>
                                    <option value="" selected>Pilih Roti</option>
                                    <!-- Options will be added by JavaScript -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="harga_roti" class="form-label">Harga Roti</label>
                                <input type="text" id="harga_roti" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="gambar_roti" class="form-label">Gambar Roti</label>
                                <div id="gambar_roti_container">
                                    <img id="gambar_roti" class="img-fluid"
                                        alt="Gambar roti tidak ada, Silakan pilih data roti" style="max-width: 100%;">
                                    <p id="no_image_message" style="display: none; color: red;">Data roti belum
                                        dipilih
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="potongan_harga" class="form-label">Potongan Harga</label>
                                <input type="number" id="potongan_harga" name="potongan_harga" class="form-control"
                                    min="0" required>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel">Edit Promo</h5>
                        <button type="button" class="btn-close" id="closeEditModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST" action="proses/promo/edit.php" enctype="multipart/form-data">
                            <input type="hidden" id="edit_id_promo" name="id_promo">
                            <div class="mb-3">
                                <label for="edit_id_roti" class="form-label">Nama Roti</label>
                                <select id="edit_id_roti" class="form-select" name="id_roti"
                                    aria-label="Pilih Nama Roti" required>
                                    <option value="" selected>Pilih Roti</option>
                                    <!-- Options will be added by JavaScript -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_harga_roti" class="form-label">Harga Roti</label>
                                <input type="text" id="edit_harga_roti" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="edit_gambar_roti" class="form-label">Gambar Roti</label>
                                <div id="edit_gambar_roti_container">
                                    <img id="edit_gambar_roti" class="img-fluid"
                                        alt="Gambar roti tidak ada, Silakan pilih data roti" style="max-width: 100%;">
                                    <p id="edit_no_image_message" style="display: none; color: red;">Data roti belum
                                        dipilih</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_potongan_harga" class="form-label">Potongan Harga</label>
                                <input type="number" id="edit_potongan_harga" name="potongan_harga" class="form-control"
                                    min="0" required>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const idRotiSelect = document.getElementById('edit_id_roti');
                const hargaRotiInput = document.getElementById('edit_harga_roti');
                const gambarRotiImg = document.getElementById('edit_gambar_roti');
                const noImageMessage = document.getElementById('edit_no_image_message');

                // Load all roti options
                <?php
                include '../../keamanan/koneksi.php';

                $result = mysqli_query($koneksi, "SELECT id_roti, nama_roti FROM roti");

                while ($row = mysqli_fetch_assoc($result)) {
                    $id_roti = $row['id_roti'];
                    $nama_roti = $row['nama_roti'];

                    // Cek apakah roti sudah dipromosikan
                    $promoQuery = "SELECT COUNT(*) AS count FROM promo WHERE id_roti = $id_roti";
                    $promoResult = mysqli_fetch_assoc(mysqli_query($koneksi, $promoQuery));
                    $promoText = ($promoResult['count'] > 0) ? " - data sudah dipromosikan" : "";

                    echo "idRotiSelect.innerHTML += `<option value=\"$id_roti\">$nama_roti $promoText</option>`;";
                }
                ?>

                // Fetch details when roti is selected
                idRotiSelect.addEventListener('change', function() {
                    const selectedId = this.value;
                    if (selectedId) {
                        fetch(`proses/promo/detail_roti.php?id_roti=${selectedId}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data) {
                                    // Update form fields
                                    hargaRotiInput.value = data.harga;
                                    gambarRotiImg.src = `../../assets/img/roti/${data.gambar_roti}`;
                                    noImageMessage.style.display = 'none';
                                } else {
                                    clearForm();
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                clearForm();
                            });
                    } else {
                        clearForm();
                    }
                });

                function clearForm() {
                    hargaRotiInput.value = '';
                    gambarRotiImg.src = '';
                    noImageMessage.style.display = 'block';
                }

                window.openEditModal = function(idPromo, idRoti, potonganHarga) {
                    const modal = new bootstrap.Modal(document.getElementById('editDataModal'));
                    document.getElementById('edit_id_promo').value = idPromo;
                    document.getElementById('edit_potongan_harga').value = potonganHarga;

                    // Simulate a change to trigger data loading
                    idRotiSelect.value = idRoti;
                    idRotiSelect.dispatchEvent(new Event('change'));

                    modal.show();
                }
            });

            const idRotiSelect = document.getElementById('id_roti');
            const hargaRotiInput = document.getElementById('harga_roti');
            const gambarRotiImg = document.getElementById('gambar_roti');
            const noImageMessage = document.getElementById('no_image_message');

            document.addEventListener('DOMContentLoaded', function() {
                <?php
                include '../../keamanan/koneksi.php';

                // Query untuk mendapatkan semua roti
                $result = mysqli_query($koneksi, "SELECT id_roti, nama_roti FROM roti");

                while ($row = mysqli_fetch_assoc($result)) {
                    $id_roti = $row['id_roti'];
                    $nama_roti = $row['nama_roti'];

                    // Cek apakah roti sudah dipromosikan
                    $promoQuery = "SELECT COUNT(*) AS count FROM promo WHERE id_roti = $id_roti";
                    $promoResult = mysqli_fetch_assoc(mysqli_query($koneksi, $promoQuery));
                    $promoText = ($promoResult['count'] > 0) ? " - data sudah dipromosikan" : "";

                    echo "idRotiSelect.innerHTML += `<option value=\"$id_roti\">$nama_roti$promoText</option>`;";
                }
                ?>

                idRotiSelect.addEventListener('change', function() {
                    const selectedId = this.value;
                    if (selectedId) {
                        fetch(`proses/promo/detail_roti.php?id_roti=${selectedId}`)
                            .then(response => response.json())
                            .then(data => {
                                // Tampilkan data roti
                                hargaRotiInput.value = data.harga;
                                gambarRotiImg.src = `../../assets/img/roti/${data.gambar_roti}`;
                                noImageMessage.style.display = 'none'; // Sembunyikan pesan

                                if (data.sudah_dipromosikan) {
                                    // Tampilkan pesan peringatan bahwa roti sudah dipromosikan
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Peringatan',
                                        text: 'Roti ini sudah memiliki promo aktif.'
                                    });
                                }
                            });
                    } else {
                        hargaRotiInput.value = '';
                        gambarRotiImg.src = '';
                        noImageMessage.style.display = 'block'; // Tampilkan pesan
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('tambahForm').addEventListener('submit', function(event) {
                    event.preventDefault(); // Menghentikan aksi default form submit

                    var form = this;
                    var formData = new FormData(form);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'proses/promo/tambah.php', true);
                    xhr.onload = function() {

                        if (xhr.status === 200) {
                            var response = xhr.responseText.trim();
                            console.log(response); // Debugging

                            if (response === 'success') {
                                form.reset();
                                document.getElementById('closeTambahModal').click();
                                gambarRotiImg.src = ``;
                                noImageMessage.style.display = 'block';
                                loadTable(); // reload table data

                                Swal.fire({
                                    title: "Berhasil!",
                                    text: "Data berhasil ditambahkan",
                                    icon: "success",
                                    timer: 1200, // 1,2 detik
                                    showConfirmButton: false, // Tidak menampilkan tombol OK
                                }).then(() => {
                                    location.reload();
                                })
                            } else if (response === 'roti_sudah_ada') {
                                Swal.fire({
                                    title: "Error",
                                    text: "Data Roti sudah dipromosikan, silakan pilih data roti lainnya",
                                    icon: "info",
                                    timer: 2000, // 2 detik
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
                document.getElementById('editForm').addEventListener('submit', function(event) {
                    event.preventDefault(); // Menghentikan aksi default form submit

                    var form = this;
                    var formData = new FormData(form);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'proses/promo/edit.php', true);
                    xhr.onload = function() {

                        if (xhr.status === 200) {
                            var response = xhr.responseText.trim();
                            console.log(response); // Debugging

                            if (response === 'success') {
                                form.reset();
                                document.getElementById('closeEditModal').click();
                                gambarRotiImg.src = ``;
                                noImageMessage.style.display = 'block';
                                loadTable(); // reload table data

                                Swal.fire({
                                    title: "Berhasil!",
                                    text: "Data berhasil diperbarui",
                                    icon: "success",
                                    timer: 1200, // 1,2 detik
                                    showConfirmButton: false, // Tidak menampilkan tombol OK
                                }).then(() => {
                                    location.reload();
                                });
                            } else if (response === 'roti_sudah_ada') {
                                Swal.fire({
                                    title: "Error",
                                    text: "Data Roti sudah dipromosikan, silakan pilih data roti lainnya",
                                    icon: "info",
                                    timer: 2000, // 2 detik
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
                            } else if (response.includes('Gagal memperbarui promo')) {
                                Swal.fire({
                                    title: "Error",
                                    text: response, // Menampilkan pesan error spesifik dari PHP
                                    icon: "error",
                                    timer: 2000, // 2 detik
                                    showConfirmButton: false,
                                });
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: "Terjadi kesalahan yang tidak diketahui",
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


            function hapus(id) {
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal",
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengonfirmasi untuk menghapus
                        var xhr = new XMLHttpRequest();

                        xhr.open('POST', 'proses/promo/hapus.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onload = function() {

                            if (xhr.status === 200) {
                                var response = xhr.responseText.trim();
                                if (response === 'success') {
                                    loadTable();
                                    Swal.fire({
                                        title: 'Sukses!',
                                        text: 'Data berhasil dihapus.',
                                        icon: 'success',
                                        timer: 1200, // 1,2 detik
                                        showConfirmButton: false // Menghilangkan tombol OK
                                    }).then(() => {
                                        location.reload()
                                    })
                                } else if (response === 'error') {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Gagal menghapus Data.',
                                        icon: 'error',
                                        timer: 2000, // 2 detik
                                        showConfirmButton: false // Menghilangkan tombol OK
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Terjadi kesalahan saat mengirim data.',
                                        icon: 'error',
                                        timer: 2000, // 2 detik
                                        showConfirmButton: false // Menghilangkan tombol OK
                                    });
                                }
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Terjadi kesalahan saat mengirim data.',
                                    icon: 'error',
                                    timer: 2000, // 2 detik
                                    showConfirmButton: false // Menghilangkan tombol OK
                                });
                            }
                        };
                        xhr.send("id=" + id);
                    } else {
                        // Jika pengguna membatalkan penghapusan
                        Swal.fire({
                            title: 'Penghapusan dibatalkan',
                            icon: 'info',
                            timer: 1500, // 1,5 detik
                            showConfirmButton: false // Menghilangkan tombol OK
                        });
                    }
                });
            }

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
        </script>

    </main>
    <!-- End #main -->

    <?php include 'fitur/bagian_akhir.php'; ?>

</body>

</html>