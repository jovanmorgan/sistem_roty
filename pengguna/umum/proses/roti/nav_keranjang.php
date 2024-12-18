<?php
include '../../keamanan/koneksi.php'; // Pastikan path ke koneksi benar

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
    <a href="../../../../fasya_bakery/berlangganan/login_public" class="keranjang">
        <i class="bx bx-cart"></i>
        <?php if ($keranjang_count > 0): ?>
        <span class="badge b6"></span>
        <?php endif; ?>
    </a>
    <a href="../../../../fasya_bakery/berlangganan/login_public" class="btn-login ml-3">
        <!-- Icon login dari Boxicons -->
        Login
    </a>
</div>


<style>
/* Style untuk tombol login */
.btn-login {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    background-color: hsl(30, 100%, 50%);
    color: #fff;
    border: none;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    transition: background-color 0.3s, transform 0.3s;
    margin-bottom: 5px;
}

.btn-login i {
    margin-right: 8px;
    color: #fff;
}

.btn-login:hover {
    background-color: hsl(30, 100%, 60%);
    transform: scale(1.05);
    color: #fff;
}

.btn-login:active {
    background-color: hsl(30, 100%, 40%);
    transform: scale(0.95);
    color: #fff;
}
</style>


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
    function sendUpdateRequest(status, callback) {
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

        xhr.send("status=" + encodeURIComponent(status));
    }

    // Menambahkan event listener ke masing-masing tombol
    document
        .getElementById("keranjang_btn")
        .addEventListener("click", function(event) {
            event.preventDefault(); // Mencegah tindakan default tautan
            sendUpdateRequest("keranjang");
        });

});
</script>