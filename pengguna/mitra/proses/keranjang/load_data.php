  <div class="load_data">
      <?php
        include '../../../../keamanan/koneksi.php';

        // ID mitra yang sedang login, pastikan sudah mendapatkan ID mitra dari sesi atau cookie
        $id_mitra = $_SESSION['id_mitra'];  // Misalnya, ID mitra disimpan di sesi

        // Query untuk mengambil data dari tabel keranjang dan roti
        $query = "
    SELECT keranjang.*, roti.nama_roti, roti.harga, roti.gambar_roti, roti.rasa
    FROM keranjang
    JOIN roti ON keranjang.id_roti = roti.id_roti
    WHERE keranjang.id_mitra = '$id_mitra'
";

        $result = mysqli_query($koneksi, $query);

        // Periksa jika query berhasil dijalankan
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Menampilkan data di dalam HTML
                echo '  <div class="shopping-cart">
        <!-- Title -->
        <div class="title">' . htmlspecialchars($row['nama_roti']) . '</div>

        <form id="form_keranjang" method="post">
            <input type="hidden" name="id_keranjang" id="id_keranjang"
                value="' . htmlspecialchars($row['id_keranjang']) . '">
            <input type="hidden" name="harga" id="harga"
                value="' . htmlspecialchars($row['harga']) . '">
            <input type="hidden" name="jumlah" id="jumlah"
                value="' . htmlspecialchars($row['jumlah']) . '">
            <!-- Product #1 -->
            <div class="item">
                <div class="buttons">
                    <input type="checkbox" />
                </div>

                <div class="image">
                    <img src="../../assets/img/roti/' . htmlspecialchars($row['gambar_roti']) . '" alt="" width="100px"
                        height="100px" style="object-fit: cover; position: relative; bottom: 10px;" />
                </div>

                <div class="description">
                    <span>' . htmlspecialchars($row['rasa']) . '</span>
                    <span>Rp' . number_format($row['harga'], 0, ',', '.') . '</span>
                </div>

                <div id="formJumlah1" class="quantity">
                    <button class="plus-btn" type="button" name="button" id="tambah1">
                        <img src="img/card_keranjang/plus.svg" alt="" />
                    </button>
                    <input type="text" name="jumlah1" value="' . htmlspecialchars($row['jumlah']) . '" disabled />
                    <button class="minus-btn" type="button" name="button" id="kurang1">
                        <img src="img/card_keranjang/minus.svg" alt="" />
                    </button>
                </div>
                <!-- total -->
                <div class="total-price">Rp' . number_format($row['total'], 0, ',', '.') . '</div>
            </div>
            <div class="item2">
                <div class="quantity">
                    <button class="plus-btn" type="button" name="button" id="tambah2">
                        <img src="img/card_keranjang/plus.svg" alt="" />
                    </button>
                    <!-- jumlah -->
                    <input type="text" name="jumlah2" value="' . htmlspecialchars($row['jumlah']) . '" disabled />
                    <button class="minus-btn" type="button" name="button" id="kurang2">
                        <img src="img/card_keranjang/minus.svg" alt="" />
                    </button>
                </div>

                <!-- total -->
                <div class="total-price">Rp' . number_format($row['total'], 0, ',', '.') . '</div>
            </div>
        </form>
    </div> ';
            }
        } else {
            echo 'Terjadi kesalahan saat mengambil data keranjang.';
        }

        // Tutup koneksi
        mysqli_close($koneksi);
        ?>



      <div class="shopping-cart2">
          <!-- Product #1 -->
          <div class="item">
              <div class="nav__menu" id="nav-menu">
                  <ul class="nav__list">
                      <div class="buttons" style="position: relative; bottom: 25px">
                          <input type="checkbox" />
                      </div>
                      <li class="nav__item">
                          <h4 class="total" style="position: relative; top: -2px">
                              Total : <span>Rp100.000.000.000</span>
                          </h4>
                      </li>
                      <li class="nav__item" style="position: relative; left: 200px; top: 5px">
                          <a href="#" class="btn" style="margin: 0px">Checkout</a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <!-- jarak -->
      <div class="jarak" style="height: 80px"></div>
  </div>