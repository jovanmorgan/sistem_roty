<?php
// Kodingan Pemesanan

include '../../../../keamanan/koneksi.php';

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

// Terima data dari formulir HTML
$id_roti = $_POST['id_roti'] ?? '';
$id_mitra = $_POST['id_mitra'] ?? '';
$total = $_POST['total'] ?? '';
$jumlah = $_POST['jumlah'] ?? '';
$waktu = date('Y-m-d H:i:s');
$nomor_pemesanan = generateNomorPemesanan();
$status = "belum_bayar";

// Hapus titik dan koma dari total
$total = str_replace([',', '.'], '', $total);

// Validasi data
if (empty($id_roti) || empty($id_mitra) || empty($total) || empty($jumlah)) {
    echo "data_tidak_lengkap";
    exit();
}

// Cek stok roti dari tabel roti
$query_stok = "SELECT stok FROM roti WHERE id_roti = '$id_roti'";
$result_stok = mysqli_query($koneksi, $query_stok);

if ($result_stok && mysqli_num_rows($result_stok) > 0) {
    $row = mysqli_fetch_assoc($result_stok);
    $stok_tersedia = $row['stok'];

    if ($stok_tersedia >= $jumlah) {
        $stok_baru = $stok_tersedia - $jumlah;
        $query_update_roti = "UPDATE roti SET stok = '$stok_baru' WHERE id_roti = '$id_roti'";
        mysqli_query($koneksi, $query_update_roti);

        $query_insert_pemesanan = "INSERT INTO pemesanan (id_roti, id_mitra, nomor_pemesanan, total, jumlah, waktu) 
                                       VALUES ('$id_roti', '$id_mitra', '$nomor_pemesanan', '$total', '$jumlah', '$waktu')";

        if (mysqli_query($koneksi, $query_insert_pemesanan)) {
            $query_insert_checkout = "INSERT INTO checkout (id_mitra, nomor_pemesanan, status) VALUES ('$id_mitra', '$nomor_pemesanan', '$status')";
            mysqli_query($koneksi, $query_insert_checkout);

            echo "success:" . $nomor_pemesanan;
        } else {
            echo "error: " . mysqli_error($koneksi);
        }
    } else {
        echo "stok_tidak_cukup";
    }
} else {
    echo "error: " . mysqli_error($koneksi);
}

mysqli_close($koneksi);
