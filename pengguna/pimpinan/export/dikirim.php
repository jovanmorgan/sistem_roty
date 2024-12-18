<?php include '../fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link href="../../../assets/img/loding_donat.png" rel="icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../../../images/logo_dinas.png">
    <title>Export Data Dikirim</title>
    <link rel="icon" type="image/png" href="../../../../assets/img/gml.png">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
    <style>
        .table-responsive::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }

        .button-like {
            display: inline-block;
            padding: 5px 10px;
            background-color: #4e73df;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>

<body translate="no">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h3 class="text-center">Data Dikirim</h3>
                    </div><?php
                            // Ambil data checkout dari database
                            include '../../../keamanan/koneksi.php';
                            $search = isset($_GET['search']) ? $_GET['search'] : '';
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $limit = 10;
                            $offset = ($page - 1) * $limit;

                            // Query untuk mendapatkan data dikirim dengan nama mitra dan urutan terbaru
                            $query = "SELECT c.*, m.nama_lengkap, m.nomor_hp, m.alamat, m.fp, s.id_sales, s.nama_lengkap AS nama_lengkap_sales, s.nomor_hp AS nomor_hp_sales
          FROM dikirim c 
          LEFT JOIN mitra m ON c.id_mitra = m.id_mitra 
          LEFT JOIN sales s ON c.id_sales = s.id_sales
          WHERE status = 'belum_diterima' AND (m.nama_lengkap LIKE ? OR c.nomor_pemesanan LIKE ?) 
          ORDER BY c.id_dikirim DESC 
          LIMIT ?, ?";
                            $stmt = $koneksi->prepare($query);
                            $search_param = '%' . $search . '%';
                            $stmt->bind_param("ssii", $search_param, $search_param, $offset, $limit);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Hitung total halaman
                            $total_query = "SELECT COUNT(*) as total 
                FROM dikirim c 
                LEFT JOIN mitra m ON c.id_mitra = m.id_mitra 
                WHERE m.nama_lengkap LIKE ? OR c.nomor_pemesanan LIKE ?";
                            $stmt_total = $koneksi->prepare($total_query);
                            $stmt_total->bind_param("ss", $search_param, $search_param);
                            $stmt_total->execute();
                            $total_result = $stmt_total->get_result();
                            $total_row = $total_result->fetch_assoc();
                            $total_pages = ceil($total_row['total'] / $limit);
                            ?>

                    <div class="card-body">
                        <div class="table-responsive">

                            <?php if ($result->num_rows > 0): ?>
                                <table id="example" class="table table-hover text-center mt-3"
                                    style="border-collapse: separate; border-spacing: 0;">
                                    <thead>
                                        <tr>
                                            <th style="white-space: nowrap;">Nomor</th>
                                            <th style="white-space: nowrap;">Pemerima Pesanan</th>
                                            <th style="white-space: nowrap;">Pengirim Pesanan</th>
                                            <th style="white-space: nowrap;">Nomor Pemesanan</th>
                                            <th style="white-space: nowrap;">Waktu konfirmasi</th>
                                            <th style="white-space: nowrap;">Batas Waktu Pengiriman</th>
                                            <th style="white-space: nowrap;">Status</th>
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
                                                <td><button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#detail_sales<?php echo $row['id_sales']; ?>">
                                                        <?php echo htmlspecialchars($row['nama_lengkap_sales']); ?></button>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['nomor_pemesanan']); ?></td>
                                                <td><?php echo htmlspecialchars($row['waktu']); ?></td>
                                                <td><button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#atur_waktu_pengiriman<?php echo $row['id_dikirim']; ?>">
                                                        <?php echo htmlspecialchars($row['waktu_batas_pengiriman']); ?></button>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                            </tr>

                                            <!-- Modal mematurUlangWaktu  -->
                                            <div class="modal fade" id="atur_waktu_pengiriman<?php echo $row['id_dikirim']; ?>"
                                                tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="tambahDataModalLabel"> Atur
                                                                Ulang Batas
                                                                Pengiriman Pemesanan</h5>
                                                            <button type="button" class="btn-close"
                                                                id="closeaturUlangWaktuModal" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="diaturUlangWaktuForm" method="POST"
                                                                action="proses/dikirim/atur_ulang_waktu.php"
                                                                enctype="multipart/form-data">
                                                                <input type="hidden" name="id_dikirim"
                                                                    value="<?php echo htmlspecialchars($row['id_dikirim']); ?>">
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

                                            <!-- Modal memdetail_sales  -->
                                            <div class="modal fade" id="detail_sales<?php echo $row['id_sales']; ?>"
                                                tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="tambahDataModalLabel">Batas
                                                                Pengiriman Pemesanan</h5>
                                                            <button type="button" class="btn-close" id="closedetail_salesModal"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="" method="POST" enctype="multipart/form-data">
                                                                <div class="mb-3">
                                                                    <label for="sales" class="form-label">Nama
                                                                        sales</label>
                                                                    <input class="form-control" type="text"
                                                                        value="<?php echo htmlspecialchars($row['nama_lengkap_sales']); ?>"
                                                                        disabled>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="sales" class="form-label">Nama
                                                                        sales</label>
                                                                    <input class="form-control" type="text"
                                                                        value="<?php echo htmlspecialchars($row['nomor_hp_sales']); ?>"
                                                                        disabled>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal memdetail_mitra  -->
                                            <div class="modal fade" id="detail_mitra<?php echo $row['id_mitra']; ?>"
                                                tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="tambahDataModalLabel">Batas
                                                                Pengiriman Pemesanan</h5>
                                                            <button type="button" class="btn-close" id="closedetail_mitraModal"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                                    <label for="checkout" class="form-label">Alamat</label>
                                                                    <textarea class="form-control" placeholder="Alamat Mitra"
                                                                        value="<?php echo htmlspecialchars($row['alamat']); ?>"
                                                                        style="height: 100px" disabled></textarea>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal bukti_pengiriman -->
                                            <div class="modal fade" id="bukti_pengiriman<?php echo $row['id_dikirim']; ?>"
                                                tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="tambahDataModalLabel">Upload Dan
                                                                Konfirmasi Pengiriman</h5>
                                                            <button type="button" class="btn-close"
                                                                id="closebukti_pengirimanModal" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="dibukti_pengirimanForm" method="POST"
                                                                action="proses/dikirim/bukti_pengiriman.php"
                                                                enctype="multipart/form-data">
                                                                <input type="hidden" name="id_mitra"
                                                                    value="<?php echo htmlspecialchars($row['id_mitra']); ?>">
                                                                <input type="hidden" name="nomor_pemesanan"
                                                                    value="<?php echo htmlspecialchars($row['nomor_pemesanan']); ?>">
                                                                <div class="mb-3">
                                                                    <label for="dikirim" class="form-label">Upload Bukti
                                                                        Pengiriman</label>
                                                                    <input class="form-control" type="file"
                                                                        name="bukti_pengiriman" id="bukti_pengiriman"
                                                                        accept="image/*" required>
                                                                </div>

                                                                <!-- Preview image -->
                                                                <div class="mb-3">
                                                                    <img id="previewImage" src="#" alt="Pratinjau Gambar"
                                                                        style="display:none; width:100%; object-fit:contain;" />
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

                                            <script>
                                                document.getElementById('bukti_pengiriman').addEventListener('change',
                                                    function(event) {
                                                        const file = event.target.files[0];
                                                        if (file) {
                                                            const reader = new FileReader();
                                                            reader.onload = function(e) {
                                                                const previewImage = document.getElementById(
                                                                    'previewImage');
                                                                previewImage.src = e.target.result;
                                                                previewImage.style.display = 'block';
                                                            }
                                                            reader.readAsDataURL(file);
                                                        } else {
                                                            const previewImage = document.getElementById(
                                                                'previewImage');
                                                            previewImage.style.display = 'none';
                                                        }
                                                    });
                                            </script>

                                        <?php endwhile; ?>
                                    </tbody>
                                </table>

                            <?php else: ?>
                                <p class="text-center mt-4">Data tidak ditemukan 😖.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Pagination -->
                </div>
            </div>
        </div>
    </div>

    <!-- Tautan ke file jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Tautan ke file JavaScript DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
    <!-- Tautan ke file JavaScript untuk ekspor -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'pdfHtml5',
                        text: 'PDF A3',
                        customize: function(doc) {
                            doc.pageSize = 'A3';
                            doc.content[1].table.headerRows = 1;
                            doc.content[1].table.body[0].forEach(function(col) {
                                col.fillColor = '#cccccc';
                            });
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF A4',
                        customize: function(doc) {
                            doc.pageSize = 'A4';
                            doc.content[1].table.headerRows = 1;
                            doc.content[1].table.body[0].forEach(function(col) {
                                col.fillColor = '#cccccc';
                            });
                        }
                    },
                    'copy', 'csv', 'excel', 'print'
                ]
            });
        });
    </script>
</body>

</html>