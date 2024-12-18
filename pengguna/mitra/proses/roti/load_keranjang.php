 <?php
    include '../../../../keamanan/koneksi.php'; // Pastikan path ke koneksi benar

    // Fungsi untuk menghitung jumlah data belum dibaca
    function getCount($table)
    {
        global $koneksi;
        $query = "SELECT COUNT(*) AS jumlah FROM $table WHERE dilihat = ''";
        $result = mysqli_query($koneksi, $query);

        // Cek apakah query berhasil
        if (!$result) {
            die("Query Error: " . mysqli_error($koneksi));
        }

        $row = mysqli_fetch_assoc($result);
        return $row['jumlah'];
    }

    // Menghitung jumlah data dari masing-masing tabel
    $keranjang_count = getCount('keranjang');

    // Menutup koneksi
    mysqli_close($koneksi);
    ?>

 <style>
     .nav__kiri {
         position: relative;
     }

     .keranjang {
         position: relative;
         display: inline-block;
     }

     .badge {
         position: absolute;
         top: -2px;
         left: 15px;
         background-color: red;
         color: white;
         border-radius: 50%;
         font-size: 10px;
         padding: 4px 5px;
         min-width: 18px;
         text-align: center;
     }

     /* Optional: Adjust size and position for smaller screens */
     @media (max-width: 768px) {
         .badge {
             font-size: 8px;
             min-width: 15px;
             top: -1px;
             left: 16px;
         }
     }
 </style>

 <div class="nav__kiri" id="load_keranjang">
     <a href="#" class="nav__search-icon">
         <i class="bx bx-search"></i>
     </a>
     <a href="keranjang" class="keranjang" onclick="keranjang_btn()">
         <i class="bx bx-cart"></i>
         <?php if ($keranjang_count > 0): ?>
             <span class="badge b6"><?php echo $keranjang_count; ?></span>
         <?php endif; ?>
     </a>
     <a href="akun" class="ml-3">
         <!-- Icon akun dari Font Awesome -->
         <i class="fa fa-user"></i>
     </a>
 </div>