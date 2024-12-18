<?php

include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_keranjang = $_POST['id_keranjang'];
$id_roti = $_POST['id_roti'];
$id_mitra = $_POST['id_mitra'];
$jumlah = $_POST['jumlah'];
$harga = $_POST['harga'];
$total = $_POST['total'];
$waktu = date('Y-m-d H:i:s');

// Lakukan validasi data
if (empty($id_roti) || empty($id_mitra) || empty($id_keranjang) || empty($jumlah) || empty($harga)) {
    echo "data_tidak_lengkap";
    exit();
}

$success = true;

// Fungsi untuk menghasilkan nomor pemesanan dengan huruf dan angka acak
function generateNomorPemesanan($length = 2)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    $randomNumber = rand(1000, 9999);
    return $randomString . '-' . $randomNumber;
}

// Generate nomor pemesanan baru
do {
    $status = "belum_bayar";
    $nomor_pemesanan = generateNomorPemesanan();
    $query_cek_nomor = "SELECT nomor_pemesanan FROM pemesanan WHERE nomor_pemesanan = '$nomor_pemesanan'";
    $result_cek_nomor = mysqli_query($koneksi, $query_cek_nomor);
} while (mysqli_num_rows($result_cek_nomor) > 0);  // Ulangi sampai nomor pemesanan unik ditemukan

// Array untuk menyimpan semua id_pemesanan yang berhasil disimpan
$id_pemesanan_array = [];

for ($i = 0; $i < count($id_keranjang); $i++) {
    $current_id_keranjang = $id_keranjang[$i];
    $current_id_roti = $id_roti[$i];
    $current_jumlah = $jumlah[$i];
    $current_harga = $harga[$i];
    $current_total = $total[$i];
    $current_id_mitra = $id_mitra[$i];

    // Ambil stok saat ini dari tabel roti berdasarkan id_roti
    $query_stok = "SELECT stok FROM roti WHERE id_roti = '$current_id_roti'";
    $result_stok = mysqli_query($koneksi, $query_stok);

    if ($result_stok && mysqli_num_rows($result_stok) > 0) {
        $row_stok = mysqli_fetch_assoc($result_stok);
        $stok_sekarang = $row_stok['stok'];

        // Periksa apakah stok cukup
        if ($stok_sekarang === 0 || $stok_sekarang < $current_jumlah) {
            echo "stok_tidak_cukup";
            $success = false;
            break;
        }

        // Mulai transaksi
        mysqli_begin_transaction($koneksi);

        try {
            // Insert ke tabel pemesanan dengan nomor_pemesanan
            $query_update_pemesanan = "INSERT INTO pemesanan (nomor_pemesanan, id_roti, id_mitra, jumlah, total, waktu) 
                                       VALUES ('$nomor_pemesanan', '$current_id_roti', '$current_id_mitra', '$current_jumlah', '$current_total', '$waktu')";
            mysqli_query($koneksi, $query_update_pemesanan);

            // Ambil id_pemesanan terakhir yang dimasukkan
            $id_pemesanan = mysqli_insert_id($koneksi);
            $id_pemesanan_array[] = $id_pemesanan;

            // Kurangi stok di tabel roti
            $stok_baru = $stok_sekarang - $current_jumlah;
            $query_update_roti = "UPDATE roti SET stok = '$stok_baru' WHERE id_roti = '$current_id_roti'";
            mysqli_query($koneksi, $query_update_roti);

            // Hapus dari keranjang
            $query_delete_keranjang = "DELETE FROM keranjang WHERE id_keranjang = '$current_id_keranjang'";
            mysqli_query($koneksi, $query_delete_keranjang);

            // Commit transaksi
            mysqli_commit($koneksi);
        } catch (Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            mysqli_rollback($koneksi);
            echo "error: transaksi gagal";
            $success = false;
            break;
        }
    } else {
        echo "error: roti tidak ditemukan";
        $success = false;
        break;
    }
}

if ($success) {
    // Masukkan nomor_pemesanan ke dalam tabel checkout
    $query_insert_checkout = "INSERT INTO checkout (id_mitra, nomor_pemesanan, status) VALUES ('$current_id_mitra', '$nomor_pemesanan', '$status')";
    mysqli_query($koneksi, $query_insert_checkout);

    echo "success:" . $nomor_pemesanan;
}

// Tutup koneksi ke database
mysqli_close($koneksi);
