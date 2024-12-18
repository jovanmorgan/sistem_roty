<?php

include '../../keamanan/koneksi.php'; // Pastikan path ke koneksi benar

// Fungsi untuk menghitung jumlah data belum dibaca
// Fungsi untuk menghitung jumlah data belum dibaca berdasarkan id_mitra
function getCount($table, $id_mitra)
{
    global $koneksi;
    $query = "SELECT COUNT(*) AS jumlah FROM $table WHERE dilihat = '' AND id_mitra = '$id_mitra'";
    $result = mysqli_query($koneksi, $query);

    // Cek apakah query berhasil
    if (!$result) {
        die("Query Error: " . mysqli_error($koneksi));
    }

    $row = mysqli_fetch_assoc($result);
    return $row['jumlah'];
}

// Menghitung jumlah data dari masing-masing tabel untuk id_mitra tertentu
$keranjang_count = getCount('keranjang', $id_mitra);

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
    <a href="keranjang" class="keranjang" id="keranjang_btn">
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

<script>
    function updateBadgePadding() {
        const badges = document.querySelectorAll(".badge");
        badges.forEach((badge) => {
            const textLength = badge.textContent.length;
            if (textLength === 1) {
                badge.style.padding = "4px 5px";
            } else if (textLength === 2) {
                badge.style.padding = "4px 3.5px";
            } else if (textLength === 3) {
                badge.style.padding = "5px 1px";
            }
        });
    }

    // Call the function to set the initial padding
    updateBadgePadding();

    document.addEventListener("DOMContentLoaded", function() {
        // Fungsi untuk mengirim permintaan AJAX
        function sendUpdateRequest(status, id_mitra, callback) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "proses/icon/update_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === "success") {
                        // Redirect ke halaman yang sesuai setelah pembaruan
                        window.location.href = status;
                    } else {
                        console.error("Error: " + response.message);
                    }
                }
            };

            xhr.send("status=" + encodeURIComponent(status) + "&id_mitra=" + encodeURIComponent(id_mitra));
        }

        // Menambahkan event listener ke masing-masing tombol
        document
            .getElementById("keranjang_btn")
            .addEventListener("click", function(event) {
                event.preventDefault(); // Mencegah tindakan default tautan
                const id_mitra = "<?php echo $id_mitra; ?>"; // Mengambil id_mitra dari session
                sendUpdateRequest("keranjang", id_mitra);
            });

    });
</script>