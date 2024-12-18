<?php
// Pastikan Anda menghubungkan ke database
include '../../../../keamanan/koneksi.php';

// Ambil data dari formulir
$id_suplay = $_POST['id_suplay']; // ID suplay yang akan diedit
$id_roti = $_POST['id_roti']; // ID roti yang dipilih
$tambah_stok_baru = $_POST['tambah_stok']; // Potongan stok baru

// Cek apakah ID suplay, ID roti, dan potongan stok tersedia
if (empty($id_suplay) || empty($id_roti) || empty($tambah_stok_baru)) {
    echo "data_tidak_lengkap";
    exit();
}

// Cek apakah suplay lain dengan roti yang sama sudah ada, kecuali suplay yang sedang diedit
$check_query = "SELECT * FROM suplay WHERE id_roti = '$id_roti' AND id_suplay != '$id_suplay'";
$result = mysqli_query($koneksi, $check_query);
if (mysqli_num_rows($result) > 0) {
    echo "roti_sudah_ada";
    exit();
}

// Ambil data suplay lama
$query_old_suplay = "SELECT id_roti, tambah_stok FROM suplay WHERE id_suplay = ?";
$stmt_old_suplay = $koneksi->prepare($query_old_suplay);
$stmt_old_suplay->bind_param("i", $id_suplay);
$stmt_old_suplay->execute();
$result_old_suplay = $stmt_old_suplay->get_result();
$suplay_lama = $result_old_suplay->fetch_assoc();

if (!$suplay_lama) {
    die("suplay dengan ID tersebut tidak ditemukan.");
}

$id_roti_lama = $suplay_lama['id_roti'];
$tambah_stok_lama = $suplay_lama['tambah_stok'];

// Ambil stok roti saat ini
$query_roti = "SELECT stok FROM roti WHERE id_roti = ?";
$stmt_roti = $koneksi->prepare($query_roti);
$stmt_roti->bind_param("i", $id_roti_lama);
$stmt_roti->execute();
$result_roti = $stmt_roti->get_result();
$roti_lama = $result_roti->fetch_assoc();

if (!$roti_lama) {
    die("Roti dengan ID tersebut tidak ditemukan.");
}

$stok_roti_lama = $roti_lama['stok'];

// Kembalikan stok roti ke stok sebelum suplay lama
$stok_asli = $stok_roti_lama - $tambah_stok_lama;

// Update stok roti dengan potongan stok baru
$stok_suplay_baru = $stok_asli + $tambah_stok_baru;
if ($stok_suplay_baru < 0) {
    die("Potongan stok tidak boleh lebih besar dari stok roti.");
}

// Update stok roti di tabel roti
$query_update_stok = "UPDATE roti SET stok = ? WHERE id_roti = ?";
$stmt_update_stok = $koneksi->prepare($query_update_stok);
$stmt_update_stok->bind_param("ii", $stok_suplay_baru, $id_roti);

if (!$stmt_update_stok->execute()) {
    die("Gagal memperbarui stok roti: " . $stmt_update_stok->error);
}

// Update data suplay ke tabel suplay
$query_update_suplay = "UPDATE suplay SET id_roti = ?, tambah_stok = ? WHERE id_suplay = ?";
$stmt_update_suplay = $koneksi->prepare($query_update_suplay);
$stmt_update_suplay->bind_param("iii", $id_roti, $tambah_stok_baru, $id_suplay);

if ($stmt_update_suplay->execute()) {
    echo "success";
} else {
    echo "Gagal memperbarui suplay: " . $stmt_update_suplay->error;
}

// Tutup koneksi
$stmt_old_suplay->close();
$stmt_roti->close();
$stmt_update_stok->close();
$stmt_update_suplay->close();
$koneksi->close();
