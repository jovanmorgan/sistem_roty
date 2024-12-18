  <div id="load_data">
      <section class="section">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body text-center">
                          <!-- Search Form -->
                          <form method="GET" action="">
                              <div class="input-group mt-3">
                                  <input type="text" class="form-control" placeholder="Cari galeri..." name="search"
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
                $limit = 6; // Jumlah item per halaman
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                // Searching
                $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

                // Query to count total records
                $total_result = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM galeri WHERE nama LIKE '%$search%'");
                $total_row = mysqli_fetch_assoc($total_result);
                $total_items = $total_row['total'];
                $total_pages = ceil($total_items / $limit);

                // Query to fetch limited records with search
                $result = mysqli_query($koneksi, "SELECT * FROM galeri WHERE nama LIKE '%$search%' LIMIT $limit OFFSET $offset");

                if (mysqli_num_rows($result) > 0) {
                    // Looping data galeri
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id_galeri = $row['id_galeri'];
                        $nama = $row['nama'];
                        $jenis = $row['jenis'];
                        $deskripsi = $row['deskripsi'];
                        $gambar_galeri = $row['gambar_galeri'];
                ?>
                      <div class="col-lg-4">
                          <div class="card">
                              <div class="card-body">
                                  <!-- Title -->
                                  <h5 class="card-title text-center" style="font-size: 1.7rem;"><?php echo $nama; ?></h5>

                                  <!-- Carousel -->
                                  <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                                      <div class="carousel-inner">
                                          <div class="carousel-item active">
                                              <img src="../../assets/img/galeri/<?php echo $gambar_galeri; ?>"
                                                  class="d-block w-100" alt="<?php echo $nama; ?>" />
                                          </div>
                                      </div>
                                  </div>

                                  <!-- Description -->
                                  <p class="text-center mt-3">"<?php echo $deskripsi; ?>"</p>

                                  <!-- Action Buttons -->
                                  <div class="d-flex justify-content-between mt-3">
                                      <button onclick="hapus('<?php echo $id_galeri; ?>');"
                                          class="btn btn-danger">Delete</button>
                                      <button
                                          onclick="openEditModal('<?php echo $id_galeri; ?>', '<?php echo addslashes($nama); ?>', '<?php echo $jenis; ?>', '<?php echo addslashes($deskripsi); ?>', '<?php echo addslashes($gambar_galeri); ?>');"
                                          class="btn btn-primary">Edit</button>
                                  </div>
                              </div>
                          </div>
                      </div>
              <?php
                    }
                } else {
                    echo "<div class='col-12'><p class='text-center'>Tidak ada data galeri 😖.</p></div>";
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