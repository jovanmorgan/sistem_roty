<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_mitra = $_POST['id_mitra'] ?? '';
$nomor_pemesanan = $_POST['nomor_pemesanan'] ?? '';
$alasan = $_POST['alasan'] ?? '';

// Lakukan validasi data
if (empty($nomor_pemesanan) || empty($alasan)) {
    echo "data_tidak_lengkap";
    exit();
}

// Ambil data jumlah dan id_roti dari tabel pemesanan
$query_pemesanan = "SELECT id_roti, jumlah FROM pemesanan WHERE nomor_pemesanan = '$nomor_pemesanan'";
$result_pemesanan = mysqli_query($koneksi, $query_pemesanan);

if ($result_pemesanan && mysqli_num_rows($result_pemesanan) > 0) {
    $row_pemesanan = mysqli_fetch_assoc($result_pemesanan);
    $id_roti = $row_pemesanan['id_roti'];
    $jumlah = $row_pemesanan['jumlah'];

    // Kembalikan stok ke tabel roti
    $query_stok = "UPDATE roti SET stok = stok + '$jumlah' WHERE id_roti = '$id_roti'";
    if (!mysqli_query($koneksi, $query_stok)) {
        echo "error_stok: " . mysqli_error($koneksi);
        mysqli_close($koneksi);
        exit();
    }

    // Masukkan data ke tabel dibatalkan
    $query_dibatalkan = "INSERT INTO dibatalkan (id_mitra, nomor_pemesanan, alasan) 
                         VALUES ('$id_mitra', '$nomor_pemesanan', '$alasan')";

    if (mysqli_query($koneksi, $query_dibatalkan)) {
        // Hapus data dari tabel checkout
        $query_delete_checkout = "DELETE FROM checkout WHERE nomor_pemesanan = '$nomor_pemesanan'";
        if (mysqli_query($koneksi, $query_delete_checkout)) {
            // Hapus data dari tabel pemesanan
            echo "success";
        } else {
            echo "error_checkout: " . mysqli_error($koneksi);
        }
    } else {
        echo "error_dibatalkan: " . mysqli_error($koneksi);
    }
} else {
    echo "pemesanan_tidak_ditemukan";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
