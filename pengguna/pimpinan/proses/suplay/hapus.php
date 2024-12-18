<?php
include '../../../../keamanan/koneksi.php';

// Terima ID suplay yang akan dihapus dari formulir HTML
$id_suplay = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_suplay)) {
    echo "data_tidak_lengkap";
    exit();
}

// Ambil data id_roti dan tambah_stok dari tabel suplay
$query_suplay = "SELECT id_roti, tambah_stok FROM suplay WHERE id_suplay = '$id_suplay'";
$result_suplay = mysqli_query($koneksi, $query_suplay);

if (mysqli_num_rows($result_suplay) > 0) {
    $suplay_data = mysqli_fetch_assoc($result_suplay);
    $id_roti = $suplay_data['id_roti'];
    $tambah_stok = $suplay_data['tambah_stok'];

    // Ambil stok roti saat ini
    $query_roti = "SELECT stok FROM roti WHERE id_roti = '$id_roti'";
    $result_roti = mysqli_query($koneksi, $query_roti);

    if (mysqli_num_rows($result_roti) > 0) {
        $roti_data = mysqli_fetch_assoc($result_roti);
        $stokRoti = $roti_data['stok'];

        // Kembalikan potongan stok ke stok asli roti
        $stokSetelahPengembalian = $stokRoti - $tambah_stok;

        // Update stok di tabel roti
        $update_stok_roti = "UPDATE roti SET stok = '$stokSetelahPengembalian' WHERE id_roti = '$id_roti'";

        if (mysqli_query($koneksi, $update_stok_roti)) {
            // Buat query SQL untuk menghapus data suplay berdasarkan ID
            $query_delete_suplay = "DELETE FROM suplay WHERE id_suplay = '$id_suplay'";

            // Jalankan query untuk menghapus data suplay
            if (mysqli_query($koneksi, $query_delete_suplay)) {
                echo "success";
            } else {
                echo "error_delete_suplay";
            }
        } else {
            echo "error_update_stok";
        }
    } else {
        echo "roti_not_found";
    }
} else {
    echo "suplay_not_found";
}

// Tutup koneksi ke database
mysqli_close($koneksi);