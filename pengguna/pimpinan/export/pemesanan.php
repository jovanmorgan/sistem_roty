<?php include '../fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link href="../../../assets/img/loding_donat.png" rel="icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../../../images/logo_dinas.png">
    <title>Export Data Pemesanan</title>
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
                        <h3 class="text-center">Data Pemesanan</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered display nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nomor Pemesanan</th>
                                        <th class="text-center">Nama Lengkap</th>
                                        <th class="text-center">Nama Roti</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Tanggal Pemesanan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include '../../../keamanan/koneksi.php';

                                    $nomor_pemesanan = isset($_GET['nomor_pemesanan']) ? $_GET['nomor_pemesanan'] : '';

                                    if (empty($nomor_pemesanan)) {
                                        echo "<p class='text-center mt-4'>Nomor pemesanan tidak ditemukan 😖.</p>";
                                        exit;
                                    }

                                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                    $limit = 10;
                                    $offset = ($page - 1) * $limit;

                                    $query = "SELECT p.*, m.nama_lengkap, r.nama_roti, p.jumlah, r.harga, (p.jumlah * r.harga) as total, p.waktu 
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

                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td class='text-center'>" . htmlspecialchars($row['nomor_pemesanan']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($row['nama_lengkap']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($row['nama_roti']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($row['jumlah']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($row['harga']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($row['total']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($row['waktu']) . "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
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