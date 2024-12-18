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
                    include '../../../../keamanan/koneksi.php';

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
     </div>div