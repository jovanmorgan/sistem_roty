<?php
// Pastikan Anda menghubungkan ke database
include '../../../../keamanan/koneksi.php';

// Ambil data dari formulir
$id_promo = $_POST['id_promo']; // ID promo yang akan diedit
$id_roti = $_POST['id_roti']; // ID roti yang dipilih
$potongan_harga_baru = $_POST['potongan_harga']; // Potongan harga baru

// Cek apakah ID promo, ID roti, dan potongan harga tersedia
if (empty($id_promo) || empty($id_roti) || empty($potongan_harga_baru)) {
    echo "data_tidak_lengkap";
    exit();
}

// Cek apakah promo lain dengan roti yang sama sudah ada, kecuali promo yang sedang diedit
$check_query = "SELECT * FROM promo WHERE id_roti = '$id_roti' AND id_promo != '$id_promo'";
$result = mysqli_query($koneksi, $check_query);
if (mysqli_num_rows($result) > 0) {
    echo "roti_sudah_ada";
    exit();
}

// Ambil data promo lama
$query_old_promo = "SELECT id_roti, potongan_harga FROM promo WHERE id_promo = ?";
$stmt_old_promo = $koneksi->prepare($query_old_promo);
$stmt_old_promo->bind_param("i", $id_promo);
$stmt_old_promo->execute();
$result_old_promo = $stmt_old_promo->get_result();
$promo_lama = $result_old_promo->fetch_assoc();

if (!$promo_lama) {
    die("Promo dengan ID tersebut tidak ditemukan.");
}

$id_roti_lama = $promo_lama['id_roti'];
$potongan_harga_lama = $promo_lama['potongan_harga'];

// Ambil harga roti saat ini
$query_roti = "SELECT harga FROM roti WHERE id_roti = ?";
$stmt_roti = $koneksi->prepare($query_roti);
$stmt_roti->bind_param("i", $id_roti_lama);
$stmt_roti->execute();
$result_roti = $stmt_roti->get_result();
$roti_lama = $result_roti->fetch_assoc();

if (!$roti_lama) {
    die("Roti dengan ID tersebut tidak ditemukan.");
}

$harga_roti_lama = $roti_lama['harga'];

// Kembalikan harga roti ke harga sebelum promo lama
$harga_asli = $harga_roti_lama + $potongan_harga_lama;

// Update harga roti dengan potongan harga baru
$harga_promo_baru = $harga_asli - $potongan_harga_baru;
if ($harga_promo_baru < 0) {
    die("Potongan harga tidak boleh lebih besar dari harga roti.");
}

// Update harga roti di tabel roti
$query_update_harga = "UPDATE roti SET harga = ? WHERE id_roti = ?";
$stmt_update_harga = $koneksi->prepare($query_update_harga);
$stmt_update_harga->bind_param("ii", $harga_promo_baru, $id_roti);

if (!$stmt_update_harga->execute()) {
    die("Gagal memperbarui harga roti: " . $stmt_update_harga->error);
}

// Update data promo ke tabel promo
$query_update_promo = "UPDATE promo SET id_roti = ?, potongan_harga = ? WHERE id_promo = ?";
$stmt_update_promo = $koneksi->prepare($query_update_promo);
$stmt_update_promo->bind_param("iii", $id_roti, $potongan_harga_baru, $id_promo);

if ($stmt_update_promo->execute()) {
    echo "success";
} else {
    echo "Gagal memperbarui promo: " . $stmt_update_promo->error;
}

// Tutup koneksi
$stmt_old_promo->close();
$stmt_roti->close();
$stmt_update_harga->close();
$stmt_update_promo->close();
$koneksi->close();
