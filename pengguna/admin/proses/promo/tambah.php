<?php

include '../../../../keamanan/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_roti = $_POST['id_roti'];
    $potongan_harga = $_POST['potongan_harga'];

    // Pastikan data lengkap
    if (!empty($id_roti) && !empty($potongan_harga)) {
        // Cek apakah roti sudah dipromosikan
        $cekPromo = mysqli_query($koneksi, "SELECT COUNT(*) AS count FROM promo WHERE id_roti = $id_roti");
        $promoResult = mysqli_fetch_assoc($cekPromo);

        if ($promoResult['count'] > 0) {
            echo 'roti_sudah_ada';
        } else {
            // Dapatkan harga roti dari tabel roti
            $rotiQuery = mysqli_query($koneksi, "SELECT harga FROM roti WHERE id_roti = $id_roti");
            $rotiData = mysqli_fetch_assoc($rotiQuery);
            $hargaRoti = $rotiData['harga'];

            // Kurangi harga dengan potongan harga dari promo
            $hargaSetelahPromo = $hargaRoti - $potongan_harga;
            if ($hargaSetelahPromo < 0) {
                $hargaSetelahPromo = 0; // Hindari harga negatif
            }

            // Update harga roti yang sudah terpotong
            $updateHarga = mysqli_query($koneksi, "UPDATE roti SET harga = $hargaSetelahPromo WHERE id_roti = $id_roti");

            if ($updateHarga) {
                // Tambahkan data ke tabel promo
                $insertPromo = mysqli_query($koneksi, "INSERT INTO promo (id_roti, potongan_harga) VALUES ($id_roti, $potongan_harga)");

                if ($insertPromo) {
                    echo 'success';
                } else {
                    echo 'error_insert_promo';
                }
            } else {
                echo 'error_update_harga';
            }
        }
    } else {
        echo 'data_tidak_lengkap';
    }
}
