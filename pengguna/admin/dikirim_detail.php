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
                                        <input type="text" class="form-control"
                                            placeholder="Cari pemesanan atau nomor rekening..." name="search"
                                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                    </div>
                                    <!-- Include nomor_pemesanan in the form submission -->
                                    <input type="hidden" name="nomor_pemesanan"
                                        value="<?php echo htmlspecialchars($nomor_pemesanan); ?>">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php
            // Ambil data pemesanan dari database
            include '../../keamanan/koneksi.php';

            $nomor_pemesanan = isset($_GET['nomor_pemesanan']) ? $_GET['nomor_pemesanan'] : '';

            if (empty($nomor_pemesanan)) {
                echo "<p class='text-center mt-4'>Nomor pemesanan tidak ditemukan 😖.</p>";
                exit;
            }

            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            // Query for search functionality and pagination
            $query = "SELECT p.*, m.nama_lengkap, r.id_roti, r.nama_roti, r.nomor_sejenis, r.harga, r.stok, r.deskripsi, r.berat, r.rasa, r.vitamin, r.gula, r.gambar_roti 
              FROM pemesanan p 
              LEFT JOIN mitra m ON p.id_mitra = m.id_mitra 
              LEFT JOIN roti r ON p.id_roti = r.id_roti 
              WHERE p.nomor_pemesanan = ? 
              AND (m.nama_lengkap LIKE ? OR r.nama_roti LIKE ?)
              ORDER BY p.id_pemesanan DESC 
              LIMIT ?, ?";
            $search_term = "%" . $search . "%";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("sssii", $nomor_pemesanan, $search_term, $search_term, $offset, $limit);
            $stmt->execute();
            $result = $stmt->get_result();

            // Calculate total pages for pagination
            $total_query = "SELECT COUNT(*) as total 
                    FROM pemesanan p 
                    LEFT JOIN mitra m ON p.id_mitra = m.id_mitra 
                    LEFT JOIN roti r ON p.id_roti = r.id_roti 
                    WHERE p.nomor_pemesanan = ?
                    AND (m.nama_lengkap LIKE ? OR r.nama_roti LIKE ?)";
            $stmt_total = $koneksi->prepare($total_query);
            $stmt_total->bind_param("sss", $nomor_pemesanan, $search_term, $search_term);
            $stmt_total->execute();
            $total_result = $stmt_total->get_result();
            $total_row = $total_result->fetch_assoc();
            $total_pages = ceil($total_row['total'] / $limit);
            ?>

            <!-- Tabel Data pemesanan -->
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body" style="overflow-x: hidden;">
                                <!-- Overflow-x diatur untuk menyembunyikan scrollbar -->
                                <div style="overflow-x: auto;">
                                    <?php if ($result->num_rows > 0): ?>
                                    <table class="table table-hover text-center mt-3"
                                        style="border-collapse: separate; border-spacing: 0;">
                                        <thead>
                                            <tr>
                                                <th style="white-space: nowrap;">Nomor</th>
                                                <th style="white-space: nowrap;">Nama Mitra</th>
                                                <th style="white-space: nowrap;">Nama Roti</th>
                                                <th style="white-space: nowrap;">Harga</th>
                                                <th style="white-space: nowrap;">Jumlah</th>
                                                <th style="white-space: nowrap;">Total</th>
                                                <th style="white-space: nowrap;">Waktu Check out</th>
                                                <th style="white-space: nowrap;">Nomor Pemesanan</th>
                                                <th style="white-space: nowrap;">Foto Roti</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $nomor = $offset + 1;
                                                while ($row = $result->fetch_assoc()) :
                                                ?>
                                            <tr>
                                                <td><?php echo $nomor++; ?></td>
                                                <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                                                <td><?php echo htmlspecialchars($row['nama_roti']); ?></td>
                                                <td><?php echo number_format($row['harga']); ?></td>
                                                <td><?php echo htmlspecialchars($row['jumlah']); ?></td>
                                                <td><?php echo number_format($row['total']); ?></td>
                                                <td><?php echo htmlspecialchars($row['waktu']); ?></td>
                                                <td><?php echo htmlspecialchars($row['nomor_pemesanan']); ?></td>
                                                <td>
                                                    <?php if (!empty($row['gambar_roti'])): ?>
                                                    <img src="../../assets/img/roti/<?php echo htmlspecialchars($row['gambar_roti']); ?>"
                                                        alt="Bukti Pembayaran" width="100" class="img-thumbnail"
                                                        style="cursor: pointer;" data-bs-toggle="modal"
                                                        data-bs-target="#modalGambar<?php echo $row['id_pemesanan']; ?>" />
                                                    <?php else: ?>
                                                    <p>Bukti pembayaran belum ada</p>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <!-- Modal untuk melihat gambar bukti pembayaran -->
                                            <?php if (!empty($row['gambar_roti'])): ?>
                                            <div class="modal fade" id="modalGambar<?php echo $row['id_pemesanan']; ?>"
                                                tabindex="-1"
                                                aria-labelledby="modalLabel<?php echo $row['id_pemesanan']; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="modalLabel<?php echo $row['id_pemesanan']; ?>">
                                                                <?php echo htmlspecialchars($row['nama_roti']); ?></h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="../../assets/img/roti/<?php echo htmlspecialchars($row['gambar_roti']); ?>"
                                                                alt="Bukti Pembayaran" class="img-fluid" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                    <?php else: ?>
                                    <p class="text-center mt-4">Data tidak ditemukan 😖.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Pagination Section -->
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
                                                                            echo "?page=" . ($page - 1) . "&search=" . urlencode($search) . "&nomor_pemesanan=" . urlencode($nomor_pemesanan);
                                                                        } ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                        <li class="page-item <?php if ($i == $page) {
                                                                        echo 'active';
                                                                    } ?>">
                                            <a class="page-link"
                                                href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&nomor_pemesanan=<?php echo urlencode($nomor_pemesanan); ?>"><?php echo $i; ?></a>
                                        </li>
                                        <?php } ?>
                                        <li class="page-item <?php if ($page >= $total_pages) {
                                                                    echo 'disabled';
                                                                } ?>">
                                            <a class="page-link" href="<?php if ($page < $total_pages) {
                                                                            echo "?page=" . ($page + 1) . "&search=" . urlencode($search) . "&nomor_pemesanan=" . urlencode($nomor_pemesanan);
                                                                        } ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('tambahForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Menghentikan aksi default form submit

                var form = this;
                var formData = new FormData(form);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'proses/pemesanan/tambah.php', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = xhr.responseText.trim();
                        console.log(response); // Debugging

                        if (response === 'success') {
                            form.reset();
                            document.getElementById('closeTambahModal').click();
                            loadTable(); // reload table data

                            Swal.fire({
                                title: "Berhasil!",
                                text: "Data berhasil ditambahkan",
                                icon: "success",
                                timer: 1200, // 1,2 detik
                                showConfirmButton: false, // Tidak menampilkan tombol OK
                            });
                        } else if (response === 'pemesanan_sudah_ada') {
                            Swal.fire({
                                title: "Error",
                                text: "Data pemesanan sudah dipromosikan, silakan pilih data roti lainnya",
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

        function openEditModal(id_pemesanan, pemesanan, nomor_pemesanan) {
            let editModal = new bootstrap.Modal(document.getElementById('editModal'));
            document.getElementById('edit_id').value = id_pemesanan;
            document.getElementById('edit_pemesanan').value = pemesanan;
            document.getElementById('edit_nomor_pemesanan').value = nomor_pemesanan;
            editModal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('editForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Menghentikan aksi default form submit

                var form = this;
                var formData = new FormData(form);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'proses/pemesanan/edit.php', true);
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
                                text: "Data berhasil diperbarui",
                                icon: "success",
                                timer: 1200, // 1,2 detik
                                showConfirmButton: false, // Tidak menampilkan tombol OK
                            });
                        } else if (response === 'pemesanan_sudah_ada') {
                            Swal.fire({
                                title: "Error",
                                text: "Data pemesanan sudah dipromosikan, silakan pilih data pemesanan lainnya",
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
                                text: "Gagal memperbarui data",
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

                    xhr.open('POST', 'proses/pemesanan/hapus.php', true);
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
            xhrTable.open('GET', 'proses/pemesanan/load_data.php?page=' + currentPage + '&search=' + encodeURIComponent(
                searchQuery), true);
            xhrTable.send();
        }
        </script>

    </main>
    <!-- End #main -->

    <?php include 'fitur/bagian_akhir.php'; ?>

</body>

</html>