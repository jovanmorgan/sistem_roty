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
                                            placeholder="Cari bank atau nomor rekening..." name="search"
                                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php
            // Ambil data bank dari database
            include '../../keamanan/koneksi.php';

            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            // Query untuk mendapatkan data bank dengan pencarian dan pagination
            $query = "SELECT * FROM bank WHERE bank LIKE ? OR nomor_rekening LIKE ? LIMIT ?, ?";
            $stmt = $koneksi->prepare($query);
            $search_param = '%' . $search . '%';
            $stmt->bind_param("ssii", $search_param, $search_param, $offset, $limit);
            $stmt->execute();
            $result = $stmt->get_result();

            // Hitung total halaman
            $total_query = "SELECT COUNT(*) as total FROM bank WHERE bank LIKE ? OR nomor_rekening LIKE ?";
            $stmt_total = $koneksi->prepare($total_query);
            $stmt_total->bind_param("ss", $search_param, $search_param);
            $stmt_total->execute();
            $total_result = $stmt_total->get_result();
            $total_row = $total_result->fetch_assoc();
            $total_pages = ceil($total_row['total'] / $limit);
            ?>

            <!-- Tabel Data Bank -->
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
                                        <!-- Atur lebar minimum tabel -->
                                        <thead>
                                            <tr>
                                                <th style="white-space: nowrap;">Nomor</th> <!-- Kolom nomor urut -->
                                                <th style="white-space: nowrap;">ID Bank</th>
                                                <th style="white-space: nowrap;">Bank</th>
                                                <th style="white-space: nowrap;">Nomor Rekening</th>
                                                <th style="white-space: nowrap;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $nomor = $offset + 1; // Mulai nomor urut dari $offset + 1
                                                while ($row = $result->fetch_assoc()) :
                                                ?>
                                            <tr>
                                                <td><?php echo $nomor++; ?></td> <!-- Menampilkan nomor urut -->
                                                <td><?php echo htmlspecialchars($row['id_bank']); ?></td>
                                                <td><?php echo htmlspecialchars($row['bank']); ?></td>
                                                <td><?php echo htmlspecialchars($row['nomor_rekening']); ?></td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm"
                                                        onclick="openEditModal('<?php echo $row['id_bank']; ?>','<?php echo $row['bank']; ?>','<?php echo $row['nomor_rekening']; ?>')">Edit</button>
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="hapus('<?php echo $row['id_bank']; ?>')">Hapus</button>
                                                </td>
                                            </tr>
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
                        <form id="tambahForm" method="POST" action="proses/bank/tambah.php"
                            enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="bank" class="form-label">Bank</label>
                                <input type="text" id="bank" name="bank" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="nomor_rekening" class="form-label">Nomor Rekening</label>
                                <input type="number" id="nomor_rekening" name="nomor_rekening" class="form-control"
                                    min="0" required>
                            </div>

                            <!-- Wrapper for the submit button to align it to the right -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel">Edit Promo</h5>
                        <button type="button" class="btn-close" id="closeEditModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST" action="proses/bank/edit.php" enctype="multipart/form-data">
                            <input type="hidden" id="edit_id" name="id">

                            <div class="mb-3">
                                <label for="edit_bank" class="form-label">Bank</label>
                                <input type="text" id="edit_bank" name="bank" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_nomor_rekening" class="form-label">Nomor Rekening</label>
                                <input type="number" id="edit_nomor_rekening" name="nomor_rekening" class="form-control"
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
            document.getElementById('tambahForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Menghentikan aksi default form submit

                var form = this;
                var formData = new FormData(form);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'proses/bank/tambah.php', true);
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
                        } else if (response === 'bank_sudah_ada') {
                            Swal.fire({
                                title: "Error",
                                text: "Data Bank sudah dipromosikan, silakan pilih data roti lainnya",
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

        function openEditModal(id_bank, bank, nomor_rekening) {
            let editModal = new bootstrap.Modal(document.getElementById('editModal'));
            document.getElementById('edit_id').value = id_bank;
            document.getElementById('edit_bank').value = bank;
            document.getElementById('edit_nomor_rekening').value = nomor_rekening;
            editModal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('editForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Menghentikan aksi default form submit

                var form = this;
                var formData = new FormData(form);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'proses/bank/edit.php', true);
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
                        } else if (response === 'bank_sudah_ada') {
                            Swal.fire({
                                title: "Error",
                                text: "Data Bank sudah dipromosikan, silakan pilih data bank lainnya",
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

                    xhr.open('POST', 'proses/bank/hapus.php', true);
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
            xhrTable.open('GET', 'proses/bank/load_data.php?page=' + currentPage + '&search=' + encodeURIComponent(
                searchQuery), true);
            xhrTable.send();
        }
        </script>

    </main>
    <!-- End #main -->

    <?php include 'fitur/bagian_akhir.php'; ?>

</body>

</html>