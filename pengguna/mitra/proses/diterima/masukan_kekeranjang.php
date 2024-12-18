<?php
session_start();
include '../../../../keamanan/koneksi.php';

if (isset($_POST['id_mitra']) && isset($_POST['nomor_pemesanan'])) {
    $id_mitra = mysqli_real_escape_string($koneksi, $_POST['id_mitra']);
    $nomor_pemesanan = mysqli_real_escape_string($koneksi, $_POST['nomor_pemesanan']);
    $waktu = date('Y-m-d H:i:s');

    // Ambil data pemesanan
    $query = "
        SELECT p.id_roti, p.jumlah, r.stok, r.harga
        FROM pemesanan p
        JOIN roti r ON p.id_roti = r.id_roti
        WHERE p.nomor_pemesanan = '$nomor_pemesanan'
    ";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        echo 'error';
        exit();
    }

    $success = true;
    while ($row = mysqli_fetch_assoc($result)) {
        $id_roti = $row['id_roti'];
        $jumlah = $row['jumlah'];
        $stok = $row['stok'];
        $harga = $row['harga'];

        // Cek stok
        if ($stok >= $jumlah) {
            // Tambah atau update keranjang
            $cek_keranjang = "
                SELECT * FROM keranjang
                WHERE id_roti = '$id_roti' AND id_mitra = '$id_mitra'
            ";
            $cek_result = mysqli_query($koneksi, $cek_keranjang);

            if (mysqli_num_rows($cek_result) > 0) {
                // Update jumlah di keranjang
                $update = "
                    UPDATE keranjang
                    SET jumlah = jumlah + $jumlah
                    WHERE id_roti = '$id_roti' AND id_mitra = '$id_mitra'
                ";
                if (!mysqli_query($koneksi, $update)) {
                    $success = false;
                    break;
                }
            } else {
                $total = $jumlah * $harga;
                // Masukkan data ke keranjang
                $insert = "
                    INSERT INTO keranjang (id_roti, id_mitra, waktu, jumlah, total)
                    VALUES ('$id_roti', '$id_mitra', '$waktu', '$jumlah', '$total')
                ";
                if (!mysqli_query($koneksi, $insert)) {
                    $success = false;
                    break;
                }
            }
        } else {
            echo 'stok_tidak_cukup';
            exit();
        }
    }

    if ($success) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'data_tidak_lengkap';
}
