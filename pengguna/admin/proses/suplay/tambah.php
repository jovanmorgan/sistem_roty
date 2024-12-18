<?php
include '../../../../keamanan/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_roti = $_POST['id_roti'];
    $tambah_stok = $_POST['tambah_stok'];

    // Pastikan data lengkap
    if (!empty($id_roti) && !empty($tambah_stok)) {
        // Cek apakah roti sudah disuplaysikan
        $ceksuplay = mysqli_query($koneksi, "SELECT COUNT(*) AS count FROM suplay WHERE id_roti = $id_roti");
        $suplayResult = mysqli_fetch_assoc($ceksuplay);

        if ($suplayResult['count'] < 0) {
            echo 'roti_sudah_ada';
        } else {
            // Dapatkan stok roti dari tabel roti
            $rotiQuery = mysqli_query($koneksi, "SELECT stok FROM roti WHERE id_roti = $id_roti");
            $rotiData = mysqli_fetch_assoc($rotiQuery);
            $stokRoti = $rotiData['stok'];

            // Kurangi stok dengan potongan stok dari suplay
            $stokSetelahsuplay = $stokRoti + $tambah_stok;
            if ($stokSetelahsuplay < 0) {
                $stokSetelahsuplay = 0; // Hindari stok negatif
            }

            // Update stok roti yang sudah terpotong
            $updatestok = mysqli_query($koneksi, "UPDATE roti SET stok = $stokSetelahsuplay WHERE id_roti = $id_roti");

            if ($updatestok) {
                // Tambahkan data ke tabel suplay
                $insertsuplay = mysqli_query($koneksi, "INSERT INTO suplay (id_roti, tambah_stok, stok_sebelumnya) VALUES ($id_roti, $tambah_stok, $stokRoti)");

                if ($insertsuplay) {
                    echo 'success';
                } else {
                    echo 'error_insert_suplay';
                }
            } else {
                echo 'error_update_stok';
            }
        }
    } else {
        echo 'data_tidak_lengkap';
    }
}