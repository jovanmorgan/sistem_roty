    <!-- ======= Header ======= -->
    <header id=" header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="dashboard.html" class="logo d-flex align-items-center">
                <img src="../../assets/img/logo_fasya2.jpeg" alt="" />
                <span class="d-none d-lg-block" style="margin-left: 10px;">pimpinan</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <!-- End Logo -->

        <!-- HTML dan form pencarian tetap sama -->
        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="fitur/search.php">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword" />
                <button type="submit" title="Search">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle" href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li>
                <!-- End Search Icon-->

                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <?php
                        // Lakukan koneksi ke database
                        include '../../keamanan/koneksi.php';

                        // Periksa apakah session id_pimpinan telah diset
                        if (isset($_SESSION['id_pimpinan'])) {
                            $id_pimpinan = $_SESSION['id_pimpinan'];

                            // Query SQL untuk mengambil data pimpinan berdasarkan id_pimpinan dari session
                            $query = "SELECT * FROM pimpinan WHERE id_pimpinan = '$id_pimpinan'";
                            $result = mysqli_query($koneksi, $query);

                            // Periksa apakah query berhasil dieksekusi
                            if ($result) {
                                // Periksa apakah terdapat data pimpinan
                                if (mysqli_num_rows($result) > 0) {
                                    // Ambil data pimpinan sebagai array asosiatif
                                    $pimpinan = mysqli_fetch_assoc($result);
                        ?>
                                    <?php if (!empty($pimpinan['fp'])): ?>
                                        <img src="../../assets/img/fp_pengguna/pimpinan/<?php echo $pimpinan['fp']; ?>" alt="Profile"
                                            class="rounded-circle" />
                                        <span
                                            class="d-none d-md-block dropdown-toggle ps-2"><?php echo $pimpinan['nama_lengkap']; ?></span>
                    </a>
                <?php else: ?>
                    <img src="../../assets/img/user.png" alt="Profile" class="rounded-circle" />
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $pimpinan['nama_lengkap']; ?></span>
                <?php endif; ?>


                <!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?php echo $pimpinan['nama_lengkap']; ?></h6>
                        <span><?php echo $pimpinan['nomor_pengguna']; ?></span>
                    </li>
        <?php
                                } else {
                                    // Jika tidak ada data pimpinan
                                    echo "Tidak ada data pimpinan.";
                                }
                            } else {
                                // Jika query tidak berhasil dieksekusi
                                echo "Gagal mengambil data pimpinan: " . mysqli_error($koneksi);
                            }
                        } else {
                            // Jika session id_pimpinan tidak diset
                            echo "Session id_pimpinan tidak tersedia.";
                        }

                        // Tutup koneksi ke database
                        mysqli_close($koneksi);
        ?>
        <li>
            <hr class="dropdown-divider" />
        </li>

        <li>
            <a class="dropdown-item d-flex align-items-center" href="profile">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
            </a>
        </li>
        <li>
            <hr class="dropdown-divider" />
        </li>

        <li>
            <a class="dropdown-item d-flex align-items-center" href="log_out">
                <i class="bi bi-box-arrow-right"></i>
                <span>Log Out</span>
            </a>
        </li>
                </ul>
                <!-- End Profile Dropdown Items -->
                </li>
                <!-- End Profile Nav -->
            </ul>
        </nav>
        <!-- End Icons Navigation -->
    </header>
    <!-- End Header -->