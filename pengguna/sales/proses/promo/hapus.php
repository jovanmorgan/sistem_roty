<?php
include '../../../../keamanan/koneksi.php';

// Terima ID promo yang akan dihapus dari formulir HTML
$id_promo = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_promo)) {
    echo "data_tidak_lengkap";
    exit();
}

// Ambil data id_roti dan potongan_harga dari tabel promo
$query_promo = "SELECT id_roti, potongan_harga FROM promo WHERE id_promo = '$id_promo'";
$result_promo = mysqli_query($koneksi, $query_promo);

if (mysqli_num_rows($result_promo) > 0) {
    $promo_data = mysqli_fetch_assoc($result_promo);
    $id_roti = $promo_data['id_roti'];
    $potongan_harga = $promo_data['potongan_harga'];

    // Ambil harga roti saat ini
    $query_roti = "SELECT harga FROM roti WHERE id_roti = '$id_roti'";
    $result_roti = mysqli_query($koneksi, $query_roti);

    if (mysqli_num_rows($result_roti) > 0) {
        $roti_data = mysqli_fetch_assoc($result_roti);
        $hargaRoti = $roti_data['harga'];

        // Kembalikan potongan harga ke harga asli roti
        $hargaSetelahPengembalian = $hargaRoti + $potongan_harga;

        // Update harga di tabel roti
        $update_harga_roti = "UPDATE roti SET harga = '$hargaSetelahPengembalian' WHERE id_roti = '$id_roti'";

        if (mysqli_query($koneksi, $update_harga_roti)) {
            // Buat query SQL untuk menghapus data promo berdasarkan ID
            $query_delete_promo = "DELETE FROM promo WHERE id_promo = '$id_promo'";

            // Jalankan query untuk menghapus data promo
            if (mysqli_query($koneksi, $query_delete_promo)) {
                echo "success";
            } else {
                echo "error_delete_promo";
            }
        } else {
            echo "error_update_harga";
        }
    } else {
        echo "roti_not_found";
    }
} else {
    echo "promo_not_found";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
