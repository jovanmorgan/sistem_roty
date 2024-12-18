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
                                            placeholder="Cari dikemas atau nomor rekening..." name="search"
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
            // Ambil data dikemas dari database
            include '../../keamanan/koneksi.php';

            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            // Query untuk mendapatkan data dikemas dengan nama mitra dan urutan terbaru
            $query = "SELECT c.*, m.nama_lengkap, m.nomor_hp, m.alamat, m.fp
          FROM dikemas c 
          LEFT JOIN mitra m ON c.id_mitra = m.id_mitra 
          WHERE status = 'belum_dikemas' AND (m.nama_lengkap LIKE ? OR c.nomor_pemesanan LIKE ?) 
          ORDER BY c.id_dikemas DESC 
          LIMIT ?, ?";
            $stmt = $koneksi->prepare($query);
            $search_param = '%' . $search . '%';
            $stmt->bind_param("ssii", $search_param, $search_param, $offset, $limit);
            $stmt->execute();
            $result = $stmt->get_result();

            // Hitung total halaman
            $total_query = "SELECT COUNT(*) as total 
                FROM dikemas c 
                LEFT JOIN mitra m ON c.id_mitra = m.id_mitra 
                WHERE m.nama_lengkap LIKE ? OR c.nomor_pemesanan LIKE ?";
            $stmt_total = $koneksi->prepare($total_query);
            $stmt_total->bind_param("ss", $search_param, $search_param);
            $stmt_total->execute();
            $total_result = $stmt_total->get_result();
            $total_row = $total_result->fetch_assoc();
            $total_pages = ceil($total_row['total'] / $limit);
            ?>


            <!-- Tabel Data dikemas -->
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body" style="overflow-x: hidden;">
                                <div style="overflow-x: auto;">
                                    <?php if ($result->num_rows > 0): ?>
                                        <table class="table table-hover text-center mt-3"
                                            style="border-collapse: separate; border-spacing: 0;">
                                            <thead>
                                                <tr>
                                                    <th style="white-space: nowrap;">Nomor</th>
                                                    <th style="white-space: nowrap;">Detail Mitra</th>
                                                    <th style="white-space: nowrap;">Nomor Pemesanan</th>
                                                    <th style="white-space: nowrap;">Status</th>
                                                    <th style="white-space: nowrap;">Detail Pesanan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $nomor = $offset + 1;
                                                while ($row = $result->fetch_assoc()) :
                                                ?>
                                                    <tr>
                                                        <td><?php echo $nomor++; ?></td>
                                                        <td><button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                                data-bs-target="#detail_mitra<?php echo htmlspecialchars($row['id_mitra']); ?>">
                                                                <?php echo htmlspecialchars($row['nama_lengkap']); ?></button>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($row['nomor_pemesanan']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                                                        <td>
                                                            <button class="btn btn-primary btn-sm"
                                                                onclick="lihatDetail('<?php echo $row['nomor_pemesanan']; ?>')">
                                                                Detail Pesanan</button>
                                                        </td>
                                                    </tr>


                                                    <!-- Modal memdetail_mitra  -->
                                                    <div class="modal fade" id="detail_mitra<?php echo $row['id_mitra']; ?>"
                                                        tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="tambahDataModalLabel">Data Mitra
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        id="closedetail_mitraModal" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="" method="POST" enctype="multipart/form-data">
                                                                        <div class="mb-3">
                                                                            <label for="mitra" class="form-label">Nama
                                                                                Mitra</label>
                                                                            <input class="form-control" type="text"
                                                                                value="<?php echo htmlspecialchars($row['nama_lengkap']); ?>"
                                                                                disabled>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="mitra" class="form-label">Nama
                                                                                Mitra</label>
                                                                            <input class="form-control" type="text"
                                                                                value="<?php echo htmlspecialchars($row['nomor_hp']); ?>"
                                                                                disabled>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="checkout"
                                                                                class="form-label">Alamat</label>
                                                                            <textarea class="form-control"
                                                                                placeholder="Alamat Mitra"
                                                                                value="<?php echo htmlspecialchars($row['alamat']); ?>"
                                                                                style="height: 100px" disabled></textarea>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal membatalkan  -->
                                                    <div class="modal fade" id="batalkan<?php echo $row['id_dikemas']; ?>"
                                                        tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="tambahDataModalLabel">Batas
                                                                        Pengiriman Pemesanan</h5>
                                                                    <button type="button" class="btn-close"
                                                                        id="closeBatalkanModal" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="dibatalkanForm" method="POST"
                                                                        action="proses/dikemas/dikirim.php"
                                                                        enctype="multipart/form-data">
                                                                        <input type="hidden" name="id_mitra"
                                                                            value="<?php echo htmlspecialchars($row['id_mitra']); ?>">
                                                                        <input type="hidden" name="nomor_pemesanan"
                                                                            value="<?php echo htmlspecialchars($row['nomor_pemesanan']); ?>">
                                                                        <div class="mb-3">
                                                                            <label for="dikemas" class="form-label">Sales Yang
                                                                                Mengantar</label>

                                                                            <select name="id_sales" id="id_sales"
                                                                                class="form-select">
                                                                                <option value="" selected> Silakan Pilih Sales
                                                                                    yang
                                                                                    mengantar</option>
                                                                                <?php
                                                                                include '../../keamanan/koneksi.php';
                                                                                $query_sales = "SELECT * FROM sales";
                                                                                $result_sales = mysqli_query($koneksi, $query_sales);

                                                                                if (!$result_sales) {
                                                                                    die("Query error: " . mysqli_error($koneksi));
                                                                                }
                                                                                if (mysqli_num_rows($result_sales) > 0) {
                                                                                    while ($row_sales = mysqli_fetch_assoc($result_sales)) {
                                                                                        echo "<option class='form-select' value='" . htmlspecialchars($row_sales['id_sales']) . "'>" . htmlspecialchars($row_sales['nama_lengkap']) . " (" . htmlspecialchars($row_sales['nomor_hp']) . ")</option>";
                                                                                    }
                                                                                } else {
                                                                                    echo "<option class='form-select' disabled>Tidak ada data sales yang tersedia</option>";
                                                                                }

                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="dikemas" class="form-label">Batas Waktu
                                                                                Pengantaran</label>
                                                                            <input class="form-control" type="number" min="1"
                                                                                name="waktu" id="waktu" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="dikemas" class="form-label">Batas Waktu
                                                                                Pengantaran</label>
                                                                            <select class="form-select" name="type_waktu" id=""
                                                                                required>
                                                                                <option value="" selected>Silakan Pilih Type
                                                                                    waktu
                                                                                </option>
                                                                                <option value="Detik">Detik</option>
                                                                                <option value="Menit">Menit</option>
                                                                                <option value="Jam">Jam</option>
                                                                            </select>
                                                                        </div>

                                                                        <!-- Wrapper for the submit button to align it to the right -->
                                                                        <div class="text-end">
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Simpan</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal untuk melihat gambar bukti pembayaran -->
                                                    <?php if (!empty($row['bukti_pembayaran'])): ?>
                                                        <div class="modal fade" id="modalGambar<?php echo $row['id_dikemas']; ?>"
                                                            tabindex="-1"
                                                            aria-labelledby="modalLabel<?php echo $row['id_dikemas']; ?>"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="modalLabel<?php echo $row['id_dikemas']; ?>">Bukti
                                                                            Pembayaran</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <img src="../../assets/img/bukti_pembayaran/<?php echo htmlspecialchars($row['bukti_pembayaran']); ?>"
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

            <script>
                // Fungsi untuk membuka halaman detail bukti pembayaran
                function lihatDetail(nomor_pemesanan) {
                    window.location.href = 'dikemas_detail.php?nomor_pemesanan=' + nomor_pemesanan;
                }
            </script>

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



        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('dibatalkanForm').addEventListener('submit', function(event) {
                    event.preventDefault(); // Menghentikan aksi default form submit

                    var form = this;
                    var formData = new FormData(form);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'proses/dikemas/dikirim.php', true);
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            var response = xhr.responseText.trim();
                            console.log(response); // Debugging

                            if (response === 'success') {
                                form.reset();
                                document.getElementById('closeBatalkanModal').click();

                                Swal.fire({
                                    title: "Berhasil!",
                                    text: "Data berhasil ditambahkan",
                                    icon: "success",
                                    timer: 1200, // 1,2 detik
                                    showConfirmButton: false, // Tidak menampilkan tombol OK
                                }).then(() => {
                                    location.reload();
                                })
                            } else if (response === 'dikemas_sudah_ada') {
                                Swal.fire({
                                    title: "Error",
                                    text: "Data dikemas sudah dipromosikan, silakan pilih data roti lainnya",
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
                xhrTable.open('GET', 'proses/chackout/load_data.php?page=' + currentPage + '&search=' + encodeURIComponent(
                    searchQuery), true);
                xhrTable.send();
            }
        </script>

    </main>
    <!-- End #main -->

    <?php include 'fitur/bagian_akhir.php'; ?>

</body>

</html>