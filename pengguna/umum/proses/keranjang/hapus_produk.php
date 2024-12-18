<?php
// Menghubungkan ke database
include '../../../../keamanan/koneksi.php';

// Memeriksa apakah ada data produk yang dipilih untuk dihapus
if (isset($_POST['selected_products'])) {
    $selectedProducts = $_POST['selected_products'];

    foreach ($selectedProducts as $index) {
        // Mengambil ID keranjang dari hidden input yang sesuai
        $id_keranjang = $_POST['id_keranjang'][$index];

        // Query untuk menghapus produk dari keranjang berdasarkan ID keranjang
        $query = "DELETE FROM keranjang WHERE id_keranjang = '$id_keranjang'";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            echo 'error:Gagal menghapus produk dari keranjang.';
            exit;
        }
    }

    echo 'success:Produk berhasil dihapus dari keranjang.';
} else {
    echo 'error:Tidak ada produk yang dipilih untuk dihapus.';
}

// Menutup koneksi database
mysqli_close($koneksi);
