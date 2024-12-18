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
                    $total_result = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM roti WHERE nama_roti LIKE '%$search%'");
                    $total_row = mysqli_fetch_assoc($total_result);
                    $total_roti = $total_row['total'];
                    $total_pages = ceil($total_roti / $limit);

                    // Query to fetch limited records with search
                    $result = mysqli_query($koneksi, "SELECT * FROM roti WHERE nama_roti LIKE '%$search%' LIMIT $limit OFFSET $offset");

                    if (mysqli_num_rows($result) > 0) {
                        // Looping data roti
                        while ($row = mysqli_fetch_assoc($result)) {
                            $nama_roti = $row['nama_roti'];
                            $harga = $row['harga'];
                            $stok = $row['stok'];
                            $berat = $row['berat'];
                            $rasa = $row['rasa'];
                            $vitamin = $row['vitamin'];
                            $gula = $row['gula'];
                            $deskripsi = $row['deskripsi'];
                            $gambar_roti = $row['gambar_roti'];
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
                                <h4 class="card-price">Rp <?php echo number_format($harga, 0, ',', '.'); ?></h4>

                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapseOne-<?php echo $row['id_roti']; ?>"
                                                aria-expanded="false"
                                                aria-controls="flush-collapseOne-<?php echo $row['id_roti']; ?>">
                                                Detail Roti
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-<?php echo $row['id_roti']; ?>"
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
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-between mt-3">
                                    <button onclick="hapus('<?php echo $row['id_roti']; ?>');"
                                        class="btn btn-danger">Delete</button>
                                    <button
                                        onclick="openEditModal('<?php echo $row['id_roti']; ?>', '<?php echo addslashes($nama_roti); ?>', '<?php echo $harga; ?>', '<?php echo $stok; ?>', '<?php echo $deskripsi; ?>', '<?php echo $berat; ?>', '<?php echo $rasa; ?>', '<?php echo $vitamin; ?>', '<?php echo $gula; ?>', '<?php echo $gambar_roti; ?>');"
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


        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data Roti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" id="closeEditModal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST" action="proses/roti/edit.php" enctype="multipart/form-data">
                            <input type="hidden" name="id_roti" id="edit_id_roti">

                            <div class="mb-3">
                                <label for="edit_nama_roti" class="form-label">Nama Roti</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-bread-line"></i></span>
                                    <input type="text" class="form-control" id="edit_nama_roti" name="nama_roti"
                                        required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="edit_harga" class="form-label">Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-money-dollar-circle-line"></i></span>
                                    <input type="number" class="form-control" id="edit_harga" name="harga" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="edit_stok" class="form-label">Stok</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-money-dollar-circle-line"></i></span>
                                    <input type="number" class="form-control" id="edit_stok" name="stok" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="edit_berat" class="form-label">Berat (g)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-weight-line"></i></span>
                                    <input type="text" class="form-control" id="edit_berat" name="berat" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="edit_rasa" class="form-label">Rasa</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-restaurant-line"></i></span>
                                    <input type="text" class="form-control" id="edit_rasa" name="rasa" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="edit_vitamin" class="form-label">Vitamin</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-capsule-line"></i></span>
                                    <input type="text" class="form-control" id="edit_vitamin" name="vitamin" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="edit_gula" class="form-label">Gula (g)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-cup-line"></i></span>
                                    <input type="text" class="form-control" id="edit_gula" name="gula" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-file-text-line"></i></span>
                                    <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"
                                        required></textarea>
                                </div>
                            </div>

                            <!-- Data Kover -->
                            <div class="form-group">
                                <label for="kover">Data Kover:</label>
                                <input type="file" class="form-control-file d-none" id="editKover" name="gambar_roti"
                                    onchange="previewImageAndSetExisting(this, 'editkoverPreview')" accept="image/*">
                                <label class="btn btn-primary" for="editKover"><i class="ri-image-line"></i> Pilih
                                    Gambar</label>
                            </div>

                            <!-- Preview Kover -->
                            <div class="card" id="editkoverPreview" style="display: none; margin-top: 10px">
                                <img class="card-img-top" id="editkoverImage" src="#" alt="Kover Image">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        function openEditModal(id, nama_roti, harga, stok, deskripsi, berat, rasa, vitamin, gula, gambar_roti) {
            // Set data to modal inputs
            document.getElementById('edit_id_roti').value = id;
            document.getElementById('edit_nama_roti').value = nama_roti;
            document.getElementById('edit_harga').value = harga;
            document.getElementById('edit_stok').value = stok;
            document.getElementById('edit_berat').value = berat;
            document.getElementById('edit_rasa').value = rasa;
            document.getElementById('edit_vitamin').value = vitamin;
            document.getElementById('edit_gula').value = gula;
            document.getElementById('edit_deskripsi').value = deskripsi;

            let gambar = "../../assets/img/roti/" + gambar_roti;
            let editModal = new bootstrap.Modal(document.getElementById('editModal'));

            // Show preview of the existing image if available
            if (gambar !== '') {
                var koverPreview = document.getElementById('editkoverPreview');
                var koverImage = document.getElementById('editkoverImage');
                koverImage.src = gambar;
                koverPreview.style.display = 'block';
            }

            // Show the modal
            editModal.show();
        }

        function previewImageAndSetExisting(input, previewId) {
            var preview = document.getElementById(previewId);
            var image = document.getElementById('editkoverImage');
            var file = input.files[0];
            var fileType = file.type;

            if (fileType.match('image.*')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    image.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Mohon pilih file gambar.',
                });
                input.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('editForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Menghentikan aksi default form submit

                var form = this;
                var formData = new FormData(form);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'proses/roti/edit.php', true);
                xhr.onload = function() {

                    if (xhr.status === 200) {
                        var response = xhr.responseText.trim();
                        console.log(response); // Debugging

                        if (response === 'success') {
                            form.reset();
                            document.getElementById('closeEditModal').click();
                            loadTable(); // reload table data
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Data berhasil diedit",
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
                        } else if (response === 'data_anggaran_salah') {
                            Swal.fire({
                                title: "Data Anggaran Salah!",
                                text: "Data Saldo Kas tidak boleh lebih besar dari jumlah anggaran",
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

                    xhr.open('POST', 'proses/roti/hapus.php', true);
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
                                });
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
            xhrTable.open('GET', 'proses/roti/load_data.php?page=' + currentPage + '&search=' + encodeURIComponent(
                searchQuery), true);
            xhrTable.send();
        }
        </script>



    </main>
    <!-- End #main -->

    <?php include 'fitur/bagian_akhir.php'; ?>

</body>

</html>