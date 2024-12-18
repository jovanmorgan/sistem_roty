<?php

include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_keranjang = $_POST['id_keranjang'];
$id_roti = $_POST['id_roti'];
$jumlah = $_POST['jumlah'];
$harga = $_POST['harga'];

// Lakukan validasi data
if (empty($id_keranjang) || empty($id_roti) || empty($jumlah) || empty($harga)) {
    echo "data_tidak_lengkap";
    exit();
}

$success = true;

// Proses setiap item dalam array
for ($i = 0; $i < count($id_keranjang); $i++) {
    $current_id_keranjang = $id_keranjang[$i];
    $current_id_roti = $id_roti[$i];
    $current_jumlah = $jumlah[$i];
    $current_harga = $harga[$i];

    if ($current_jumlah == 0) {
        // Jika jumlah 0, hapus item dari keranjang
        $query_delete_keranjang = "DELETE FROM keranjang WHERE id_keranjang = '$current_id_keranjang'";

        if (!mysqli_query($koneksi, $query_delete_keranjang)) {
            error_log("Error deleting keranjang: " . mysqli_error($koneksi));
            echo "error: " . mysqli_error($koneksi);
            $success = false;
            break;
        }
    } else {
        // Ambil stok saat ini dari tabel roti berdasarkan id_roti
        $query_stok = "SELECT stok FROM roti WHERE id_roti = '$current_id_roti'";
        $result_stok = mysqli_query($koneksi, $query_stok);

        if ($result_stok && mysqli_num_rows($result_stok) > 0) {
            $row_stok = mysqli_fetch_assoc($result_stok);
            $stok_sekarang = $row_stok['stok'];

            // Debugging
            error_log("ID Keranjang: $current_id_keranjang, ID Roti: $current_id_roti, Jumlah: $current_jumlah, Stok Sekarang: $stok_sekarang");

            // Periksa apakah stok cukup
            if ($stok_sekarang < $current_jumlah) {
                echo "stok_tidak_cukup";
                $success = false;
                break;
            } else {
                $total = $current_jumlah * $current_harga;
                $query_update_keranjang = "UPDATE keranjang SET jumlah = '$current_jumlah', total = '$total' WHERE id_keranjang = '$current_id_keranjang'";

                if (!mysqli_query($koneksi, $query_update_keranjang)) {
                    error_log("Error updating keranjang: " . mysqli_error($koneksi));
                    echo "error: " . mysqli_error($koneksi);
                    $success = false;
                    break;
                }
            }
        } else {
            echo "error: roti tidak ditemukan";
            $success = false;
            break;
        }
    }
}

if ($success) {
    echo "success";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
