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
                                            placeholder="Cari checkout atau nomor rekening..." name="search"
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
            // Ambil data checkout dari database
            include '../../keamanan/koneksi.php';

            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            // Query untuk mendapatkan data checkout dengan nama mitra dan urutan terbaru
            $query = "SELECT c.*, m.nama_lengkap 
          FROM checkout c 
          LEFT JOIN mitra m ON c.id_mitra = m.id_mitra 
          WHERE status = 'belum_bayar' AND (m.nama_lengkap LIKE ? OR c.nomor_pemesanan LIKE ?) 
          ORDER BY c.id_checkout DESC 
          LIMIT ?, ?";
            $stmt = $koneksi->prepare($query);
            $search_param = '%' . $search . '%';
            $stmt->bind_param("ssii", $search_param, $search_param, $offset, $limit);
            $stmt->execute();
            $result = $stmt->get_result();

            // Hitung total halaman
            $total_query = "SELECT COUNT(*) as total 
                FROM checkout c 
                LEFT JOIN mitra m ON c.id_mitra = m.id_mitra 
                WHERE m.nama_lengkap LIKE ? OR c.nomor_pemesanan LIKE ?";
            $stmt_total = $koneksi->prepare($total_query);
            $stmt_total->bind_param("ss", $search_param, $search_param);
            $stmt_total->execute();
            $total_result = $stmt_total->get_result();
            $total_row = $total_result->fetch_assoc();
            $total_pages = ceil($total_row['total'] / $limit);
            ?>


            <!-- Tabel Data checkout -->
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
                                                <th style="white-space: nowrap;">Nama Mitra</th>
                                                <th style="white-space: nowrap;">Nomor Pemesanan</th>
                                                <th style="white-space: nowrap;">Bukti Pembayaran</th>
                                                <th style="white-space: nowrap;">Status</th>
                                                <th style="white-space: nowrap;">Detail</th>
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
                                                <td><?php echo htmlspecialchars($row['nomor_pemesanan']); ?></td>
                                                <td>
                                                    <?php if (!empty($row['bukti_pembayaran'])): ?>
                                                    <img src="../../assets/img/bukti_pembayaran/<?php echo htmlspecialchars($row['bukti_pembayaran']); ?>"
                                                        alt="Bukti Pembayaran" width="100" class="img-thumbnail"
                                                        style="cursor: pointer;" data-bs-toggle="modal"
                                                        data-bs-target="#modalGambar<?php echo $row['id_checkout']; ?>" />
                                                    <?php else: ?>
                                                    <p>Bukti pembayaran belum ada</p>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="lihatDetail('<?php echo $row['nomor_pemesanan']; ?>')">Lihat
                                                        Detail</button>
                                                </td>
                                            </tr>

                                            <!-- Modal membatalkan  -->
                                            <div class="modal fade" id="batalkan<?php echo $row['id_checkout']; ?>"
                                                tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="tambahDataModalLabel">Batalkan
                                                                Pesanan</h5>
                                                            <button type="button" class="btn-close"
                                                                id="closeBatalkanModal" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="dibatalkanForm" method="POST"
                                                                action="proses/checkout/tambah.php"
                                                                enctype="multipart/form-data">
                                                                <input type="hidden" name="id_mitra"
                                                                    value="<?php echo htmlspecialchars($row['id_mitra']); ?>">
                                                                <input type="hidden" name="nomor_pemesanan"
                                                                    value="<?php echo htmlspecialchars($row['nomor_pemesanan']); ?>">
                                                                <div class="mb-3">
                                                                    <label for="checkout" class="form-label">Alasan
                                                                        Membatalkan</label>
                                                                    <textarea class="form-control"
                                                                        placeholder="Masukan Alasan pembatalan"
                                                                        id="alasan" name="alasan" style="height: 100px"
                                                                        required></textarea>
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
                                            <div class="modal fade" id="modalGambar<?php echo $row['id_checkout']; ?>"
                                                tabindex="-1"
                                                aria-labelledby="modalLabel<?php echo $row['id_checkout']; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="modalLabel<?php echo $row['id_checkout']; ?>">Bukti
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
                window.location.href = 'belum_bayar_detail.php?nomor_pemesanan=' + nomor_pemesanan;
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
                xhr.open('POST', 'proses/chackout/dibatalkan.php', true);
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
                        } else if (response === 'checkout_sudah_ada') {
                            Swal.fire({
                                title: "Error",
                                text: "Data checkout sudah dipromosikan, silakan pilih data roti lainnya",
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