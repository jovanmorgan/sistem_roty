<?php

include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_roti = $_POST['id_roti'];
$id_mitra = $_POST['id_mitra'];
$total = $_POST['total'];
$jumlah = $_POST['jumlah'];
$waktu = date('Y-m-d H:i:s');

// Hapus titik dan koma dari total
$total = str_replace([',', '.'], '', $total);

// Lakukan validasi data
if (empty($id_roti) || empty($id_mitra) || empty($total) || empty($jumlah)) {
    echo "data_tidak_lengkap";
    exit();
}

// Cek stok roti dari tabel roti
$query_stok = "SELECT stok FROM roti WHERE id_roti = '$id_roti'";
$result_stok = mysqli_query($koneksi, $query_stok);

if ($result_stok) {
    $row = mysqli_fetch_assoc($result_stok);
    $stok_tersedia = $row['stok'];

    // Cek apakah stok cukup
    if ($stok_tersedia >= $jumlah) {

        if ($stok_tersedia == 0) {
            echo "stok_tidak_cukup";
            exit();
        }

        // Cek apakah id_roti sudah ada di dalam keranjang untuk id_mitra ini
        $query_cek_keranjang = "SELECT * FROM keranjang WHERE id_roti = '$id_roti' AND id_mitra = '$id_mitra'";
        $result_cek_keranjang = mysqli_query($koneksi, $query_cek_keranjang);

        if (mysqli_num_rows($result_cek_keranjang) > 0) {
            // Jika ada, update jumlah dan total
            $row_keranjang = mysqli_fetch_assoc($result_cek_keranjang);
            $jumlah_baru = $row_keranjang['jumlah'] + $jumlah;
            $total_baru = $row_keranjang['total'] + (int)$total; // Konversi $total menjadi integer

            if ($jumlah_baru > $stok_tersedia) {
                echo "stok_dikeranjang_masih_ada";
                exit();
            } else {
                $query_update_keranjang = "UPDATE keranjang 
                                           SET jumlah = '$jumlah_baru', total = '$total_baru', waktu = '$waktu' 
                                           WHERE id_keranjang = '" . $row_keranjang['id_keranjang'] . "'";

                if (mysqli_query($koneksi, $query_update_keranjang)) {
                    echo "success_update";
                } else {
                    echo "error: " . mysqli_error($koneksi);
                }
            }
        } else {
            // Jika tidak ada, tambahkan data baru
            $query_insert_keranjang = "INSERT INTO keranjang (id_roti, id_mitra, total, jumlah, waktu) 
                                           VALUES ('$id_roti', '$id_mitra', '$total', '$jumlah', '$waktu')";

            if (mysqli_query($koneksi, $query_insert_keranjang)) {
                echo "success";
            } else {
                echo "error: " . mysqli_error($koneksi);
            }
        }
    } else {
        // Stok tidak cukup
        echo "stok_tidak_cukup";
    }
} else {
    echo "error: " . mysqli_error($koneksi);
}

// Tutup koneksi ke database
mysqli_close($koneksi);
