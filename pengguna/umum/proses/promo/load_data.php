 <div id="load_data">
     <section class="section">
         <div class="row align-items-start">
             <?php
                include '../../../../keamanan/koneksi.php';

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
                                                         <?php echo $formatted_harga; ?></span> <span class="text-success">(Rp
                                                         -<?php echo $formatted_potongan_harga; ?>)</span></p>
                                                 <p><strong>Rp <?php echo $formatted_harga_potongan; ?></strong></p>
                                             </div>
                                             <div class="buy" onclick="openBuyPopup('<?php echo htmlspecialchars($nama_roti); ?>', 
                      '<?php echo $formatted_harga_potongan; ?>', 
                      '<?php echo $stok; ?>', 
                      '<?php echo htmlspecialchars($gambar_roti); ?>', 
                      '<?php echo htmlspecialchars($deskripsi); ?>', 
                      '<?php echo htmlspecialchars($rasa); ?>',
                      '<?php echo htmlspecialchars($row['nomor_sejenis']); ?>',
                      '<?php echo htmlspecialchars($id_roti); ?>')">
                                                 <i class="material-icons">add_shopping_cart</i>
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